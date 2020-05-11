<?php

namespace App\Http\Controllers;

use App\DesignPerformer;
use App\Order;
use App\OrderCompleted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only([
            'adminOdersShowAjax',
            'adminOdersShow',
            'update'
        ]);  
        $this->middleware('auth')->only([
            'index',
            'create',
            'store',
            'show',
            'orderAjaxUser'
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

        if(isset($request['attachment'])){

            $valid['attachment'] = Storage::putFile('public/order', $request['attachment']);
            
        }
        
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

        $this->authorize('view', [$order]); // policy

        $order_completed = OrderCompleted::where('order_id','=', $id)->first();

        return view('order', compact('order', 'order_completed'));
    }

    public function update(Request $request, $id)
    {
        $valid = $request->validate([
            'design_type_id' => ['required', 'integer', 'exists:design_types,id'],
            'design_performer_id' => ['required', 'integer', 'exists:design_performer,id'],
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'string', 'min:10', 'max:40000'],
            'cost' => ['required', 'integer']
        ]);

        $order = Order::where('id', '=', $id)->first();

        try {
            if(isset($request['attachment'])){
                if($order->attachment != ""){
                    // delete order attachment old
                    Storage::delete('public/orders/' . explode('/', $order->attachment)[2]);
                }
                $valid['attachment'] = Storage::putFile('public/order', $request['attachment']);
            }

            $order->update($valid);

        } catch (\Throwable $th) {
            return back();
        }

        return back();

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        $this->authorize('view', [$order]); // policy

        $order->delete();

        return back()->with('delete', 'Замовлення видалено');
        
    }

    public function adminOdersShow()
    {
        return view('admin-orders');
    }

    public function adminOdersShowAjax()
    {
        $orders = DataTables::of(
            Order::with(['designer', 'typeDesign'])->select('order.*'))
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

    public function endOrder(Request $request)
    {
        $valid = $request->validate([
            'order_id' =>  ['required', 'integer', 'exists:order,id'],
            'design_performer' => ['required', 'integer', 'exists:design_performer,id'],
            'attachment' => ['required', 'file']
        ]);

        $valid['attachment'] = Storage::putFile('public/order', $valid['attachment']);

        OrderCompleted::create($valid);

        return back();
        
    }

    public function ratingSet(Request $request)
    {
        // dd($request->all());

        $order_completed = OrderCompleted::where('order_id', '=', $request->input('order_id'))->first();

        $order_completed->update([
            'rating' => $request->input('rating')
        ]);

        $result = DB::select('select avg(rating) as rating from order_completed where design_performer = ?', [$order_completed->design_performer])[0]->rating;
        
        $designer = DesignPerformer::where('id', '=', $order_completed->design_performer)->first();
        $designer->update([
            'rating' => $result
        ]);
        return back();
    }

}
