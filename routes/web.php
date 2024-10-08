<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Budget

Route::get('/budget', [HomeController::class, 'budget'])->name('budget');

Route::get('/expensesinput', [HomeController::class, 'expensesinput'])->name('expensesinput');

route::post('/addexpenses',[HomeController::class,'addexpenses']);

route::delete('deleteexpenses/{id}',[HomeController::class,'deleteexpenses']);

route::get('updateexpense/{id}',[HomeController::class,'updateexpense']);

route::post('updateexpensefunc/{id}',[HomeController::class,'updateexpensefunc']);

Route::get('/expensesbudget', [HomeController::class, 'expensesbudget'])->name('expensesbudget');

Route::get('/setbudget/{id}', [HomeController::class, 'setbudget'])->name('setbudget');

route::post('/adjustbudget/{id}',[HomeController::class,'adjustbudget'])->name('adjustbudget');

Route::get('/showexpenses/{id}', [HomeController::class, 'showexpenses'])->name('showexpenses');

Route::get('/downloadpdf/{id}', [HomeController::class, 'downloadpdf'])->name('downloadpdf');

Route::get('/importexcel', [HomeController::class, 'importexcel'])->name('importexcel');

Route::post('uploadexcel', [HomeController::class, 'uploadexcel'])->name('uploadexcel');

Route::get('/addcategory', [HomeController::class, 'addcategory'])->name('addcategory');

route::post('/insertcategory',[HomeController::class,'insertcategory']);

route::delete('deletecategory/{id}',[HomeController::class,'deletecategory']);

// Goal

Route::get('/goal', [HomeController::class, 'goal'])->name('goal');

Route::get('/goalsinput', [HomeController::class, 'goalsinput'])->name('goalsinput');

route::post('/addgoals',[HomeController::class,'addgoals']);

route::delete('deletegoals/{id}',[HomeController::class,'deletegoals']);

Route::get('/editgoal/{id}', [HomeController::class, 'editgoal'])->name('editgoal');

route::post('updategoal/{id}',[HomeController::class,'updategoal']);

Route::get('/editcurrentamount/{id}', [HomeController::class, 'editcurrentamount'])->name('editcurrentamount');

route::post('updatecurrentamount/{id}',[HomeController::class,'updatecurrentamount']);










