<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\DB;

class OrderDetailController extends Controller
{
    
    public function index(){
        return view('pages.orderDetail.index');
    }

    public function getOrderDetails(Request $request){

        if(isset($request->search)){
            $search = $request->search;
            $orderDetails = OrderDetail::select(
                'order_details.id',
                'order_details.unit_price',
                'order_details.quantity',
                'order_details.total',
                DB::raw('CONCAT(
                    categories.name, " ",
                    brands.name, " ",
                    product_types.name, " ",
                    materials.name, " ",
                    product_measures.value, " ",
                    product_librages.value, " ",
                    products.weight
                ) AS description')
            )
            ->join('products', 'products.id', '=', 'order_details.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('product_types', 'product_types.id', '=', 'products.product_type_id')
            ->join('product_measures', 'product_measures.id', '=', 'products.product_measure_id')
            ->join('materials', 'materials.id', '=', 'products.material_id')
            ->join('product_librages', 'product_librages.id', '=', 'products.product_librage_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->where('order_details.order_id', $request->id)
            ->where(DB::raw('CONCAT(
                categories.name, " ",
                brands.name, " ",
                product_types.name, " ",
                materials.name, " ",
                product_measures.value, " ",
                product_librages.value, " ",
                products.weight
            )'), 'LIKE', "%".$search."%");
        }else{
            $orderDetails = OrderDetail::select(
                'order_details.id',
                'order_details.unit_price',
                'order_details.quantity',
                'order_details.total',
                DB::raw('CONCAT(
                    categories.name, " ",
                    brands.name, " ",
                    product_types.name, " ",
                    materials.name, " ",
                    product_measures.value, " ",
                    product_librages.value, " ",
                    products.weight
                ) AS description')
            )
            ->join('products', 'products.id', '=', 'order_details.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('product_types', 'product_types.id', '=', 'products.product_type_id')
            ->join('product_measures', 'product_measures.id', '=', 'products.product_measure_id')
            ->join('materials', 'materials.id', '=', 'products.material_id')
            ->join('product_librages', 'product_librages.id', '=', 'products.product_librage_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->where('order_details.order_id', $request->id);
        }

        return $orderDetails->paginate(10);

    }

    public static function createOrderDetail($idOrder, $idClient, $idProduct, $quantity, $price){

        try {
            
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $idOrder;
            $orderDetail->client_id = $idClient;
            $orderDetail->product_id = $idProduct;
            $orderDetail->unit_price = $price;
            $orderDetail->quantity = $quantity;
            $orderDetail->total = floatval($price*$quantity);

            $result = ProductController::ajustInventory($idProduct, 0, $quantity);

            if($result->code == 500){
                return (object) [
                    'message' => "Error descontando inventario",
                    'code' => 500
                ];
            }

            $orderDetail->save();

            return (object) [
                'message' => "Detalle guardado correctamente",
                'code' => 200
            ];

        } catch (\Exception $e) {
            return (object) [
                'message' => $e->getMessage(),
                'code' => 500
            ];
        }

    }

}
