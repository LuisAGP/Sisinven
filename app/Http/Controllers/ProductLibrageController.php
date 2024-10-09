<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductLibrage;

class ProductLibrageController extends Controller
{
    public function index(Request $request){

        if(isset($request->search)){
            $search = $request->search;
            $librages = ProductLibrage::where('value', 'like', "%".$request->search."%")->orderBy('value');
        }else{
            $librages = ProductLibrage::orderBy('value');
        }

        return $librages->paginate(10);

    }

    public function getLibrage(Request $request){

        return ProductLibrage::find($request->id);

    }

    public function store(Request $request){

        try {
            
            // Validación
            $this->validate($request, [
                'value' => 'required|max:200'
            ]);

            if(isset($request->id)){
                $librage = ProductLibrage::find($request->id);
            }else{
                $librage = new ProductLibrage();
            }

            $librage->value = strtoupper($request->value);
            $librage->save();
    
            return response()->json([
                'message' => "¡Se guardo el libraje correctamente!",
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

            $librage = ProductLibrage::find($request->id);
            $librage->delete();

            return response()->json([
                'message' => "¡Libraje eliminado correctamente!",
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
