@extends('layout.app')

@section('titulo')
Usuarios
@endsection

@section('scripts')
@vite('resources/js/register/users.js')
@endsection

@section('contenido')

<h2 class="text-4xl font-extrabold dark:text-white mb-5">Usuarios</h2>

<div class="mb-3 flex justify-end">
    <button 
        type="button" 
        onclick="modalNewUser.toggle()"
        class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
        Nuevo Usuario
    </button>
</div>

<x-datatable :rows="['Acción', 'Usuario', 'Nombre(s)', 'Apellidos']" :id="'datatableUsers'"/>

@include('pages.user.modals.saveUser')
@include('pages.user.modals.newUser')
@include('pages.user.modals.deleteUser')
@include('pages.user.modals.newPasswordUser')

@endsection