<!-- resources/views/add_expense.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Debts') }}
        </h2>
    </x-slot>

    @section('title', 'Edit Debts') <!-- Setting the title specific to this page -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Back Button -->
                <a href="{{ route('debt') }}" class="btn btn-secondary mb-4">
                    Back
                </a>

                <form action="{{ url('updatedebts', $debt->id) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="lender_name" class="block text-gray-700">Creditor</label>
                        <input type="text" id="lender_name" name="lender_name" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            placeholder="Enter lender name" value="{{ $debt->creditor_name }}">
                    </div>

                    <div class="mb-4">
                        <label for="total_amount" class="block text-gray-700">Total Amount (RM)</label>
                        <input type="number" id="total_amount" name="total_amount" required step="0.01"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            placeholder="Enter total amount" value="{{ $debt->total_amount }}">
                    </div>

                    <div class="mb-4">
                        <label for="remaining_amount" class="block text-gray-700">Remaining Amount (RM)</label>
                        <input type="number" id="remaining_amount" name="remaining_amount" required step="0.01"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            placeholder="Enter remaining amount" value="{{ $debt->remaining_amount }}">
                    </div>

                    <div class="mb-4">
                        <label for="due_date" class="block text-gray-700">Due Date</label>
                        <input type="date" id="due_date" name="due_date" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            value="{{ $debt->due_date }}">
                    </div>

                    <button type="submit"
                        class="btn btn-primary bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                        Update Debts
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>