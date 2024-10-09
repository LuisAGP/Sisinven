<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request){

        if(isset($request->search)){
            $search = $request->search;
            $categories = Category::where('name', 'like', "%".$request->search."%")->orderBy('name');
        }else{
            $categories = Category::orderBy('name');
        }

        return $categories->paginate(10);

    }

    public function getCategory(Request $request){

        return Category::find($request->id);

    }

    public function store(Request $request){

        try {
            
            // Validación
            $this->validate($request, [
                'name' => 'required|max:200'
            ]);

            if(isset($request->id)){
                $category = Category::find($request->id);
            }else{
                $category = new Category();
            }

            $category->name = strtoupper($request->name);
            $category->save();
    
            return response()->json([
                'message' => "¡Se guardo la categoría correctamente!",
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

            $category = Category::find($request->id);
            $category->delete();

            return response()->json([
                'message' => "¡Categoría eliminada correctamente!",
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
