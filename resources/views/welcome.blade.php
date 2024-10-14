<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pefima</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styles (Optional) -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        @if (Route::has('login'))
            <div class="d-flex justify-content-end mb-3">
                @auth
                    <a href="{{ url('/home') }}" class="btn btn-primary">Home</a>
                @else
                    <!-- Login and Register buttons -->
                    <a href="{{ route('login') }}" class="btn btn-outline-primary">Login</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-secondary ml-2">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <!-- Content Section -->
        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center">Personal Finance Management System</h1>
                <p class="card-text text-center">Manage your finances efficiently with our system designed for budget
                    tracking, savings goals, and debt management.</p>

                <div class="row mt-4">
                    <!-- Feature 1: Budget Tracking -->
                    <div class="col-md-6">
                        <h2>Budget Tracking</h2>
                        <p>Our system helps you track your income and expenses effortlessly. Set up monthly budgets,
                            categorize transactions, and get real-time insights into your spending habits.</p>
                    </div>

                    <!-- Feature 2: Savings Goals -->
                    <div class="col-md-6">
                        <h2>Savings Goals</h2>
                        <p>Set and track savings goals for short-term and long-term plans. Monitor your progress and
                            receive reminders to stay on track with your savings objectives.</p>
                    </div>
                </div>

                <div class="row mt-4">
                    <!-- Feature 3: Debt Management -->
                    <div class="col-md-6">
                        <h2>Debt Management</h2>
                        <p>Manage your debts efficiently by keeping track of payment schedules and outstanding balances.
                            Get reminders to avoid missing payments and pay off your debts faster.</p>
                    </div>

                    <!-- Feature 4: Financial Reports -->
                    <div class="col-md-6">
                        <h2>Financial Reports</h2>
                        <p>Generate detailed financial reports to analyze your spending, savings, and overall financial
                            health. Export reports to PDF or Excel for easy sharing and record-keeping.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS and dependencies -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>