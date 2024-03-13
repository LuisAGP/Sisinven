<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index(){

        if(!auth()->user()->superuser){
            return redirect()->route('sys.home');
        }

        return view('pages.user.index');
    }

    public function getUsers(Request $request){

        if(!auth()->user()->superuser){
            return response()->json([
                'message' => "No tienes los permisos para realizar esta operación",
                'code' => 500,
            ]);
        }
        
        if(isset($request->search)){
            $search = $request->search;
            $users = User::where(function($query) use($search){
                $query->where('name', 'like', '%'.$search.'%')
                ->orWhere('lastname', 'like', '%'.$search.'%')
                ->orWhere('username', 'like', '%'.$search.'%')
                ->whereNull('deleted_at');
            })->latest();
        }else{
            $users = User::latest();
        }

        return $users->paginate(10);

    }

    public function getUser(Request $request){

        if(!auth()->user()->superuser){
            return response()->json([
                'message' => "No tienes los permisos para realizar esta operación",
                'code' => 500,
            ]);
        }

        return User::find($request->id);

    }

    public function store(Request $request){

        try {

            if(!auth()->user()->superuser){
                return response()->json([
                    'message' => "No tienes los permisos para realizar esta operación",
                    'code' => 500,
                ]);
            }
            
            if(isset($request->id)){

                // Validación
                $this->validate($request, [
                    'name' => 'required|max:200',
                    'lastname' => 'required|max:200'
                ]);

                $user = User::find($request->id);
            }else{

                // Validación
                $this->validate($request, [
                    'name' => 'required|max:200',
                    'lastname' => 'required|max:200',
                    'username' => 'required|unique:users|max:200',
                    'password' => 'required|confirmed'
                ]);

                $user = new User();
                $user->username = $request->username;
                $user->password = $request->password;
            }
    
            $user->name = $request->name;
            $user->lastname = $request->lastname;
            $user->superuser = isset($request->superuser) ? 1 : 0;
            $user->save();
    
            return response()->json([
                'message' => "¡Se guardo el usuario correctamente!",
                'code' => 200,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => 500,
            ]);
        }

    }


    public function newPasswordUser(Request $request){

        try {

            if(!auth()->user()->superuser){
                return response()->json([
                    'message' => "No tienes los permisos para realizar esta operación",
                    'code' => 500,
                ]);
            }

            // Validación
            $this->validate($request, [
                'password' => 'required|confirmed'
            ]);
            
            $user = User::find($request->id);
            $user->password = $request->password;
            $user->save();
    
            return response()->json([
                'message' => "¡Se guardo el usuario correctamente!",
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

            if(!auth()->user()->superuser){
                return response()->json([
                    'message' => "No tienes los permisos para realizar esta operación",
                    'code' => 500,
                ]);
            }

            $user = User::find($request->id);
            $user->delete();

            return response()->json([
                'message' => "¡Usuario eliminado correctamente!",
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
