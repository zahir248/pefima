<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Current Amount') }}
        </h2>
    </x-slot>

    @section('title', 'Add Current Amount') <!-- Setting the title specific to this page -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Back Button -->
                <a href="{{ route('goal') }}" class="btn btn-secondary mb-4">
                    Back
                </a>

                <form action="{{ url('updatecurrentamount', $goal->id) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="current_amount" class="block text-gray-700">Amount (RM)</label>
                        <input type="number" id="current_amount" name="current_amount" value="0.00"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            value="{{ $goal->current_amount }}" required step="0.01">
                    </div>

                    <button type="submit"
                        class=" btn btn-primary bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                        Add Amount
                    </button>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>