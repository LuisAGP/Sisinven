@extends('layout.app')

@section('titulo')
Pedidos
@endsection

@section('scripts')
@vite('resources/js/order/orders.js')
@endsection

@section('contenido')

<h2 class="text-4xl font-extrabold dark:text-white mb-5">Pedidos</h2>

<div class="mb-3 flex justify-end">    
    <a
        href="{{ route('sys.newOrder') }}"
        class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
        Realizar Pedido
    </a>
</div>

<x-datatable :rows="['Acción', '#', 'Fecha', 'Cliente', 'Total']" :id="'datatableOrders'"/>

@include('pages.order.modals.cancelOrder')
@include('pages.order.modals.orderDetails')

@endsection