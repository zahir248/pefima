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

class BudgetController extends Controller
{

    ////////////////////// view ///////////////////////////////////

    public function budget(Request $request)
    {
        // Fetch categories for the filter dropdown that belong to the authenticated user
        $categories = Category::where('user_id', auth()->id())->get();

        // Fetch all budget expenses for the logged-in user, with optional filters
        $query = Budget::where('user_id', auth()->id());

        // Apply the 'name' filter if it's provided
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Apply the 'category_id' filter if it's provided
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Apply the 'date' filter if it's provided
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        // Order the results by 'date' in descending order (latest first)
        $expenses = $query->orderBy('date', 'desc')->get();

        // Pass the expenses and categories to the view
        return view('budget.budget', compact('expenses', 'categories'));
    }

    public function expensesinput()
    {
        // Retrieve categories that belong to the authenticated user
        $categories = Category::where('user_id', auth()->id())->get();

        // Pass the categories to the view
        return view('budget.expensesinput', compact('categories'));
    }

    public function setbudget($id)
    {
        // Find the category by ID
        $category = Category::findOrFail($id); // This will throw a 404 if the category is not found

        // Return the view with the category
        return view('budget.adjustbudget', compact('category'));
    }

    public function expensesbudget()
    {
        // Get the authenticated user
        $user = auth()->user();

        // Fetch categories with budgets that belong to the authenticated user
        $categories = Category::with([
            'budgets' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }
        ])
            ->where('user_id', $user->id) // Assuming categories also have a user_id
            ->get();

        // Pass the categories to the view
        return view('budget.expensesbudget', compact('categories'));
    }

    public function showexpenses($id)
    {
        // Find the category by ID
        $category = Category::findOrFail($id);

        // Get the selected month and year from the request
        $month = request('month', null); // Default to null for month if not specified
        $year = request('year', null);   // Default to null for year if not specified

        // Get all budgets (expenses) related to the category
        $budgetsQuery = $category->budgets();

        // Apply filtering if month and year are provided
        if ($month && $year) {
            $budgetsQuery->whereMonth('date', $month)
                ->whereYear('date', $year);
        }

        // Get the filtered budgets or all if no filters applied
        $budgets = $budgetsQuery->orderBy('date', 'desc')->get();

        // Calculate the total amount for all budgets
        $totalAmount = $category->budgets()->sum('amount');

        // Calculate the total amount for filtered budgets if filters are applied
        $filteredTotalAmount = $budgets->sum('amount');

        // Return the view with the category, budgets, total amount, and filtered total amount
        return view('budget.showexpenses', compact('category', 'budgets', 'totalAmount', 'filteredTotalAmount', 'month', 'year'));
    }

    public function editcategory($id)
    {

        $category = Category::findOrFail($id);

        return view('budget.editcategory', compact('category'));

    }

    public function addcategory()
    {
        return view('budget.addcategory');

    }

    public function updateexpense($id)
    {
        $expense = Budget::findOrFail($id);
        $categories = Category::all(); // Fetch categories for the select dropdown

        return view('budget.expenseupdate', compact('expense', 'categories'));
    }

    public function importexcel()
    {
        return view('budget.importexcel');

    }

    public function downloadPdf($id)
    {
        $category = Category::findOrFail($id);
        $budgets = $category->budgets; // Get budgets for this category

        // Generate PDF
        $pdf = PDF::loadView('budget.downloadpdf', compact('category', 'budgets'));

        // Return PDF as download
        return $pdf->download('budget_report.pdf');
    }

    /////////////////////////// function /////////////////////////////

    public function addexpenses(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'category_id' => 'required|integer',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        // Get the authenticated user
        $user = auth()->user();

        // Fetch the budget limit for the selected category
        $category = \App\Models\Category::find($request->category_id);

        if (!$category) {
            return redirect()->back()->with('error', 'Selected category does not exist.');
        }

        // Log the retrieved category and budget for debugging
        \Log::info('Category ID: ' . $category->id . ' | Budget: ' . $category->budget);

        // Use the budget value from the category table as the budget limit
        $budgetLimit = $category->budget;

        // Fetch total expenses for the selected category from the budgets table
        $totalExpenses = Budget::where('user_id', $user->id)
            ->where('category_id', $request->category_id)
            ->sum('amount');

        // Add the new expense amount to the total
        $totalExpenses += $request->amount;

        // Log the total expenses and budget limit for debugging
        \Log::info('Total Expenses for Category ID ' . $request->category_id . ': ' . $totalExpenses . ' | Budget Limit: ' . $budgetLimit);

        // Define the threshold percentage (e.g., 90%)
        $thresholdPercentage = 0.9;
        $thresholdAmount = $budgetLimit * $thresholdPercentage;

        // Check if the total expenses are close to the budget limit (within 90% of the budget limit)
        if ($totalExpenses >= $thresholdAmount && $totalExpenses < $budgetLimit) {
            // Log when the "close to overspending" notification is triggered
            \Log::info('Close to overspending notification triggered for user: ' . $user->id . ' in Category ID: ' . $request->category_id);

            // Trigger the "close to overspending" notification and pass the category budget limit
            $user->notify(new \App\Notifications\CloseToOverspendingNotification($totalExpenses, $budgetLimit));
        }

        // Check if the total expenses have exceeded the budget limit (overspending)
        if ($totalExpenses > $budgetLimit) {
            // Log when the overspending notification is triggered
            \Log::info('Overspending notification triggered for user: ' . $user->id . ' in Category ID: ' . $request->category_id);

            // Trigger the overspending notification and pass the category budget limit
            $user->notify(new \App\Notifications\OverspendingNotification($totalExpenses, $budgetLimit));
        }

        // Add the expense to the database
        Budget::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'date' => $request->date,
        ]);

        return redirect()->route('budget')->with('success', 'Expense added successfully!');
    }

    public function deleteexpenses($id)
    {
        $data = Budget::find($id);

        if ($data) {
            $data->delete();
            // Set a success message in the session
            return redirect()->back()->with('success', 'Expense deleted successfully!');
        }

        // Optionally, if the expense was not found, you can also return an error message
        return redirect()->back()->with('error', 'Expense not found.');
    }

    public function updateexpensefunc(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string',
            'category_id' => 'required|integer',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        // Attempt to find the expense and update it
        try {
            // Find the expense by ID
            $expense = Budget::findOrFail($id); // Throws an error if not found

            // Update the expense details
            $expense->name = $request->name;
            $expense->category_id = $request->category_id;
            $expense->amount = $request->amount;
            $expense->date = $request->date;

            // Save the updated expense to the database
            $expense->save();

            // Redirect with success message
            return redirect()->route('budget')->with('success', 'Expense updated successfully!');
        } catch (\Exception $e) {
            // Log the error or handle it as needed (optional)

            // Redirect back with error message
            return redirect()->back()->with('error', 'Failed to update expense. Please try again.');
        }
    }

    public function adjustbudget(Request $request, $id)
    {
        // Validate the budget input to ensure it's a valid number and not negative
        $request->validate([
            'budget' => 'required|numeric|min:0', // The budget must be at least 0
        ]);

        try {
            // Find the category by its ID or fail if not found
            $category = Category::findOrFail($id);

            // Update the budget for the category
            $category->budget = $request->budget;

            // Save the changes
            if ($category->save()) {
                // If the save was successful, redirect with a success message
                return redirect()->route('expensesbudget')->with('success', 'Budget updated successfully!');
            } else {
                // If the save failed, redirect with an error message
                return redirect()->route('expensesbudget')->with('error', 'Failed to update the budget. Please try again.');
            }

        } catch (\Exception $e) {
            // Catch any exceptions (e.g., database issues) and redirect with an error message
            return redirect()->route('expensesbudget')->with('error', 'An error occurred while updating the budget: ' . $e->getMessage());
        }
    }

    public function uploadexcel(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx',
        ]);

        try {
            // Import the Excel file data into the database
            Excel::import(new ExpensesImport, $request->file('file'));

            return redirect()->route('budget')->with('success', 'Excel file imported successfully. Expense added successfully!');
        } catch (\Exception $e) {
            Log::error('Import Error: ' . $e->getMessage()); // Log the error
            return redirect()->route('budget')->with('error', 'Failed to import Excel file.');
        }
    }

    public function insertcategory(Request $request)
    {
        $user = auth()->user();

        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string',  // Validate the 'name' field
            'budget' => 'required|numeric|min:0', // Validate the 'budget' field (should be a positive number)
        ]);

        // Insert new category into the database
        $category = new Category();
        $category->name = $validatedData['name'];
        $category->budget = $validatedData['budget'];
        $category->user_id = $user->id;
        $category->save();

        // Redirect or return a response (optional)
        return redirect()->route('expensesbudget')->with('success', 'Category added successfully!');
    }

    public function deletecategory($id)
    {
        $data = Category::find($id);

        if ($data) {
            $data->delete();
            // Set a success message in the session
            return redirect()->back()->with('success', 'Category deleted successfully!');
        }

        // Optionally, if the expense was not found, you can also return an error message
        return redirect()->back()->with('error', 'Category not found.');

    }

    public function updatecategory(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string',
        ]);

        try {
            // Find the goal by ID
            $category = Category::findOrFail($id); // Throws an error if not found

            // Add the new current amount to the existing amount
            $category->name = $request->name;

            // Save the updated goal to the database
            $category->save();

            // Redirect with success message
            return redirect()->route('expensesbudget')->with('success', 'Category updated successfully!');
        } catch (\Exception $e) {
            // Log the error or handle it as needed (optional)

            // Redirect back with error message
            return redirect()->back()->with('error', 'Failed to update category. Please try again.');
        }

    }

}
