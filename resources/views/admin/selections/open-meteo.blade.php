{{-- @extends('layouts.admin_base')

@section('title', 'Admin-Data Source-Open Meteo')

@section('page-title', 'Data Source - Open Meteo')

@section('content')

    <form action="{{ route('admin.update_options_open_meteo') }}" method="POST">
        @csrf
        <div id="edit-options-container">
            @foreach (config('weather_options.daily') as $key => $label)
                <div class="flex items-center mb-2">
                    <input type="text" name="option_label[]" value="{{ $label }}" class="form-input mr-2">
                    <input type="text" name="option_value[]" value="{{ $key }}" class="form-input">
                    <button type="button"
                        class="bg-red-600 text-white px-2 py-1 ml-2 rounded-md remove-option-btn">Remove</button>
                </div>
            @endforeach
        </div>

        <button type="button" id="add-new-option-btn"
            class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Add New Option</button>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Save Changes</button>
    </form>

    <script>
        // Add event listener for adding new options
        document.getElementById('add-new-option-btn').addEventListener('click', function() {
            const container = document.getElementById('edit-options-container');
            const newOption = document.createElement('div');
            newOption.classList.add('flex', 'items-center', 'mb-2');
            newOption.innerHTML = `
            <input type="text" name="option_label[]" placeholder="Label" class="form-input mr-2">
            <input type="text" name="option_value[]" placeholder="Value" class="form-input">
            <button type="button" class="bg-red-600 text-white px-2 py-1 ml-2 rounded-md remove-option-btn">Remove</button>
        `;
            container.appendChild(newOption);

            // Add event listener for remove button
            newOption.querySelector('.remove-option-btn').addEventListener('click', function() {
                newOption.remove();
            });
        });

        // Remove button logic to delete fields dynamically
        document.querySelectorAll('.remove-option-btn').forEach(button => {
            button.addEventListener('click', function() {
                this.parentElement.remove();
            });
        });
    </script>


@endsection --}}


@extends('layouts.admin_base')

@section('title', 'Admin-Data Source-Open Meteo')

@section('page-title', 'Data Source - Open Meteo')

@section('content')


    <div class="flex justify-end mb-4">
        <button type="button" id="add-new-option-btn"
            class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 mr-2">Add New Option</button>
        <button type="submit" form="options-form" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Save
            Changes</button>
    </div>
    <form id="options-form" action="{{ route('admin.update_options_open_meteo') }}" method="POST">
        @csrf
        <table id="options-table" class="display">
            <thead>
                <tr>
                    <th>Label</th>
                    <th>Value</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach (config('weather_options.daily') as $key => $label)
                    <tr>
                        <td><input type="text" name="option_label[]" value="{{ $label }}" class="form-input"></td>
                        <td><input type="text" name="option_value[]" value="{{ $key }}" class="form-input"></td>
                        <td>
                            <button type="button"
                                class="bg-red-600 text-white px-2 py-1 rounded-md remove-option-btn">Remove</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>

    <script>
        // Initialize DataTable
        $(document).ready(function() {
            $('#options-table').DataTable({
                paging: false, // Disable paging if you want to display all options in one page
                info: false, // Disable info
                searching: true // Disable searching
            });
        });

        // Add new option row
        document.getElementById('add-new-option-btn').addEventListener('click', function() {
            const table = $('#options-table').DataTable();
            table.row.add([
                `<input type="text" name="option_label[]" placeholder="Label" class="form-input">`,
                `<input type="text" name="option_value[]" placeholder="Value" class="form-input">`,
                `<button type="button" class="bg-red-600 text-white px-2 py-1 rounded-md remove-option-btn">Remove</button>`
            ]).draw();

            // Attach event listener to the new remove button
            const newRowIndex = table.rows().count() - 1; // Get the index of the new row
            $(`#options-table tbody tr:eq(${newRowIndex}) .remove-option-btn`).on('click', function() {
                table.row($(this).parents('tr')).remove().draw(); // Remove the row from the DataTable
            });
        });

        // Event listener for existing remove buttons
        $(document).on('click', '.remove-option-btn', function() {
            const table = $('#options-table').DataTable();
            table.row($(this).parents('tr')).remove().draw(); // Remove the row from the DataTable
        });
    </script>

@endsection
