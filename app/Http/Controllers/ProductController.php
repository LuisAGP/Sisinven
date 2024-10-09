<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductType;
use App\Models\ProductMeasure;
use App\Models\Material;
use App\Models\ProductLibrage;
use App\Models\Brand;

class ProductController extends Controller
{

    public function index(){
        return view('pages.product.index');
    }

    public function getProducts(Request $request){

        $excludes = [];

        if(isset($request->exclude)){
            $excludes = explode('|', $request->exclude);
        }

        if(isset($request->search)){
            $search = $request->search;
            $products = Product::select(
                'categories.name AS category',
                'product_types.name AS type', 
                'product_measures.value AS measure',
                'materials.name AS material',
                'product_librages.value AS librage',
                'brands.name AS brand',
                'products.quantity',
                'products.weight',
                'products.unit_price',
                'products.sale_price',
                'products.ubication',
                'products.checking_date',
                'products.image',
                'products.id'
            )
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('product_types', 'product_types.id', '=', 'products.product_type_id')
            ->join('product_measures', 'product_measures.id', '=', 'products.product_measure_id')
            ->join('materials', 'materials.id', '=', 'products.material_id')
            ->join('product_librages', 'product_librages.id', '=', 'products.product_librage_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->whereNotIn('products.id', $excludes)
            ->where(function($query) use($search) {
                $query->where('categories.name', 'like', '%'.$search.'%')
                ->orWhere('product_types.name', 'like', '%'.$search.'%')
                ->orWhere('materials.name', 'like', '%'.$search.'%')
                ->orWhere('brands.name', 'like', '%'.$search.'%')
                ->orWhere('products.ubication', 'like', '%'.$search.'%')
                ->orWhere('product_measures.value', 'like', '%'.$search.'%')
                ->orWhere('product_librages.value', 'like', '%'.$search.'%')
                ->orWhere('products.quantity', '=', $search)
                ->orWhere('products.unit_price', '=', $search)
                ->orWhere('products.sale_price', '=', $search);
            })
            ->orderBy('products.created_at');
        }else{
            $products = Product::select(
                'categories.name AS category',
                'product_types.name AS type', 
                'product_measures.value AS measure',
                'materials.name AS material',
                'product_librages.value AS librage',
                'brands.name AS brand',
                'products.quantity',
                'products.weight',
                'products.unit_price',
                'products.sale_price',
                'products.ubication',
                'products.checking_date',
                'products.image',
                'products.id'
            )
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('product_types', 'product_types.id', '=', 'products.product_type_id')
            ->join('product_measures', 'product_measures.id', '=', 'products.product_measure_id')
            ->join('materials', 'materials.id', '=', 'products.material_id')
            ->join('product_librages', 'product_librages.id', '=', 'products.product_librage_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->whereNotIn('products.id', $excludes)
            ->orderBy('products.created_at');
        }

        return $products->paginate(10);

    }

    public function getProduct(Request $request){

        return Product::find($request->id);

    }

    public function getProductInfoSelects(){

        try{

            $categories = Category::get();
            $types = ProductType::get();
            $measures = ProductMeasure::get();
            $materials = Material::get();
            $librages = ProductLibrage::get();
            $brands = Brand::get();

            return response()->json([
                'categories' => $categories,
                'types' => $types,
                'measures' => $measures,
                'materials' => $materials,
                'librages' => $librages,
                'brands' => $brands,
                'code' => 200,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => 500,
            ]);
        }

    }

    public function store(Request $request){

        try {
            
            // Validación
            $this->validate($request, [
                'code' => 'required|max:100',
                'category_id' => 'required',
                'product_type_id' => 'required',
                'product_measure_id' => 'required',
                'material_id' => 'required',
                'product_librage_id' => 'required',
                'brand_id' => 'required',
                'quantity' => 'required|integer|min:1',
                'weight' => 'required|min:1',
                'unit_price' => 'required|min:1',
                'sale_price' => 'required|min:1',
                'ubication' => 'required|max:200',
                'checking_date' => 'required|date'
            ]);

            if(isset($request->id)){
                $product = Product::find($request->id);
            }else{
                $product = new Product();
            }

            $product->code = strtoupper($request->code);
            $product->category_id = $request->category_id;
            $product->product_type_id = $request->product_type_id;
            $product->product_measure_id = $request->product_measure_id;
            $product->material_id = $request->material_id;
            $product->product_librage_id = $request->product_librage_id;
            $product->brand_id = $request->brand_id;
            $product->quantity = $request->quantity;
            $product->weight = $request->weight;
            $product->unit_price = $request->unit_price;
            $product->sale_price = $request->sale_price;
            $product->ubication = $request->ubication;
            $product->checking_date = $request->checking_date;
            $product->save();
    
            return response()->json([
                'message' => "¡Se guardo el producto correctamente!",
                'code' => 200,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => 500,
            ]);
        }

    }

    public function delete(Request $request){

        try {

            $product = Product::find($request->id);
            $product->delete();

            return response()->json([
                'message' => "¡Producto eliminado correctamente!",
                'code' => 200,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => 500,
            ]);
        }

    }


    public static function ajustInventory($id, $more=0, $less=0){

        try {

            $product = Product::find($id);
            $product->quantity += $more - $less;
            $product->save();

            return (object) [
                'message' => "¡Se guardo correctamente!",
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
