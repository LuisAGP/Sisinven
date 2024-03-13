<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\ProductLibrageController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProductMeasureController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientMovementController;

// Rutas del Perfil
Route::group([
    'prefix' => '/',
    'as' => 'sys.',
    'middleware' => ['auth']
], function () {

    // Ordenes
    Route::get('/',                      [OrderController::class, 'index'])->name('home');
    Route::get('/orders',                [OrderController::class, 'getOrders'])->name('getOrders');
    Route::post('/create_order',         [OrderController::class, 'store'])->name('createOrder');
    Route::delete('/cancel_order',       [OrderController::class, 'delete'])->name('cancelOrder');

    // Detalles de Orden
    Route::get('/nuevo_pedido',          [OrderDetailController::class, 'index'])->name('newOrder');
    Route::get('/order_details/{id}',    [OrderDetailController::class, 'getOrderDetails'])->name('getOrderDetails');
    Route::post('/create_order_detail',  [OrderDetailController::class, 'store'])->name('createOrderDetail');

    // Usuarios
    Route::get('/accounts',              [UserController::class, 'index'])->name('accounts');
    Route::get('/users',                 [UserController::class, 'getUsers']);
    Route::get('/user/{id}/',            [UserController::class, 'getUser']);
    Route::post('save_user/',            [UserController::class, 'store'])->name('saveUser');
    Route::post('new_password_user/',    [UserController::class, 'newPasswordUser'])->name('newPasswordUser');
    Route::delete('delete_user/',        [UserController::class, 'delete'])->name('deleteUser');

    // Catálogos
    Route::get('/catalog',               [CatalogController::class, 'index'])->name('catalog');
    
    // Categorias
    Route::get('/categories',            [CategoryController::class, 'index'])->name('categories');
    Route::get('/category/{id}',         [CategoryController::class, 'getCategory'])->name('getCategory');
    Route::post('/save_category',        [CategoryController::class, 'store'])->name('saveCategory');
    Route::delete('/delete_category',    [CategoryController::class, 'delete'])->name('deleteCategory');

    // Tipos
    Route::get('/types',                 [ProductTypeController::class, 'index'])->name('types');
    Route::get('/type/{id}',             [ProductTypeController::class, 'getType'])->name('getType');
    Route::post('/save_type',            [ProductTypeController::class, 'store'])->name('saveType');
    Route::delete('/delete_type',        [ProductTypeController::class, 'delete'])->name('deleteType');

    // Librajes
    Route::get('/librages',              [ProductLibrageController::class, 'index'])->name('librages');
    Route::get('/librage/{id}',          [ProductLibrageController::class, 'getLibrage'])->name('getLibrage');
    Route::post('/save_librage',         [ProductLibrageController::class, 'store'])->name('saveLibrage');
    Route::delete('/delete_librage',     [ProductLibrageController::class, 'delete'])->name('deleteLibrage');

    // Materiales
    Route::get('/materials',             [MaterialController::class, 'index'])->name('materials');
    Route::get('/material/{id}',         [MaterialController::class, 'getMaterial'])->name('getMaterial');
    Route::post('/save_material',        [MaterialController::class, 'store'])->name('saveMaterial');
    Route::delete('/delete_material',    [MaterialController::class, 'delete'])->name('deleteMaterial');

    // Medidas
    Route::get('/measures',              [ProductMeasureController::class, 'index'])->name('measures');
    Route::get('/measure/{id}',          [ProductMeasureController::class, 'getMeasure'])->name('getMeasure');
    Route::post('/save_measure',         [ProductMeasureController::class, 'store'])->name('saveMeasure');
    Route::delete('/delete_measure',     [ProductMeasureController::class, 'delete'])->name('deleteMeasure');

    // Marcas
    Route::get('/brands',                [BrandController::class, 'index'])->name('brands');
    Route::get('/brand/{id}',            [BrandController::class, 'getBrand'])->name('getBrand');
    Route::post('/save_brand',           [BrandController::class, 'store'])->name('saveBrand');
    Route::delete('/delete_brand',       [BrandController::class, 'delete'])->name('deleteBrand');

    // Clientes
    Route::get('/clientes',              [ClientController::class, 'index'])->name('clients');
    Route::get('/clients',               [ClientController::class, 'getClients'])->name('getClients');
    Route::get('/client/{id}',           [ClientController::class, 'getClient'])->name('getClient');
    Route::post('/save_client',          [ClientController::class, 'store'])->name('saveClient');
    Route::delete('/delete_client',      [ClientController::class, 'delete'])->name('deleteClient');
    Route::post('/clients_pluck',        [ClientController::class, 'getClientsPluck'])->name('getClientsPluck');
    Route::post('/pay_balance',          [ClientController::class, 'payBalance'])->name('payBalance');

    // Movimientos del cliente
    Route::get('/client_movements/{id}', [ClientMovementController::class, 'index'])->name('clientMovements');

    // Productos
    Route::get('productos/',             [ProductController::class, 'index'])->name('products');
    Route::get('/products',              [ProductController::class, 'getProducts'])->name('getProducts');
    Route::get('/product/{id}',          [ProductController::class, 'getProduct'])->name('getProduct');
    Route::get('/product_info_selects',  [ProductController::class, 'getProductInfoSelects'])->name('getProductInfoSelects');
    Route::post('/save_product',         [ProductController::class, 'store'])->name('saveProduct');
    Route::delete('/delete_product',     [ProductController::class, 'delete'])->name('deleteProduct');

    // Logout    
    Route::post('/logout',               [LogoutController::class, 'store'])->name('logout');
});

// Rutas de Autenticación de Usuario
Route::get('/login',     [LoginController::class, 'index'])->name('login');
Route::post('/login',    [LoginController::class, 'store']);

