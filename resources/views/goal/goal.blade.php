<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Saving Goals Tracking') }}
        </h2>
    </x-slot>

    @section('title', 'Goals Tracking') <!-- Setting the title specific to this page -->

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
                    <h3 class="text-lg font-semibold">Track Your Savings Goals</h3>
                </div>

                <!-- Navigation Buttons -->
                <a href="{{ route('goalsinput') }}" class="btn btn-success mb-4" style="margin-right: 5px">Input
                    Goals</a>

                <!-- Check if there are goals -->
                @if ($goals->isEmpty())
                    <p class="text-gray-600">No savings goals created.</p>
                @else
                    <!-- Table to Display All Goals -->
                    <table class="table table-striped text-center table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th class="px-4 py-2 border border-gray-300">No</th>
                                <th scope="col">Goal Name</th>
                                <th scope="col">Target Amount (RM)</th>
                                <th scope="col">Current Amount (RM)</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Progress</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($goals as $index => $goal)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                                    <td>{{ $goal->name }}</td>
                                    <td>{{ number_format($goal->target_amount, 2) }}</td>
                                    <td>{{ number_format($goal->current_amount, 2) }}</td>
                                    <td>{{ Carbon\Carbon::parse($goal->start_date)->format('Y-m-d') }}</td>
                                    <td>{{ Carbon\Carbon::parse($goal->end_date)->format('Y-m-d') }}</td>
                                    <td
                                        style="color: {{ $goal->progress() < 50 ? 'red' : ($goal->progress() < 100 ? 'orange' : 'green') }};">
                                        {{ number_format($goal->progress(), 2) }}%
                                    </td>
                                    <td>
                                        <a href="{{ url('/goal/editcurrentamount', $goal->id) }}"
                                            class="btn btn-info mb-4 text-white">Add Amount</a>
                                        <a href="{{ url('/goal/editgoal', $goal->id) }}" class="btn btn-primary mb-4">Edit</a>
                                        <button onclick="openModal({{ $goal->id }})" class="btn btn-danger mb-4">Delete</button>
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
                        <p>Are you sure you want to delete this goal?</p>
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script>
        function openModal(goalId) {
            document.getElementById('deleteForm').action = '{{ url('deletegoals') }}/' + goalId;
            document.getElementById('confirmationModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('confirmationModal').classList.add('hidden');
        }
    </script>

</x-app-layout>