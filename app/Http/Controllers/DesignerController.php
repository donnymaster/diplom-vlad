<?php

namespace App\Http\Controllers;

use App\DesignPerformer;
use App\Services\ServiceFilterItems;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

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
    public function index(Request $request)
    {
        // добавить сортировку элементов
        $designers = ServiceFilterItems::filter(
            DesignPerformer::class, 
            $request->all())->withPath('designers');

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

        $valid['rating'] = 0.0;

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
        $designer = DesignPerformer::findOrFail($id);

        return view('edit-designer', compact('designer'));
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
        $designer = DesignPerformer::findOrFail($id);
         // валидация того что пришло и создания
        $valid = $request->validate([
            'name' => ['required', 'min:4', 'max:255'],
            'surname' => ['required', 'min:4', 'max:255'],
            'description' => ['required', 'string', 'min:10', 'max:40000'],
            'design_type_id' => ['required', 'integer', 'exists:design_types,id']
        ]); 

        try {
            if(isset($request['avatar-logo'])){
                if($designer->avatar != ""){
                    // delete designer avatar old
                    Storage::delete('public/designers/' . explode('/', $designer->avatar)[2]);
                }
                $valid['avatar'] = Storage::putFile('public/designers', $request['avatar-logo']);
            }

            $designer->update($valid);

        } catch (\Throwable $th) {
            return back()->with('update', $th->getMessage());
        }

        return back()->with('update', 'Дизайнер оновлений');
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

    public function alldesigerAdmin()
    {
        return view('admin-desgners');
    }

    public function alldesigerAdminAjax(Request $request)
    {
        
        $designers = DataTables::of(
            DesignPerformer::with('typeDesign')->select('design_performer.*'))
                ->addColumn('typeDesign', function($item){
                    return $item->typeDesign->design_name;
                })
                ->editColumn('description', function($item){
                    return Str::limit($item->description, 25);
                })
                ->addColumn('action', function($item){
                    return '
                    <a href="' . route('designers.edit', ['designer' => $item->id]) . '" target="_blank" class="btn btn-success">редагувати</button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);

        return $designers;
            
    }

}
