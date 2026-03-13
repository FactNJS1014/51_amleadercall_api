<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIGetDataController;
use App\Http\Controllers\APIInsertDataController;
use App\Http\Controllers\APIUpdateandDeleteController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/**
 * TODO: Add API GET Methods
 */

Route::get('/vwork', [APIGetDataController::class, 'DataVWork']);

Route::get('/info/record/check', [APIGetDataController::class, 'CheckDataRecord']);
Route::get('/info/record', [APIGetDataController::class, 'DataInfoRecord']);

Route::get('/action/record/check', [APIGetDataController::class, 'CheckActionRecord']);
Route::get('/info-action/record', [APIGetDataController::class, 'DataInfoAndActionRecord']);

Route::get('/confirm/record', [APIGetDataController::class, 'DataConfirmRecord']);

Route::get('/vcus', [APIGetDataController::class, 'DataCustomer']);

Route::get('/vcheckmodel', [APIGetDataController::class, 'DataCheckModel']);
Route::get('/vwork/{customer}', [APIGetDataController::class, 'DataVWorkByCustomer']);
Route::get('/vcheckmodel/{won}', [APIGetDataController::class, 'DataCheckModelByWon']);

/**
 * TODO: Add API POST Methods
 */

Route::post('/info/insert', [APIInsertDataController::class, 'DataInfoInsert']);

Route::post('/action/insert', [APIInsertDataController::class, 'DataActionInsert']);

Route::post('/confirm/insert', [APIInsertDataController::class, 'DataConfirmInsert']);

/**
 * TODO: Add API PUT and DELETE
 */
Route::put('/update/check/{id}', [APIUpdateandDeleteController::class, 'UpdateCheckRecordInformation']);
Route::put('/update/action-check/{id}', [APIUpdateandDeleteController::class, 'UpdateActionCheckRecord']);

Route::delete('/info/delete/{id}', [APIUpdateandDeleteController::class, 'DeleteInfoRecord']);

Route::put('/info/update', [APIUpdateandDeleteController::class, 'UpdateInfoRecord']);

Route::put('/action/update', [APIUpdateandDeleteController::class, 'UpdateActionRecord']);
