@php
    use Carbon\Carbon; // Import Carbon

    // Separate debts into finished and pending
    $finishedDebts = $debts->filter(function ($debt) {
        return $debt->remaining_amount == 0;
    });

    $pendingDebts = $debts->filter(function ($debt) {
        return $debt->remaining_amount > 0;
    });
@endphp

<!DOCTYPE html>
<html>

<head>
    <title>Debt Report</title>
    <style>
        /* Add some styles for the PDF */
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <h1>Debt Report</h1>

    <h2>Finished Debts</h2>
    <table>
        <thead>
            <tr>
                <th>No</th> <!-- New column for No -->
                <th>Creditor</th>
                <th>Total Amount (RM)</th>
                <th>Paid Amount (RM)</th>
                <th>Remaining Amount (RM)</th>
                <th>Due Date</th>
            </tr>
        </thead>
        <tbody>
            @php $index = 1; @endphp <!-- Initialize index -->
            @foreach ($finishedDebts as $debt)
                <tr>
                    <td>{{ $index++ }}</td> <!-- Display index and increment -->
                    <td>{{ $debt->creditor_name }}</td>
                    <td>{{ number_format($debt->total_amount, 2) }}</td>
                    <td>{{ number_format($debt->total_amount - $debt->remaining_amount, 2) }}</td>
                    <td>{{ number_format($debt->remaining_amount, 2) }}</td>
                    <td>{{ Carbon::parse($debt->due_date)->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Pending Debts</h2>
    <table>
        <thead>
            <tr>
                <th>No</th> <!-- New column for No -->
                <th>Creditor</th>
                <th>Total Amount (RM)</th>
                <th>Paid Amount (RM)</th>
                <th>Remaining Amount (RM)</th>
                <th>Due Date</th>
            </tr>
        </thead>
        <tbody>
            @php $index = 1; @endphp <!-- Initialize index for pending debts -->
            @foreach ($pendingDebts as $debt)
                <tr>
                    <td>{{ $index++ }}</td> <!-- Display index and increment -->
                    <td>{{ $debt->creditor_name }}</td>
                    <td>{{ number_format($debt->total_amount, 2) }}</td>
                    <td>{{ number_format($debt->total_amount - $debt->remaining_amount, 2) }}</td>
                    <td>{{ number_format($debt->remaining_amount, 2) }}</td>
                    <td>{{ Carbon::parse($debt->due_date)->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>