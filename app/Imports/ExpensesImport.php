<?php

namespace App\Imports;

use App\Models\Budget; // Import the Expense model
use Illuminate\Support\Facades\Auth; // Import Auth for getting the current user
use Maatwebsite\Excel\Concerns\ToModel;

use Illuminate\Support\Facades\Log; // Add this at the top

use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExpensesImport implements ToModel
{
    public function model(array $row)
    {
        Log::info('Row data:', $row); // Log each row data
        
        if (empty($row[0]) || empty($row[1]) || empty($row[2]) || empty($row[3])) {
            Log::warning('Incomplete row data, skipping row:', $row);
            return null; // Skip rows that do not have enough data
        }

        // Map the columns from the Excel file to your database columns
        return new Budget([
            'user_id' => Auth::id(), // Get the current session user ID
            'name' => $row[0], // Assuming the name is in the first column
            'category_id' => $this->getCategoryId($row[1]), // Get the category ID based on the name
            'amount' => $row[2], // Assuming amount is in the third column
            'date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3]), // Convert Excel date to PHP DateTime object
        ]);
    }

    protected function getCategoryId($categoryName)
    {
        // Map category names to IDs
        $categories = [
            'Food' => 1,
            'Transport' => 2,
            'Utilities' => 3,
            // Add more categories as needed
        ];

        return $categories[$categoryName] ?? null; // Return the category ID or null if not found
    }
}
