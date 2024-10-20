<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pefima</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">

    <!-- Custom Styles -->
    <style>
        html, body {
            height: 100%; /* Set full height for html and body */
            margin: 0; /* Remove default margin */
            display: flex; /* Use flexbox for body */
            flex-direction: column; /* Align children in a column */
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: #556C7E; /* Set the background color of the page */
        }

        .feature-card {
            height: 150px; /* Decrease the height */
            display: flex;
            justify-content: center; /* Horizontal center */
            align-items: center; /* Vertical center */
            padding: 10px; /* Reduce padding for a smaller appearance */
            color: white; /* Set text color to white for better visibility */
            background-size: cover; /* Ensure the image covers the entire card */
            background-position: center; /* Center the background image */
        }

        /* Background images for each card */
        .budget-tracking {
            background-image: url('/images/budget.jpg'); /* Change this to your image URL */
        }

        .savings-goals {
            background-image: url('/images/goal.jpg'); /* Change this to your image URL */
        }

        .debt-management {
            background-image: url('/images/debt.jpg'); /* Change this to your image URL */
        }

        .financial-reports {
            background-image: url('/images/report.jpeg'); /* Change this to your image URL */
        }

        .feature-card h5 {
            font-size: 1.5rem; /* Adjust the font size for the text */
            display: flex;
            align-items: center; /* Center items vertically */
            justify-content: center; /* Center items horizontally */
        }

        .feature-card h5 i {
            font-size: 2rem; /* Increase icon size */
            margin-right: 15px; /* Increase the space between the icon and text */
        }

        .feature-container {
            max-width: 100%; /* Set the overall width of the grid to 100% */
            margin: 0; /* Remove margin */
            padding: 0; /* Remove padding */
        }

        /* Main content area */
        .content {
            flex: 1; /* This will allow the content area to grow and take available space */
            padding-bottom: 100px; /* Add bottom padding for space above the footer */
        }

        /* Header styles */
        .header {
            background-color: #23272F; /* Dark background for the header */
            color: white; /* White text color */
            padding: 20px 0; /* Padding for spacing */
        }

        /* Footer styles */
        footer {
            background-color: #23272F; /* Dark background for the footer */
            color: white; /* White text color */
            text-align: center; /* Centered text */
            padding: 25px 0; /* Padding for spacing */
            width: 100%; /* Full width */
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="container d-flex justify-content-end">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/home') }}" class="btn btn-primary">Home</a>
                @else
                    <!-- Login and Register buttons -->
                    <a href="{{ route('login') }}" class="text-white" >Login</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-5 text-white">Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </div>

    <div class="container mt-5 content">
        <!-- Content Section -->
        <div style="background-color: #556C7E;">
            <div class="card-body text-center">
                <h2 class="card-title text-white">Personal Finance Management System</h2>
                <p class="card-text text-white">Manage your finances efficiently with our system designed for budget tracking, savings goals, and debt management.</p>

                <!-- Grid Layout for Features -->
                <div class="row mt-4 feature-container">
                    <!-- First Row: Budget Tracking and Savings Goals -->
                    <div class="col-12 col-sm-6 mb-3">
                        <div class="card feature-card text-center shadow-sm budget-tracking">
                            <div class="card-body">
                                <h5 class="card-title" style="margin-top: 30px">
                                    Budget Tracking
                                </h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 mb-3">
                        <div class="card feature-card text-center shadow-sm savings-goals">
                            <div class="card-body">
                                <h5 class="card-title" style="margin-top: 30px">
                                    Savings Goals
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row feature-container">
                    <!-- Second Row: Debt Management and Financial Reports -->
                    <div class="col-12 col-sm-6 mb-3">
                        <div class="card feature-card text-center shadow-sm debt-management">
                            <div class="card-body">
                                <h5 class="card-title" style="margin-top: 30px">
                                    Debt Management
                                </h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 mb-3">
                        <div class="card feature-card text-center shadow-sm financial-reports">
                            <div class="card-body">
                                <h5 class="card-title" style="margin-top: 30px">
                                    Financial Reports
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
    &copy; 2024 Developed by Muhammad Zahiruddin
</footer>


    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
