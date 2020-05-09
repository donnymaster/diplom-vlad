<?php

namespace App\Http\Controllers;

use App\DesignPerformer;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DesignerController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only([
            'create',
            'store',
            'edit',
            'update',
            'destroy'
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // добавить сортировку элементов
        $designers = DesignPerformer::paginate(15);

        return view('designers', compact('designers')); // вывод всех дизайнеров
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // форма создания
        return view('create-designer');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // валидация того что пришло и создания
        $valid = $request->validate([
            'name' => ['required', 'min:4', 'max:255'],
            'surname' => ['required', 'min:4', 'max:255'],
            'description' => ['required', 'string', 'min:10', 'max:40000'],
            'design_type_id' => ['required', 'integer', 'exists:design_types,id'],
            'avatar-logo' => ['required', 'file']
        ]); 

        try {
            $valid['avatar'] = Storage::putFile('public/designers', $valid['avatar-logo']);

            DesignPerformer::create($valid);
        } catch (\Throwable $th) {
            return back()->with('create', $th->getMessage());
        }

        return back()->with('create', 'Дизайнер доданий');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $designer = DesignPerformer::findOrFail($id);

        return view('designer', compact('designer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // форма редактирования
        return view('edit-designer');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         // валидация того что пришло и редактирование
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $designer = DesignPerformer::findOrFail($id);

        $designer->delete();

        return back()->with('delete', 'Дизайнер був видалений');
    }

    public function getDesignersAjax(Request $request)
    {
        $data = DesignPerformer::select("name", "surname", "id")
                ->where([
                    ["name","LIKE","%{$request->input('query')}%"],
                    ["design_type_id", "=", $request->input('type_disegn')]
                ])
                ->get();
        return response()->json($data);
    }
}
