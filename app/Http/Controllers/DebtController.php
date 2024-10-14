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

class DebtController extends Controller
{
    ///////////////////////////// view ///////////////////

    public function debt()
    {

        $userId = auth()->id(); // Get the currently authenticated user's ID


        $debts = Debt::where('user_id', $userId)->get(); // Fetch goals for the logged-in user

        return view('debt.debt', compact('debts'));
    }

    public function debtsinput()
    {
        return view('debt.debtsinput');

    }

    public function addamountpaid($id)
    {
        $debt = Debt::findOrFail($id); // This will throw a 404 if the category is not found

        return view('debt.addamountpaid', compact('debt'));
    }

    public function editdebt($id)
    {
        $debt = Debt::findOrFail($id); // This will throw a 404 if the category is not found

        return view('debt.editdebt', compact('debt'));
    }

    public function downloadreport()
    {
        // Retrieve the debts associated with the logged-in user
        $debts = Debt::where('user_id', auth()->id())->get(); // Fetch debts for the authenticated user

        // Load the view and pass the data
        $pdf = PDF::loadView('debt.debtreport', compact('debts'));

        // Download the PDF file
        return $pdf->download('debt_report.pdf');
    }

    ////////////////////////////////// function ///////////////////////

    public function adddebts(Request $request)
    {
        $request->validate([
            'lender_name' => 'required|string',
            'total_amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        $user = auth()->user();

        // Set remaining_amount to be the same as total_amount
        $remainingAmount = $request->total_amount;

        // Add the debt to the database
        Debt::create([
            'user_id' => $user->id,
            'creditor_name' => $request->lender_name,
            'total_amount' => $remainingAmount, // Use remainingAmount here
            'remaining_amount' => $remainingAmount,
            'due_date' => $request->date,
        ]);

        return redirect()->route('debt')->with('success', 'Debt added successfully!');
    }

    public function insertamountpaid(Request $request, $id)
    {
        $request->validate([
            'amount_paid' => 'required|numeric|min:0',
        ]);

        // Find the debt by its ID
        $debt = Debt::findOrFail($id);

        // Calculate the new remaining amount
        $newRemainingAmount = $debt->remaining_amount - $request->amount_paid;

        // Ensure the new remaining amount is not negative
        if ($newRemainingAmount < 0) {
            return redirect()->route('debt')->withErrors('Amount paid exceeds remaining amount.');
        }

        // Update the remaining_amount in the database
        $debt->update([
            'remaining_amount' => $newRemainingAmount,
        ]);

        return redirect()->route('debt')->with('success', 'Amount paid updated successfully!');
    }

    public function updatedebts(Request $request, $id)
    {

        // Validate the request
        $request->validate([
            'lender_name' => 'required|string',
            'total_amount' => 'required|numeric|min:0',
            'remaining_amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',

        ]);

        try {
            // Find the goal by ID
            $debt = Debt::findOrFail($id); // Throws an error if not found

            // Update the expense details
            $debt->creditor_name = $request->lender_name;
            $debt->total_amount = $request->total_amount;
            $debt->remaining_amount = $request->remaining_amount;
            $debt->due_date = $request->due_date;

            // Save the updated debt to the database
            $debt->save();

            // Redirect with success message
            return redirect()->route('debt')->with('success', 'Debt updated successfully!');
        } catch (\Exception $e) {
            // Log the error or handle it as needed (optional)

            // Redirect back with error message
            return redirect()->back()->with('error', 'Failed to update debt. Please try again.');
        }
    }

    public function deletedebts($id)
    {
        $data = Debt::find($id);

        if ($data) {
            $data->delete();
            // Set a success message in the session
            return redirect()->back()->with('success', 'Debt deleted successfully!');
        }

        // Optionally, if the expense was not found, you can also return an error message
        return redirect()->back()->with('error', 'Debt not found.');

    }
}
