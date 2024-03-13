<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\ClientMovementController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function index(){
        return view('pages.order.index');
    }

    public function getOrders(Request $request){

        if(isset($request->search)){
            $search = $request->search;
            $orders = Order::select(
                'orders.id',
                'orders.order_date',
                'orders.total',
                'orders.client_id',
                DB::raw('CONCAT(clients.company, " - ", clients.name, " ", clients.lastname) AS client')
            )
            ->join('clients', 'clients.id', '=', 'orders.client_id')
            ->where(function($query) use($search) {
                $query->where('clients.name', 'like', '%'.$search.'%')
                ->orWhere('clients.lastname', 'like', '%'.$search.'%')
                ->orWhere('clients.company', 'like', '%'.$search.'%')
                ->orWhere('orders.id', 'like', '%'.$search.'%');
            })
            ->orderBy('orders.order_date', 'DESC')
            ->orderBy('orders.id', 'DESC');
        }else{
            $orders = Order::select(
                'orders.id',
                'orders.order_date',
                'orders.total',
                'orders.client_id',
                DB::raw('CONCAT(clients.company, " - ", clients.name, " ", clients.lastname) AS client')
            )
            ->join('clients', 'clients.id', '=', 'orders.client_id')
            ->orderBy('orders.order_date', 'DESC')
            ->orderBy('orders.id', 'DESC');
        }

        return $orders->paginate(10);

    }

    public function store(Request $request){
        
        try {

            DB::beginTransaction();

            if(isset($request->id)){
                // Pendiente
            }else{

                $order = new Order();
                $order->client_id = $request->client_id;
                $order->order_date = $request->order_date;
                $order->save();
                
                $total = 0;

                // Create order details
                foreach (json_decode($request->products) as $product) {
                    
                    $result = OrderDetailController::createOrderDetail(
                        $order->id, 
                        $request->client_id,
                        $product->id, 
                        $product->quantity, 
                        $product->price
                    );

                    if($result->code == 500){
                        DB::commit();
                        return response()->json([
                            'message' => "Ocurrió un error al guardar los detalles del pedido ".$result->message,
                            'code' => 500,
                        ]);
                    }

                    $total += floatval($product->quantity*$product->price);

                }

                // Create client movement
                $result = ClientMovementController::createClientMovement($request->client_id, 'PEDIDO', $request->order_date, $total, $order->id);

                if($result->code == 500){
                    DB::commit();
                    return response()->json([
                        'message' => "Ocurrió un error al procesar los datos. ".$result->message,
                        'code' => 500,
                    ]);
                }

                $order->total = $total;
                $order->save();

            }

            DB::commit();
            
            return response()->json([
                'message' => "¡Pedido generado correctamente!",
                'code' => 200,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
                'code' => 500,
            ]);
        }

    }


    public function delete(Request $request){

        try {

            // Validación permiso
            if(!auth()->user()->superuser){
                return response()->json([
                    'message' => "No tienes los permisos para realizar esta operación",
                    'code' => 500,
                ]);
            }

            // Validación
            $this->validate($request, [
                'cancel_date' => 'required|date'
            ]);

            DB::beginTransaction();
            $order = Order::find($request->id);

            // Create client movement
            $result = ClientMovementController::createClientMovement(
                $order->client_id, 
                'CANCELACION', 
                $request->cancel_date, 
                $order->total,
                $order->id
            );

            if($result->code == 500){
                DB::commit();
                return response()->json([
                    'message' => "Ocurrió un error al procesar los datos. ".$result->message,
                    'code' => 500,
                ]);
            }

            foreach ($order->orderDetails as $key => $detail) {
                ProductController::ajustInventory($detail->product_id, $detail->quantity, 0);
                $detail->delete();
            }

            $order->delete();
            DB::commit();
            
            return response()->json([
                'message' => "¡Pedido cancelado con exito!",
                'code' => 200,
            ]);

        }catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
                'code' => 500,
            ]);
        }

    }



}
