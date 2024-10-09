<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    
    public function index(Request $request){

        if(isset($request->search)){
            $search = $request->search;
            $brands = Brand::where('name', 'like', "%".$request->search."%")->orderBy('name');
        }else{
            $brands = Brand::orderBy('name');
        }

        return $brands->paginate(10);

    }

    public function getBrand(Request $request){

        return Brand::find($request->id);

    }

    public function store(Request $request){

        try {
            
            // Validación
            $this->validate($request, [
                'name' => 'required|max:200'
            ]);

            if(isset($request->id)){
                $brand = Brand::find($request->id);
            }else{
                $brand = new Brand();
            }

            $brand->name = strtoupper($request->name);
            $brand->save();
    
            return response()->json([
                'message' => "¡Se guardo la marca correctamente!",
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

            $brand = Brand::find($request->id);
            $brand->delete();

            return response()->json([
                'message' => "¡Marca eliminada correctamente!",
                'code' => 200,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => 500,
            ]);
        }

    }


}
