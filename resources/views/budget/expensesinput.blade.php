<!-- resources/views/add_expense.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Expenses') }}
        </h2>
    </x-slot>

    @section('title', 'Add Expenses') <!-- Setting the title specific to this page -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Back Button -->
                <a href="{{ route('budget') }}" class="btn btn-secondary mb-4">
                    Back
                </a>

                <form action="{{ url('addexpenses') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700">Name</label>
                        <input type="text" id="name" name="name" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Enter name">
                    </div>

                    <div class="mb-4">
                        <label for="category_id" class="block text-gray-700">Category</label>
                        <select id="category_id" name="category_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Select Category</option>
                            <!-- Loop through the categories passed from the controller -->
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-4">
                        <label for="amount" class="block text-gray-700">Amount (RM)</label>
                        <input type="number" id="amount" name="amount" required step="0.01"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Enter amount">
                    </div>

                    <div class="mb-4">
                        <label for="date" class="block text-gray-700">Date</label>
                        <input type="date" id="date" name="date" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <button type="submit"
                        class=" btn btn-primary bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                        Add Expense
                    </button>

                    <!-- Import excel Button -->
                    <a href="{{ route('importexcel') }}"
                        class="btn btn-success bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600"
                        style="margin-left: 10px">
                        Import Excel File
                    </a>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>