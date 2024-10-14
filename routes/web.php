<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\DebtController;

Route::get('/pefima', function () {
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

require __DIR__ . '/auth.php';

////////////////////////// Budget /////////////////////////////////////

// view

Route::get('/budget/budget', [BudgetController::class, 'budget'])->name('budget');

Route::get('/budget/expensesinput', [BudgetController::class, 'expensesinput'])->name('expensesinput');

Route::get('/budget/setbudget/{id}', [BudgetController::class, 'setbudget'])->name('setbudget');

Route::get('/budget/expensesbudget', [BudgetController::class, 'expensesbudget'])->name('expensesbudget');

Route::get('/budget/showexpenses/{id}', [BudgetController::class, 'showexpenses'])->name('showexpenses');

Route::get('/budget/editcategory/{id}', [BudgetController::class, 'editcategory'])->name('editcategory');

Route::get('/budget/addcategory', [BudgetController::class, 'addcategory'])->name('addcategory');

route::get('/budget/updateexpense/{id}', [BudgetController::class, 'updateexpense']);

Route::get('/budget/importexcel', [BudgetController::class, 'importexcel'])->name('importexcel');

Route::get('/budget/downloadpdf/{id}', [BudgetController::class, 'downloadpdf'])->name('downloadpdf');

// function

route::post('/addexpenses', [BudgetController::class, 'addexpenses']);

route::delete('/deleteexpenses/{id}', [BudgetController::class, 'deleteexpenses']);

route::post('/updateexpensefunc/{id}', [BudgetController::class, 'updateexpensefunc']);

route::post('/adjustbudget/{id}', [BudgetController::class, 'adjustbudget'])->name('adjustbudget');

Route::post('/uploadexcel', [BudgetController::class, 'uploadexcel'])->name('uploadexcel');

route::post('/insertcategory', [BudgetController::class, 'insertcategory']);

route::delete('/deletecategory/{id}', [BudgetController::class, 'deletecategory']);

route::post('/updatecategory/{id}', [BudgetController::class, 'updatecategory']);

////////////////////////// Goal /////////////////////////////////////

// view

Route::get('/goal/goal', [GoalController::class, 'goal'])->name('goal');

Route::get('/goal/goalsinput', [GoalController::class, 'goalsinput'])->name('goalsinput');

Route::get('/goal/editcurrentamount/{id}', [GoalController::class, 'editcurrentamount'])->name('editcurrentamount');

Route::get('/goal/editgoal/{id}', [GoalController::class, 'editgoal'])->name('editgoal');

// function

route::post('/addgoals', [GoalController::class, 'addgoals']);

route::delete('/deletegoals/{id}', [GoalController::class, 'deletegoals']);

route::post('/updategoal/{id}', [GoalController::class, 'updategoal']);

route::post('/updatecurrentamount/{id}', [GoalController::class, 'updatecurrentamount']);

////////////////////////// Debt /////////////////////////////////////

// view

Route::get('/debt/debt', [DebtController::class, 'debt'])->name('debt');

Route::get('/debt/debtsinput', [DebtController::class, 'debtsinput'])->name('debtsinput');

Route::get('/debt/addamountpaid/{id}', [DebtController::class, 'addamountpaid'])->name('addamountpaid');

Route::get('/debt/editdebt/{id}', [DebtController::class, 'editdebt'])->name('editdebt');

Route::get('/debt/downloadreport', [DebtController::class, 'downloadreport'])->name('downloadreport');

// function

route::post('/adddebts', [DebtController::class, 'adddebts']);

route::post('/insertamountpaid/{id}', [DebtController::class, 'insertamountpaid']);

route::post('/updatedebts/{id}', [DebtController::class, 'updatedebts']);

route::delete('/deletedebts/{id}', [DebtController::class, 'deletedebts']);

/////////////////////////////////////////////////////////////////////

Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
