<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Goals') }}
        </h2>
    </x-slot>

    @section('title', 'Edit Goals') <!-- Setting the title specific to this page -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Back Button -->
                <a href="{{ route('goal') }}" class="btn btn-secondary mb-4">
                    Back
                </a>

                <form action="{{ url('updategoal', $goal->id) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700">Name</label>
                        <input type="text" id="name" name="name" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Enter name"
                            value="{{ $goal->name }}">
                    </div>

                    <div class="mb-4">
                        <label for="target_amount" class="block text-gray-700">Target Amount (RM)</label>
                        <input type="number" id="target_amount" name="target_amount" required step="0.01"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            placeholder="Enter  target amount" value="{{ $goal->target_amount }}">

                    </div>


                    <div class="mb-4">
                        <label for="current_amount" class="block text-gray-700">Current Amount (RM)</label>
                        <input type="number" id="current_amount" name="current_amount"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            value="{{ $goal->current_amount }}">
                    </div>


                    <div class="mb-4">
                        <label for="start_date" class="block text-gray-700">Start Date</label>
                        <input type="date" id="start_date" name="start_date" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            value="{{ $goal->start_date }}">
                    </div>

                    <div class="mb-4">
                        <label for="end_date" class="block text-gray-700">End Date</label>
                        <input type="date" id="end_date" name="end_date" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            value="{{ $goal->end_date }}">
                    </div>

                    <button type="submit"
                        class=" btn btn-primary bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                        Update Goals
                    </button>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>