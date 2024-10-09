@extends('layout.app')

@section('titulo')
Clientes
@endsection

@section('scripts')
@vite('resources/js/client/clients.js')
@endsection

@section('contenido')

<h2 class="text-4xl font-extrabold dark:text-white mb-5">Clientes</h2>

<div class="mb-3 flex justify-end">    
    <button 
        type="button" 
        onclick="openSaveClientModal()"
        class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
        Nuevo Cliente
    </button>
</div>

<x-datatable :rows="['Acción', 'Nombre(s)', 'Apellidos', 'Empresa', 'Telefóno', 'RFC', 'Régimen', 'Saldo']" :id="'datatableClients'"/>

@include('pages.client.modals.saveClient')
@include('pages.client.modals.deleteClient')
@include('pages.client.modals.payBalance')
@include('pages.client.modals.clientMovements')

@endsection