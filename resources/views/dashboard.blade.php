<x-app-layout>
    @section('title', 'Dashboard') <!-- Setting the title specific to this page -->

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex">
                <!-- Sidebar as a Grid -->
                <div class="w-1/4 bg-white p-4 rounded-lg shadow-md">
                    <h3 class="font-semibold text-lg mb-4 text-black text-center">Navigation</h3>
                    <div class="grid grid-cols-1 gap-4">
                        <a href="{{ route('budget') }}"
                            class="block p-4 bg-white text-blue-600 rounded-lg shadow hover:bg-blue-500 hover:text-white transition duration-300 ease-in-out">
                            Budget Tracking
                        </a>
                        <a href="{{ route('goal') }}"
                            class="block p-4 bg-white text-blue-600 rounded-lg shadow hover:bg-blue-500 hover:text-white transition duration-300 ease-in-out">
                            Savings Goal
                        </a>
                        <a href="{{ route('debt') }}"
                            class="block p-4 bg-white text-blue-600 rounded-lg shadow hover:bg-blue-500 hover:text-white transition duration-300 ease-in-out">
                            Debt Tracking
                        </a>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="w-3/4 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 ml-4">

                    <!-- Dashboard Cards -->
                    <div class="flex space-x-4 "> <!-- Use flexbox for horizontal layout -->
                        <div class="bg-blue-500 text-black p-4 rounded-lg shadow-md flex-1">
                            <h4 class="font-semibold text-lg">Budgets</h4>
                            <p class="text-2xl">{{ $budgetCount }}</p>
                        </div>
                        <div class="bg-green-500 text-black p-4 rounded-lg shadow-md flex-1 ml-3">
                            <h4 class="font-semibold text-lg">Savings Goals (Pending)</h4>
                            <p class="text-2xl">{{ $goalCount }}</p>
                        </div>
                        <div class="bg-red-500 text-black p-4 rounded-lg shadow-md flex-1 ml-3">
                            <h4 class="font-semibold text-lg">Debts (Pending)</h4>
                            <p class="text-2xl">{{ $debtCount }}</p>
                        </div>
                    </div>
                    <!-- Additional content can go here -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>