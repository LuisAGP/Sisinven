<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;

class MaterialController extends Controller
{
    
    public function index(Request $request){

        if(isset($request->search)){
            $search = $request->search;
            $materials = Material::where('name', 'like', "%".$request->search."%")->orderBy('name');
        }else{
            $materials = Material::orderBy('name');
        }

        return $materials->paginate(10);

    }

    public function getMaterial(Request $request){

        return Material::find($request->id);

    }

    public function store(Request $request){

        try {
            
            // Validación
            $this->validate($request, [
                'name' => 'required|max:200'
            ]);

            if(isset($request->id)){
                $material = Material::find($request->id); 
            }else{
                $material = new Material();
            }

            $material->name = strtoupper($request->name);
            $material->save();
    
            return response()->json([
                'message' => "¡Se guardo el material correctamente!",
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

            $material = Material::find($request->id);
            $material->delete();

            return response()->json([
                'message' => "¡Material eliminado correctamente!",
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
