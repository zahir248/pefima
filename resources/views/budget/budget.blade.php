<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Expense Tracking') }}
        </h2>
    </x-slot>

    @section('title', 'Expense Tracking') <!-- Setting the title specific to this page -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Display Success Message if Available -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="text-gray-900 mb-6">
                    <h3 class="text-lg font-semibold">Track Your Expenses</h3>
                </div>

                <!-- Navigation Buttons -->
                <a href="{{ route('expensesinput') }}" class="btn btn-success mb-4" style="margin-right: 5px">Input
                    Expenses</a>
                <a href="{{ route('expensesbudget') }}" class="btn btn-warning text-white mb-4">View Budgets</a>

                <!-- Filter Form -->
                <form method="GET" action="{{ route('budget') }}" class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Filter by Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Name</label>
                            <input type="text" id="name" name="name" value="{{ request('name') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                placeholder="Search by name">
                        </div>
                        <!-- Filter by Category -->
                        <div class="mb-4">
                            <label for="category_id" class="block text-gray-700">Category</label>
                            <select id="category_id" name="category_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter by Date -->
                        <div class="mb-4">
                            <label for="start_date" class="block text-gray-700">Date</label>
                            <input type="date" id="date" name="date" value="{{ request('date') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                    </div>

                    <button type="submit"
                        class="btn btn-secondary bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                        Apply Filters
                    </button>
                </form>

                <!-- Display Filtered Expenses -->
                <div class="mt-6">
                    <h4 class="text-lg font-semibold">Your Expenses</h4>
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark text-center">
                            <tr>
                                <th>No</th> <!-- New column for serial number -->
                                <th>Name</th>
                                <th>Category</th>
                                <th>Amount (RM)</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse($expenses as $index => $expense) <!-- Use $index for serial number -->
                                <tr>
                                    <td>{{ $index + 1 }}</td> <!-- Display serial number -->
                                    <td>{{ $expense->name }}</td>
                                    <td>{{ $expense->category->name }}</td>
                                    <td>{{ $expense->amount }}</td>
                                    <td>{{ $expense->date }}</td>
                                    <td>
                                        <a href="{{ url('/budget/updateexpense', $expense->id) }}" class="btn btn-primary"
                                            style="margin-right: 5px">Edit</a>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal" data-expense-id="{{ $expense->id }}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No expenses found for the selected filters.</td>
                                    <!-- Adjust colspan -->
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- Ensure to add Bootstrap CSS if not already included -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Add Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this expense?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteExpenseForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        var deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Button that triggered the modal
            var expenseId = button.getAttribute('data-expense-id'); // Extract info from data-expense-id attribute
            var form = document.getElementById('deleteExpenseForm');

            // Update the form action to include the correct expense ID
            form.action = '/deleteexpenses/' + expenseId;
        });
    </script>


</x-app-layout>