<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Import Excel') }}
        </h2>
    </x-slot>

    @section('title', 'Import Excel') <!-- Setting the title specific to this page -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Back Button -->
                <a href="{{ route('expensesinput') }}" class="btn btn-secondary mb-4">
                    Back
                </a>

                <!-- Instructions for Excel Format -->
                <div class="mb-4">
                    <p class="text-gray-700 mb-2">
                        Please ensure your Excel file follows this format:
                    </p>
                    <ul class="list-disc list-inside text-gray-600">
                        <li><strong>Name</strong> - The name of the expense.</li>
                        <li><strong>Category</strong> - Enter the category as follows:</li>
                        <ul class="list-decimal list-inside">
                            <li>1 - Food</li>
                            <li>2 - Transport</li>
                            <li>3 - Utilities</li>
                        </ul>
                        <li><strong>Amount</strong> - The amount of the expense.</li>
                        <li><strong>Date</strong> - The date of the expense (format: YYYY-MM-DD).</li>
                    </ul>
                </div>

                <!-- Form for uploading Excel file -->
                <form action="{{ url('uploadexcel') }}" method="POST" enctype="multipart/form-data"
                    id="excelUploadForm">
                    @csrf

                    <!-- File input for uploading Excel file -->
                    <div class="mb-4">
                        <label for="file" class="block text-gray-700">Upload Excel File</label>
                        <input type="file" id="file" name="file"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" accept=".xls,.xlsx" required>
                    </div>

                    <div class="flex space-x-4">
                        <button type="submit"
                            class="btn btn-success bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                            Upload
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>