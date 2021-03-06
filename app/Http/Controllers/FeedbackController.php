<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\Mail\FeedbackMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class FeedbackController extends Controller
{

    public function index()
    {
        return view('all-feedbacks');
    }

    public function getFeedbackAjax()
    {
        
        $feedbacks = DataTables::of(Feedback::with('user'))
                ->addColumn('user', function($item){
                    return $item->user->name . " " . $item->user->surname;
                })
                ->editColumn('description', function($item){
                    return Str::limit($item->description, 25);
                })
                ->addColumn('attachment', function($item){
                    if(is_null($item->attachment)){
                        return '<button type="button" class="btn btn-primary" disabled>завантажити</button>';
                    }
                    return '<a href="'.  Storage::url($item->attachment) .'" target="_blank" class="btn btn-primary" disabled>завантажити</button>';
                })
                ->addColumn('action', function($item){
                    return '
                    <a href="' . route('feedbacks.show', ['feedback' => $item->id]) . '" target="_blank" class="btn btn-success">відповісти</button>
                    ';
                })
                ->rawColumns(['attachment', 'action'])
                ->make(true);

        return $feedbacks;
    }


    public function create()
    {
        return view('feedback');
    }

    public function store(Request $request)
    {
        $valid = $request->validate([
            'title' => ['required', 'min:4', 'max:255'],
            'email' => ['sometimes', 'required', 'string', 'email', 'max:255'],
            'description' => ['required', 'string', 'min:10', 'max:40000']
        ]);

        if(isset($request['attachment'])){
            $valid['attachment'] = Storage::putFile('public/feedback', $request['attachment']);
        }

        $valid['user_id'] = Auth::user()->id; 

        Feedback::create($valid);

        return back()->with('create', 'Ваше повідомлення відправлено! Найближчим часом відповідь прийде вам на пошту.');
    }

    public function show($id)
    {
        $feedback = Feedback::findOrFail($id);

        return view('feedback-answer', compact('feedback'));
    }

    public function answer(Request $request)
    {
        $valid = $request->validate([
            'description' => ['required', 'string', 'min:10', 'max:40000']
        ]);

        $feedback_old = Feedback::findOrFail($request->input('id'));

        $feedback = (object) '';
        $feedback->user_name = $feedback_old->user->username;
        $feedback->title = $feedback_old->title;
        $feedback->answer = $valid['description'];
        
        try { 

            Mail::to($feedback_old->user->email)->send(new FeedbackMail($feedback));

            $feedback_old->delete();

            return redirect()->route('feedbacks.index');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->route('feedbacks.index');
        }

        return redirect()->route('feedbacks.index');
    }

}
