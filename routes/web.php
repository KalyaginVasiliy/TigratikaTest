<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NomenclaturePageController;

Route::get('/', [NomenclaturePageController::class, 'index']);
Route::get('/nomenclature', [NomenclaturePageController::class, 'index'])->name('nomenclature.index');
Route::get('/api/nomenclature', [NomenclaturePageController::class, 'getData'])->name('nomenclature.data');
Route::put('/api/nomenclature/{id}', [NomenclaturePageController::class, 'updatePosition']);
Route::delete('/api/nomenclature/{id}', [NomenclaturePageController::class, 'deleteItem']);
Route::delete('/api/nomenclature/{parentId}/child/{childId}', [NomenclaturePageController::class, 'deleteChildItem']);
Route::post('/api/nomenclature', [NomenclaturePageController::class, 'store']);
Route::post('/nomenclature/{id}/child', [NomenclaturePageController::class, 'storeChild']);
