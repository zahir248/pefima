<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Category') }}
        </h2>
    </x-slot>

    @section('title', 'Add Category') <!-- Setting the title specific to this page -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Back Button -->
                <a href="{{ route('expensesbudget') }}" class="btn btn-secondary mb-4">
                    Back
                </a>

                <form action="{{ url('insertcategory') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700">Name</label>
                        <input type="text" id="name" name="name" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Enter name">
                    </div>

                    <div class="mb-4">
                        <label for="budget" class="block text-gray-700">Budget (RM)</label>
                        <input type="number" id="budget" name="budget" required step="0.01"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Enter budget">
                    </div>

                    <button type="submit"
                        class=" btn btn-primary bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                        Add Category
                    </button>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>