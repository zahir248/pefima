<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Set Budgets') }}
        </h2>
    </x-slot>

    @section('title', 'Set Budgets') <!-- Setting the title specific to this page -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

            <!-- Display error Message if Available -->
            @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

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

                <form method="POST" action="{{ url('adjustbudget', $category->id) }}" class="mb-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="mb-4">
                            <label for="budget" class="block text-gray-700">Enter Budget (RM)</label>
                            <input type="number" required step="0.01" id="budget" name="budget" value="{{ request('budget') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                    </div>

                    <button type="submit" class=" btn btn-primary bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                            Update                    
                        </button>
                </form>

            </div>
        </div>
    </div>

    
</x-app-layout>
