<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index(){
        return view('auth.register');
    }
    
    public function store(Request $request){

        // Validación
        $this->validate($request, [
            'name' => 'required|max:200',
            'lastname' => 'required|max:200',
            'username' => 'required|unique:users|max:200',
            'password' => 'required|confirmed'
        ]);

        // Redirección
        return redirect()->back()->with('success', '¡Usuario "'.$request->username.'" creado con exito!');

    }
}
