@extends('layout.app')

@section('titulo')
Productos
@endsection

@section('scripts')
@vite('resources/js/product/products.js')
@endsection

@section('contenido')

<h2 class="text-4xl font-extrabold dark:text-white mb-5">Productos</h2>

<div class="mb-3 flex justify-end">    
    <button 
        type="button" 
        onclick="openSaveProductModal()"
        class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
        Nuevo Producto
    </button>
</div>

<x-datatable :rows="['Acción', 'Categoría', 'Tipo', 'Medida', 'Material', 'Libraje', 'Ubicacion', 'Cantidad', 'Marca']" :id="'datatableProducts'"/>

@include('pages.product.modals.saveProduct')
@include('pages.product.modals.deleteProduct')

@endsection