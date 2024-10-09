@extends('layout.app')

@section('titulo')
Usuarios
@endsection

@section('scripts')
@vite('resources/js/register/users.js')
@endsection

@section('contenido')

<div class="mb-3 flex justify-end">    
    <button 
        data-modal-hide="modal-alert" 
        type="button" 
        onclick="modalNewUser.toggle()"
        class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
        Nuevo Usuario
    </button>
</div>

<x-datatable :rows="['Acción', 'Usuario', 'Nombre(s)', 'Apellidos']" :id="'datatableUsers'"/>

@include('modals.saveUser')
@include('modals.newUser')
@include('modals.deleteUser')
@include('modals.newPasswordUser')

@endsection