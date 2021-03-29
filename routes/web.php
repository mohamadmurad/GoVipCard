<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => ['auth:sanctum']],function (){
    Route::get('/',[\App\Http\Controllers\HomeController::class,'home'])->name('home');
    Route::get('/info',[\App\Http\Controllers\CardsController::class,'info'])->name('info');
    Route::post('/withdraw',[\App\Http\Controllers\CardsController::class,'withdraw'])->name('withdraw');
    Route::post('/deposit',[\App\Http\Controllers\CardsController::class,'deposit'])->name('deposit');
    Route::post('/addCard',[\App\Http\Controllers\CardsController::class,'addCard'])->name('addCard');
    Route::get('/create',[\App\Http\Controllers\CardsController::class,'create'])->name('create');
    Route::get('/get',function (){
        redirect('info');
    })->name('withdrawget');

});

Route::group(['middleware' => ['auth:sanctum','isAdminMiddleware']],function () {
    Route::resource('users',\App\Http\Controllers\UsersController::class)->middleware('isAdminMiddleware');

    Route::post('/addName',[\App\Http\Controllers\CardsController::class,'addName'])->name('addName');
    Route::delete('/Delete_deposit',[\App\Http\Controllers\CardsController::class,'deleteDeposit'])->name('DeleteDeposit');
    Route::delete('/Delete_withdraw',[\App\Http\Controllers\CardsController::class,'DeleteWithdraw'])->name('DeleteWithdraw');
    Route::post('/withdrawToDeposit',[\App\Http\Controllers\CardsController::class,'withdrawToDeposit'])->name('withdrawToDeposit');


    Route::get('/addName',[\App\Http\Controllers\CardsController::class,'createName'])->name('createName');

    Route::get('/cardReport',[\App\Http\Controllers\CardsController::class,'cardReport'])->name('cardReport');

    Route::get('li',function (){

        return view('licence.make');

    });

    Route::post('li',function (\Illuminate\Http\Request $request){
        // dd($request->get('date'));
        if (!file_exists(env('Licence_dir','E:\Mhd'))){
            mkdir(env('Licence_dir','E:\Mhd'));
        }
        // dd(is_dir(env('Licence_dir','E:\Mhd')));
        $data = Carbon::make($request->get('date'));

        $file = fopen(env('Licence_dir','E:\Mhd') . '\\' .env('Licence_file','Mhd2021.li'),'wr');
        $f = fwrite($file,$data,200);
        fclose($file);

        return redirect('/');

    })->name('licenceMake');



});




    Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
