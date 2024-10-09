@extends('layout.app')

@section('titulo')
Catálogos
@endsection

@section('scripts')
@vite('resources/js/catalog/catalog.js')
@vite('resources/js/catalog/categories.js')
@vite('resources/js/catalog/types.js')
@vite('resources/js/catalog/librages.js')
@vite('resources/js/catalog/materials.js')
@vite('resources/js/catalog/measures.js')
@vite('resources/js/catalog/brands.js')
@endsection

@section('contenido')

<div class="mb-4 border-b border-gray-200 dark:border-gray-700">
    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#tabs-catalog" role="tablist">
        <li class="me-2" role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="category-tab" data-tabs-target="#category" type="button" role="tab" aria-controls="category" aria-selected="false">Categoría</button>
        </li>
        <li class="me-2" role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="type-tab" data-tabs-target="#type" type="button" role="tab" aria-controls="type" aria-selected="false">Tipo</button>
        </li>
        <li class="me-2" role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="librage-tab" data-tabs-target="#librage" type="button" role="tab" aria-controls="librage" aria-selected="false">Libraje</button>
        </li>
        <li role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="material-tab" data-tabs-target="#material" type="button" role="tab" aria-controls="material" aria-selected="false">Material</button>
        </li>
        <li role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="measure-tab" data-tabs-target="#measure" type="button" role="tab" aria-controls="measure" aria-selected="false">Medida</button>
        </li>
        <li role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="brand-tab" data-tabs-target="#brand" type="button" role="tab" aria-controls="brand" aria-selected="false">Marca</button>
        </li>
    </ul>
</div>
<div id="tabs-catalog">
    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="category" role="tabpanel" aria-labelledby="category-tab">
        {{-- Tabla de Categoria --}}
        <div class="mb-3 flex justify-end">    
            <button 
                type="button" 
                onclick="openSaveCategoryModal()"
                class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                Nueva Categoría
            </button>
        </div>
        <x-datatable :rows="['Acción', 'Nombre']" :id="'datatableCategories'"/>
    </div>
    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="type" role="tabpanel" aria-labelledby="type-tab">
        {{-- Tabla de Tipo --}}
        <div class="mb-3 flex justify-end">    
            <button 
                type="button" 
                onclick="openSaveTypeModal()"
                class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                Nuevo Tipo
            </button>
        </div>
        <x-datatable :rows="['Acción', 'Nombre']" :id="'datatableTypes'"/>
    </div>
    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="librage" role="tabpanel" aria-labelledby="librage-tab">
        {{-- Tabla de Libraje --}}
        <div class="mb-3 flex justify-end">    
            <button 
                type="button" 
                onclick="openSaveLibrageModal()"
                class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                Nuevo Libraje
            </button>
        </div>
        <x-datatable :rows="['Acción', 'Valor']" :id="'datatableLibrages'"/>
    </div>
    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="material" role="tabpanel" aria-labelledby="material-tab">
        {{-- Tabla de Material --}}
        <div class="mb-3 flex justify-end">    
            <button 
                type="button" 
                onclick="openSaveMaterialModal()"
                class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                Nuevo Material
            </button>
        </div>
        <x-datatable :rows="['Acción', 'Nombre']" :id="'datatableMaterials'"/>
    </div>
    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="measure" role="tabpanel" aria-labelledby="measure-tab">
        {{-- Tabla de Medida --}}
        <div class="mb-3 flex justify-end">    
            <button 
                type="button" 
                onclick="openSaveMeasureModal()"
                class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                Nueva Medida
            </button>
        </div>
        <x-datatable :rows="['Acción', 'Valor']" :id="'datatableMeasures'"/>
    </div>
    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="brand" role="tabpanel" aria-labelledby="brand-tab">
        {{-- Tabla de Marca --}}
        <div class="mb-3 flex justify-end">    
            <button 
                type="button" 
                onclick="openSaveBrandModal()"
                class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                Nueva Marca
            </button>
        </div>
        <x-datatable :rows="['Acción', 'Nombre']" :id="'datatableBrands'"/>
    </div>
</div>


{{-- Category --}}
@include('pages.catalog.modals.newCategory')
@include('pages.catalog.modals.deleteCategory')

{{-- Types --}}
@include('pages.catalog.modals.newType')
@include('pages.catalog.modals.deleteType')

{{-- Librages --}}
@include('pages.catalog.modals.newLibrage')
@include('pages.catalog.modals.deleteLibrage')

{{-- Materials --}}
@include('pages.catalog.modals.newMaterial')
@include('pages.catalog.modals.deleteMaterial')

{{-- Measeres --}}
@include('pages.catalog.modals.newMeasure')
@include('pages.catalog.modals.deleteMeasure')

{{-- Brands --}}
@include('pages.catalog.modals.newBrand')
@include('pages.catalog.modals.deleteBrand')

@endsection