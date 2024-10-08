<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Budgets') }}
        </h2>
    </x-slot>

    @section('title', 'View Budgets') <!-- Setting the title specific to this page -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

            @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

            <!-- Back Button -->
            <a href="{{ route('budget') }}" class="btn btn-secondary mb-4">
                    Back
                </a>

                <a href="{{ route('addcategory') }}" class="btn btn-success mb-4"  style="margin-left: 10px">
                    Add New Category
                </a>

                <!-- Check if there are categories -->
                @if($categories->isEmpty())
                    <p class="text-gray-600">No categories available.</p>
                @else
                    <!-- Display Category Data in a Table -->
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-dark text-center text-white">
                                <th class="px-4 py-2 border border-gray-300">Category Name</th>
                                <th class="px-4 py-2 border border-gray-300">Budget (RM)</th>
                                <th class="px-4 py-2 border border-gray-300">Total Expenses (RM) </th>
                                <th class="px-4 py-2 border border-gray-300">Usage (%)</th>
                                <th class="px-4 py-2 border border-gray-300">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr class="text-center">
                                    <td class="border border-gray-300 px-4 py-2">{{ $category->name }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $category->budget }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $category->total_expenses }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <!-- Bootstrap Progress Bar -->
                                        <div class="progress" style="height: 25px;">
                                            <div 
                                                class="progress-bar {{ $category->progress_percentage < 50 ? 'bg-success' : ($category->progress_percentage < 80 ? 'bg-warning' : 'bg-danger') }}" 
                                                role="progressbar" 
                                                style="width: {{ $category->progress_percentage }}%;" 
                                                aria-valuenow="{{ $category->progress_percentage }}" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                                {{ round($category->progress_percentage) }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <!-- Button to Set Budget -->
                                        <a href="{{ url('setbudget', $category->id) }}" class="bg-blue-500 hover:bg bg-primary text-white font-bold py-2 px-4 rounded" style="margin-right: 10px; text-decoration: none;">
                                            Set Budget
                                        </a>
                                        <!-- Button to Set Budget -->
                                        <a href="{{ url('showexpenses', $category->id) }}" class="bg-blue-500 hover:bg bg-info text-white font-bold py-2 px-4 rounded" style="text-decoration: none;">
                                            View Expenses
                                        </a>
                                        <form action="{{ url('deletecategory', $category->id) }}" method="POST" style="display:inline; margin-left: 10px" class="bg-blue-500 hover:bg bg-danger text-white font-bold py-2 px-4 rounded" onsubmit="return confirm('Are you sure you want to delete this category?');">
    @csrf
    @method('DELETE') <!-- This is necessary to specify the DELETE method -->
    <!-- Delete Button -->
<button type="button" class="bg-blue-500 hover:bg-danger text-white font-bold py-2 px-4 rounded" style="margin-left: 10px; text-decoration: none;" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="setDeleteAction('{{ url('deletecategory', $category->id) }}')">
    Delete
</button>

</form>


                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this category? All expenses under this category will also be deleted.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <form id="deleteForm" action="" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    function setDeleteAction(action) {
        // Set the form action dynamically
        document.getElementById('deleteForm').action = action;
    }
</script>



</x-app-layout>
