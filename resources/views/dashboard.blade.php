<x-app-layout>
    @section('title', 'Dashboard') <!-- Setting the title specific to this page -->

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
<div class="col-md-3 mb-4"> <!-- Use col-md-3 for a sidebar width of 1/4 -->
    <div class="bg-white p-4 rounded-lg shadow-md text-center">
        <div class="mb-3">
            <a href="{{ route('budget') }}" 
               class="d-block bg-primary text-white p-3 rounded-lg shadow-lg hover:bg-red-700 transition duration-300 ease-in-out mb-3" style="text-decoration:none">
                Budget Tracking
            </a>
            <a href="{{ route('goal') }}" 
               class="d-block bg-success text-white p-3 rounded-lg shadow-lg hover:bg-blue-700 transition duration-300 ease-in-out mb-3" style="text-decoration:none">
                Savings Goal
            </a>
            <a href="{{ route('debt') }}" 
               class="d-block bg-danger text-white p-3 rounded-lg shadow-lg hover:bg-yellow-700 transition duration-300 ease-in-out mb-3" style="text-decoration:none">
                Debt Tracking
            </a>
        </div>
    </div>
</div>


                <!-- Main Content -->
                <div class="col-md-9"> <!-- Use col-md-9 for a main content width of 3/4 -->
                    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-4">
                        <div class="row">
                            <!-- Budgets Card -->
                            <div class="col-sm-4 mb-4"> <!-- Responsive column for cards -->
                                <div class="bg-white text-black p-4 rounded-lg shadow-lg d-flex flex-column h-100 justify-content-center align-items-center"> 
                                    <img src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/icons/currency-dollar.svg" 
                                         class="w-16 h-16 mb-2" alt="Budget Icon">
                                    <h4 class="font-semibold text-lg text-center">Budgets</h4>
                                    <p class="text-lg z-10 text-center">{{ $budgetCount }}</p>
                                </div>
                            </div>

                            <!-- Savings Goals Card -->
                            <div class="col-sm-4 mb-4"> <!-- Responsive column for cards -->
                                <div class="bg-green-500 text-black p-4 rounded-lg shadow-lg d-flex flex-column h-100 justify-content-center align-items-center">
                                    <img src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/icons/piggy-bank.svg" 
                                         class="w-16 h-16 mb-2" alt="Savings Goals Icon">
                                    <h4 class="font-semibold text-lg text-center">Savings Goals (Pending)</h4>
                                    <p class="text-lg z-10 text-center">{{ $goalCount }}</p>
                                </div>
                            </div>

                            <!-- Debts Card -->
                            <div class="col-sm-4 mb-4"> <!-- Responsive column for cards -->
                                <div class="bg-red-500 text-black p-4 rounded-lg shadow-lg d-flex flex-column h-100 justify-content-center align-items-center">
                                    <img src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/icons/wallet.svg" 
                                         class="w-16 h-16 mb-2" alt="Debts Icon">
                                    <h4 class="font-semibold text-lg text-center">Debts (Pending)</h4>
                                    <p class="text-lg z-10 text-center">{{ $debtCount }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- Additional content can go here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
