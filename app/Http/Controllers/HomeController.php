<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\Category;
use App\Models\SavingsGoal;
use App\Models\Debt;

use App\Notifications\OverspendingNotification;
use Illuminate\Support\Facades\Notification;

use Maatwebsite\Excel\Facades\Excel;

use Maatwebsite\Excel\Excel as ExcelExcel;

use App\Imports\ExpensesImport; // Make sure to import your specific import class

use PDF;

class HomeController extends Controller
{

    public function dashboard()
    {
        $userId = auth()->id(); // Get the currently authenticated user's ID

        $budgetCount = Budget::where('user_id', $userId)->count(); // Count budgets for the logged-in user
        $goalCount = SavingsGoal::where('user_id', $userId)
            ->whereColumn('current_amount', '!=', 'target_amount') // Only count goals where current_amount != target_amount
            ->count(); // Count savings goals for the logged-in user
        $debtCount = Debt::where('user_id', $userId)
            ->where('remaining_amount', '>', 0) // Only count debts with remaining_amount > 0
            ->count(); // Count debts for the logged-in user

        return view('dashboard', compact('budgetCount', 'goalCount', 'debtCount'));
    }
}