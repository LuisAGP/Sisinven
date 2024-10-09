<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductMeasure;

class ProductMeasureController extends Controller
{

    public function index(Request $request){

        if(isset($request->search)){
            $search = $request->search;
            $measures = ProductMeasure::where('value', 'like', "%".$request->search."%")->orderBy('value');
        }else{
            $measures = ProductMeasure::orderBy('value');
        }

        return $measures->paginate(10);

    }

    public function getMeasure(Request $request){

        return ProductMeasure::find($request->id);

    }

    public function store(Request $request){

        try {
            
            // Validación
            $this->validate($request, [
                'value' => 'required|max:200'
            ]);

            if(isset($request->id)){
                $measure = ProductMeasure::find($request->id);
            }else{
                $measure = new ProductMeasure();
            }

            $measure->value = strtoupper($request->value);
            $measure->save();
    
            return response()->json([
                'message' => "¡Se guardo la medida correctamente!",
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

            $measure = ProductMeasure::find($request->id);
            $measure->delete();

            return response()->json([
                'message' => "¡Medida eliminada correctamente!",
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
