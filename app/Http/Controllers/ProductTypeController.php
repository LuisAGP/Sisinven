<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductType;

class ProductTypeController extends Controller
{

    public function index(Request $request){

        if(isset($request->search)){
            $search = $request->search;
            $types = ProductType::where('name', 'like', "%".$request->search."%")->orderBy('name');
        }else{
            $types = ProductType::orderBy('name');
        }

        return $types->paginate(10);

    }

    public function getType(Request $request){

        return ProductType::find($request->id);

    }

    public function store(Request $request){

        try {
            
            // Validación
            $this->validate($request, [
                'name' => 'required|max:200'
            ]);

            if(isset($request->id)){
                $type = ProductType::find($request->id);
            }else{
                $type = new ProductType();
            }

            $type->name = strtoupper($request->name);
            $type->save();
    
            return response()->json([
                'message' => "¡Se guardo el tipo correctamente!",
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

            $type = ProductType::find($request->id);
            $type->delete();

            return response()->json([
                'message' => "¡Tipo eliminado correctamente!",
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
