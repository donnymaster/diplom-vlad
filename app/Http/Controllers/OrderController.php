<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    public function __construct()
    {
        // $this->middleware('admin')->only([
        //     'edit',
        //     'update'
        // ]);  
        $this->middleware('auth')->only([
            'index',
            'create',
            'store'
        ]) ;
    }

    public function index(Request $request)
    {
        return view('user-orders');
    }

    public function orderAjaxUser(Request $request)
    {
        $user_id = Auth::user()->id;

        $orders = DataTables::of(
            Order::where('customer_id','=',$user_id)
                    ->with(['designer', 'typeDesign'])->select('order.*'))
                ->addColumn('designer', function($item){
                    return $item->designer->name . " " . $item->designer->surname;
                })
                ->addColumn('typeDesign', function($item){
                    return $item->typeDesign->design_name;
                })
                ->editColumn('description', function($item){
                    return Str::limit($item->description, 25);
                })
                ->filterColumn('designer', function($query, $keyword) {
                    $query->havingRaw('LOWER(designer) LIKE ?', ["%{$keyword}%"]);
                })
                ->addColumn('action', function($item){
                    return '
                    <a href="' . route('orders.show', ['order' => $item->id]) . '" target="_blank" class="btn btn-success">відкрити</button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);

        return $orders;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // форма создания заказа
        return view('order-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = $request->validate([
            'design_type_id' => ['required', 'integer', 'exists:design_types,id'],
            'design_performer_id' => ['required', 'integer', 'exists:design_performer,id'],
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'string', 'min:10', 'max:40000'],
            'cost' => ['required', 'integer']
        ]);
        $valid['customer_id'] = Auth::user()->id;
        $valid['broadcast_identifier'] = Str::uuid();
        
        Order::create($valid);

        return back()->with('create', 'замовлення створено');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
        // and more models

        return view('order');
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Order::class); // policy

        $order = Order::findOrFail($id);

        $order->delete();

        return back()->with('delete', 'Замовлення видалено');
        
    }
}
