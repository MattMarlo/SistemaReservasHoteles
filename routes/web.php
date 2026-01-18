<?php

use App\Models\Huesped;
use App\Http\Controllers\HuespedController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\ReservaController;
use App\Models\Reserva;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.main');
});
Route::prefix('huespedes')->group(function(){
    Route::get('/',[HuespedController::class,'index'])->name('huespedes');
    Route::get('/create',[HuespedController::class,'create'])->name('huespedes.create');
    Route::post('/store',[HuespedController::class,'store'])->name('huespedes.store');
    Route::get('/edit/{id}',[HuespedController::class,'edit'])->name('huespedes.edit');
    Route::put('/update/{id}',[HuespedController::class,'update'])->name('huespedes.update');
    Route::delete('/delete/{id}',[HuespedController::class,'destroy'])->name('huespedes.delete');
});
Route::prefix('habitaciones')->group(function(){
    Route::get('/',[HabitacionController::class,'index'])->name('habitaciones');
    Route::get('/create',[HabitacionController::class,'create'])->name('habitaciones.create');
    Route::post('/store',[HabitacionController::class,'store'])->name('habitaciones.store');
    Route::get('/edit/{id}',[HabitacionController::class,'edit'])->name('habitaciones.edit');
    Route::put('/update/{id}',[HabitacionController::class,'update'])->name('habitaciones.update');
    Route::delete('/delete/{id}',[HabitacionController::class,'destroy'])->name('habitaciones.delete');
});
Route::prefix('reservas')->group(function(){
    Route::get('/',[ReservaController::class,'index'])->name('reservas');
    Route::get('/create',[ReservaController::class,'create'])->name('reservas.create');
    Route::post('/store',[ReservaController::class,'store'])->name('reservas.store');
    Route::get('/edit/{id}',[ReservaController::class,'edit'])->name('reservas.edit');
    Route::put('/update/{id}',[ReservaController::class,'update'])->name('reservas.update');
    Route::delete('/delete/{id}',[ReservaController::class,'destroy'])->name('reservas.delete');
});