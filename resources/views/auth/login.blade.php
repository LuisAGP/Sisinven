@extends('layout.app')

@section('titulo')
Acceder
@endsection

@section('contenido')
<div class="md:flex md:justify-center md:gap-10 mt-10">

    <div class="sm:w-full md:w-1/3 bg-gray-100 dark:bg-slate-600 p-6 rounded-xl shadow-xl">
        <form method="POST" action="">
            @csrf
            <legend class="flex justify-center text-gray-500 dark:text-gray-50 uppercase font-bold text-xl m-4">
                <h1 class="mb-5">Iniciar sesión</h1>                 
            </legend>

            @if (session('mensaje'))
            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                {{ session('mensaje') }}
            </p>
            @endif

            <div class="mb-5">
                <input 
                    type="text" 
                    id='username' 
                    name="username" 
                    placeholder="Usuario" 
                    class="border p-3 w-full rounded-lg @error('email') border-red-500 @enderror"
                    value="{{ old('username') }}"
                    
                >
                @error('username')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <input 
                    type="password" 
                    id='password' 
                    name="password" 
                    placeholder="Contraseña" 
                    class="border p-3 w-full rounded-lg @error('password') border-red-500 @enderror"
                >
                @error('password')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                @enderror
            </div>

            <input 
                type="submit",
                value="Iniciar Sesión"
                class="bg-neutral-900 mt-10 hover:bg-neutral-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg"
            >
        </form>
    </div>
    
</div>
@endsection