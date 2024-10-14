@php
    use Carbon\Carbon; // Import Carbon
@endphp


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Debt Tracking') }}
        </h2>
    </x-slot>

    @section('title', 'Debts Tracking') <!-- Setting the title specific to this page -->

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
                    <h3 class="text-lg font-semibold">Track Your Debts</h3>
                </div>

                <!-- Filter Form -->
                <form method="GET" action="{{ route('debt') }}" class="mb-4">
                    <div class="form-group">
                        <label for="status">Filter by Status:</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">All</option>
                            <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="Finished" {{ request('status') === 'Finished' ? 'selected' : '' }}>Finished
                            </option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Filter</button>
                </form>

                <!-- Navigation Buttons -->
                <a href="{{ route('debtsinput') }}" class="btn btn-success mb-4" style="margin-right: 5px">Input
                    Debts</a>

                <!-- Button to download pdf -->
                <a href="{{ route('downloadreport') }}" class="btn btn-warning mb-4 text-white">
                    Download Report (PDF)
                </a>

                @if ($debts->isEmpty())
                    <p class="text-gray-600">No debts created.</p>
                @else
                            <table class="table table-striped text-center table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Creditor</th>
                                        <th scope="col">Total Debt Amount (RM)</th>
                                        <th scope="col">Total Paid Amount (RM)</th>
                                        <th scope="col">Remaining Amount (RM)</th>
                                        <th scope="col">Due Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php    $index = 1; @endphp
                                    @foreach ($debts as $debt)
                                                        @php
                                                            $paidAmount = $debt->total_amount - $debt->remaining_amount;
                                                            $status = $debt->remaining_amount == 0 ? 'Finished' : 'Pending';
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $index++ }}</td>
                                                            <td>{{ $debt->creditor_name }}</td>
                                                            <td>{{ number_format($debt->total_amount, 2) }}</td>
                                                            <td>{{ number_format($paidAmount, 2) }}</td>
                                                            <td>{{ number_format($debt->remaining_amount, 2) }}</td>
                                                            <td>{{ Carbon::parse($debt->due_date)->format('Y-m-d') }}</td>
                                                            <td style="color: {{ $status === 'Finished' ? 'green' : 'red' }};">
                                                                {{ $status }}
                                                            </td>
                                                            <td>
                                                                <a href="{{ url('/debt/addamountpaid', $debt->id) }}"
                                                                    class="btn btn-info mb-4 text-white">Enter Amount Paid</a>
                                                                <a href="{{ url('/debt/editdebt', $debt->id) }}" class="btn btn-primary mb-4">Edit</a>
                                                                <button onclick="openModal({{ $debt->id }})" class="btn btn-danger mb-4">Delete</button>
                                                            </td>
                                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                @endif



                <!-- Confirmation Modal -->
                <div id="confirmationModal"
                    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                    <div class="bg-white rounded-lg p-6 w-1/3">
                        <h3 class="text-lg font-semibold mb-4">Confirm Deletion</h3>
                        <p>Are you sure you want to delete this debt?</p>
                        <div class="mt-4">
                            <form id="deleteForm" action="" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="closeModal()" class="btn btn-secondary">Cancel</button>
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-700 bg-danger text-white font-bold py-2 px-4 rounded mr-2">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>

    <!-- Ensure to add Bootstrap CSS if not already included -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Add Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script>
        function openModal(debtId) {
            // Set the action for the form in the modal
            document.getElementById('deleteForm').action = '{{ url('deletedebts') }}/' + debtId;
            // Show the modal
            document.getElementById('confirmationModal').classList.remove('hidden');
        }

        function closeModal() {
            // Hide the modal
            document.getElementById('confirmationModal').classList.add('hidden');
        }
    </script>



</x-app-layout>