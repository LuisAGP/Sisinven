@extends('layout.app')

@section('titulo')
Nueva Orden
@endsection

@section('scripts')
@vite('resources/js/order_detail/order_details.js')
@endsection

@section('contenido')

<a href="{{ route('sys.home') }}" class="mb-5 inline-block dark:text-white">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
        <path fill-rule="evenodd" d="M11.03 3.97a.75.75 0 0 1 0 1.06l-6.22 6.22H21a.75.75 0 0 1 0 1.5H4.81l6.22 6.22a.75.75 0 1 1-1.06 1.06l-7.5-7.5a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
    </svg>          
</a>

<h2 class="text-4xl font-extrabold dark:text-white mb-10">Nueva cotización</h2>

<div class="block md:flex align-middle justify-between gap-3">

    <div class="flex gap-3 mb-2">
        <label 
            for="orderDetail-date" 
            class="text-gray-800 dark:text-gray-50 p-1 text-lg"
        >Fecha del pedido:</label>

        <input 
            type="date"
            id="orderDetail-date"
            class="h-10 w-32 outline-none text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            value="{{ date('Y-m-d') }}"
        />

    </div>
    
    <div class="flex gap-3 mb-2">
        <label 
            for="orderDetail-clientId" 
            class="text-gray-800 dark:text-gray-50 p-1 text-lg"
        >Cliente:</label>

        <x-dselect
            :id="'orderDetail-clientId'" 
            :name="'orderDetail-clientId'" 
            :url="route('sys.getClientsPluck')"
        />
    </div>

    <div class="flex gap-3 mb-2">
        <label 
            for="orderDetail-totalGlobal" 
            class="text-gray-800 dark:text-gray-50 p-1 text-lg mr-3"
        >Total:</label>

        <input 
            id="orderDetail-totalGlobal"
            type="text"
            class="text-center h-10 w-32 outline-none text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="$0.00"
            readonly
            disabled
        />
    </div>
</div>

<hr />

<div class="my-5 flex justify-end gap-3">   
    <button 
        type="button" 
        onclick="openAddProductModal()"
        class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
        Agregar Productos
    </button>
    <button 
        type="button" 
        onclick="openProceedOrderModal()"
        class="text-white bg-sky-600 hover:bg-sky-800 focus:ring-4 focus:outline-none focus:ring-sky-300 dark:focus:ring-sky-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
        Procesar Pedido
    </button>
</div>

<x-datatable :rows="['Acción', 'Prod. Descripción', 'Cantidad', 'Precio ($)', 'Subotal']" :id="'datatableOrderDetails'" :hideSearchInput="true"/>

@include('pages.orderDetail.modals.addProduct')
@include('pages.orderDetail.modals.proceedOrder')

@endsection