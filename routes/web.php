<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});
*/
//Modulo inicio
Route::get('/','ControllerProducto@index')->name('pro.index');
//Modulo producto
Route::get('/adminProductos','ControllerProducto@adminProductos')->name('pro.adminProductos');

//boton nuevoProducto
Route::get('/nuevoProducto','ControllerProducto@nuevoProducto')->name('pro.nuevoProducto');
Route::post('/nuevoRegistroProducto','ControllerProducto@nuevoRegistroProducto')->name('pro.nuevoRegistroProducto');

//Eliminar producto
Route::post('/eliminarProducto','ControllerProducto@eliminarProducto')->name('pro.eliminarProducto');

//Editar datos del producto
Route::get('/editarProducto/{id}','ControllerProducto@editarProducto')->name('pro.editarProducto');
Route::post('/editarRegistroProducto','ControllerProducto@editarRegistroProducto')->name('pro.editarRegistroProducto');

//Generar los reportes en PDF y EXCEL
Route::get('/reportePdf','ControllerProducto@reportePdf');
Route::get('/reporteExcel','ControllerProducto@reporteExcel');

//Generar graficos
Route::get('/grafico','ControllerProducto@grafico');
Route::post('/grafico_resp','ControllerProducto@grafico_resp')->name('pro.grafico_resp');