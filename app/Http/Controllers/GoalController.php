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

class GoalController extends Controller
{

    ////////////////////////////// view /////////////////////////

    public function goal()
    {
        $userId = auth()->id(); // Get the currently authenticated user's ID

        $goals = SavingsGoal::where('user_id', $userId)->get(); // Fetch goals for the logged-in user

        return view('goal.goal', compact('goals'));
    }

    public function goalsinput()
    {
        return view('goal.goalsinput');
    }

    public function editcurrentamount($id)
    {
        $goal = SavingsGoal::findOrFail($id);

        return view('goal.editcurrentamount', compact('goal'));
    }

    public function editgoal($id)
    {
        $goal = SavingsGoal::findOrFail($id);

        return view('goal.editgoal', compact('goal'));
    }

    /////////////////////////// function ///////////////////////?

    public function addgoals(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'target_amount' => 'required|numeric|min:0',
            'current_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date',

        ]);


        // Get the authenticated user
        $user = auth()->user();

        // Add the expense to the database
        SavingsGoal::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'target_amount' => $request->target_amount,
            'current_amount' => $request->current_amount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('goal')->with('success', 'Goal added successfully!');

    }

    public function deletegoals($id)
    {
        $data = SavingsGoal::find($id);

        if ($data) {
            $data->delete();
            // Set a success message in the session
            return redirect()->back()->with('success', 'Goal deleted successfully!');
        }

        // Optionally, if the expense was not found, you can also return an error message
        return redirect()->back()->with('error', 'Goal not found.');

    }

    public function updategoal(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string',
            'target_amount' => 'required|numeric|min:0',
            'current_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        // Attempt to find the expense and update it
        try {
            // Find the expense by ID
            $goal = SavingsGoal::findOrFail($id); // Throws an error if not found

            // Update the expense details
            $goal->name = $request->name;
            $goal->target_amount = $request->target_amount;
            $goal->current_amount = $request->current_amount;
            $goal->start_date = $request->start_date;
            $goal->end_date = $request->end_date;

            // Save the updated expense to the database
            $goal->save();

            // Redirect with success message
            return redirect()->route('goal')->with('success', 'Goal updated successfully!');
        } catch (\Exception $e) {
            // Log the error or handle it as needed (optional)

            // Redirect back with error message
            return redirect()->back()->with('error', 'Failed to update goal. Please try again.');
        }

    }

    public function updatecurrentamount(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'current_amount' => 'required|numeric|min:0',
        ]);

        try {
            // Find the goal by ID
            $goal = SavingsGoal::findOrFail($id); // Throws an error if not found

            // Add the new current amount to the existing amount
            $goal->current_amount += $request->current_amount;

            // Save the updated goal to the database
            $goal->save();

            // Redirect with success message
            return redirect()->route('goal')->with('success', 'Current Amount updated successfully!');
        } catch (\Exception $e) {
            // Log the error or handle it as needed (optional)

            // Redirect back with error message
            return redirect()->back()->with('error', 'Failed to update current amount. Please try again.');
        }
    }
}
