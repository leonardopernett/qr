<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\PeticionController;

Route::redirect('/','quejas_reclamos');

Route::get('quejas_reclamos', [PeticionController::class, 'create'] )
       ->name('quejas');

/* contactos quejas y reclamos */
Route::post('/contact',[ PeticionController::class, 'store' ])
       ->name('contact');

Route::post('tipologia/all', [ PeticionController::class, 'tipologia'])
      ->name('tipologia');

Route::view('mail','web.mail.message');

Route::get('api/actualizarjarvis',[PeticionController::class,'insertjarvis'])->name('insertjarvis');



Route::get('token', function(){
    return ["name"=>"leonardo"];
});