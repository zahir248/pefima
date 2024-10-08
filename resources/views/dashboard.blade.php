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
                        <a href="{{ route('budget') }}" class="block p-4 bg-white text-blue-600 rounded-lg shadow hover:bg-blue-500 hover:text-white transition duration-300 ease-in-out">
                            Budget Tracking
                        </a>
                        <a href="{{ route('goal') }}" class="block p-4 bg-white text-blue-600 rounded-lg shadow hover:bg-blue-500 hover:text-white transition duration-300 ease-in-out">
                            Savings Goals
                        </a>
                        <a href="#" class="block p-4 bg-white text-blue-600 rounded-lg shadow hover:bg-blue-500 hover:text-white transition duration-300 ease-in-out">
                            Debt Tracking
                        </a>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="w-3/4 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 ml-4">
                    <div class="text-gray-900">
                        {{ __("You're logged in!") }}
                    </div>
                    <!-- Additional content can go here -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
