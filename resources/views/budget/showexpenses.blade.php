<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Budgets for ' . $category->name) }}
        </h2>
    </x-slot>

    @section('title', 'Budget Details') <!-- Setting the title specific to this page -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Back Button -->
                <a href="{{ route('expensesbudget') }}" class="btn btn-secondary mb-4">
                    Back
                </a>

                <!-- Filter Form -->
                <form method="GET" action="{{ route('showexpenses', ['id' => $category->id]) }}" class="mb-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-1/4">
                            <label for="month" class="block text-sm font-medium text-gray-700">Month</label>
                            <select name="month" id="month"
                                class="mt-1 block w-full py-2 px-5 border border-gray-300 rounded-md">
                                @foreach(range(1, 12) as $month)
                                    <option value="{{ $month }}" {{ request('month', date('n')) == $month ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="w-1/4" style="margin-left: 10px">
                            <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                            <select name="year" id="year"
                                class="mt-1 block w-full py-2 px-5 border border-gray-300 rounded-md">
                                @foreach(range(2020, date('Y')) as $year)
                                    <option value="{{ $year }}" {{ request('year', date('Y')) == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="w-1/4" style="margin-top: 50px; margin-left: 10px;">
                            <button type="submit" class="btn btn-primary mb-4">Filter</button>
                        </div>

                        <div class="w-1/4" style="margin-top: 50px; margin-left: 10px">
                            <!-- Button to download pdf -->
                            <a href="{{ route('downloadpdf', $category->id) }}"
                                class="btn btn-info mb-4">
                                Download Report
                            </a>
                        </div>

                    </div>
                </form>

                <!-- Display Total Amount -->
                <div class="mb-4">
                    @if(request('month') && request('year'))
                        <p class="text-xl font-semibold text-gray-800">
                            Total Amount for {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}: RM
                            {{ number_format($filteredTotalAmount, 2) }}
                        </p>
                    @else
                        <p class="text-xl font-semibold text-gray-800">
                            Total Amount: RM {{ number_format($totalAmount, 2) }}
                        </p>
                    @endif
                </div>



                @if($budgets->isEmpty())
                    <p class="text-gray-600">No expenses found for this category in the selected month and year.</p>
                @else
                    <!-- Display Budget Expenses -->
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-dark text-center text-white">
                                <th class="px-4 py-2 border border-gray-300">No</th> <!-- New column for serial number -->
                                <th class="px-4 py-2 border border-gray-300">Name</th>
                                <th class="px-4 py-2 border border-gray-300">Amount (RM)</th>
                                <th class="px-4 py-2 border border-gray-300">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($budgets as $index => $budget)
                                <tr class="text-center">
                                    <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                                    <!-- Display serial number -->
                                    <td class="border border-gray-300 px-4 py-2">{{ $budget->name }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $budget->amount }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $budget->date }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>