<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Budget Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table, .table th, .table td {
            border: 1px solid black;
        }
        .table th, .table td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Budget Report for {{ $category->name }}</h2>

    @php
        // Group budgets by month and year
        $groupedBudgets = [];
        foreach ($budgets as $budget) {
            $month = \Carbon\Carbon::parse($budget->date)->format('m'); // Get the month (01 to 12)
            $year = \Carbon\Carbon::parse($budget->date)->format('Y'); // Get the year (YYYY)
            $groupedBudgets["$year-$month"][] = $budget;
        }
    @endphp

    @foreach ($groupedBudgets as $key => $monthlyBudgets)
        @php
            $totalAmount = array_sum(array_column($monthlyBudgets, 'amount')); // Calculate total amount for the month
            $date = \Carbon\Carbon::createFromFormat('Y-m', $key);
        @endphp
        
        <h3>{{ $date->format('F') }} {{ $date->year }}</h3>
        <p><strong>Total Amount:</strong> RM {{ number_format($totalAmount, 2) }}</p>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Amount (RM)</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($monthlyBudgets as $monthBudget)
                    <tr>
                        <td>{{ $monthBudget->name }}</td>
                        <td>{{ number_format($monthBudget->amount, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($monthBudget->date)->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>
</html>
