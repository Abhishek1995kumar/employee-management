<table class="table align-middle table-row-dashed fs-6 gy-5">
    <thead>
        <tr class="text-gray-400 fw-bold fs-7 text-uppercase gs-0">
            <th class="text-center">Id</th>
            <th class="text-center">Name</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody class="fw-semibold text-gray-600">
        @forelse ($permissions as $permission)
            <tr>
                <td class="text-center">{{ $permission->id }}</td>
                <td class="text-center">{{ $permission->name }}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-success action-select" onclick="showPermissio(event)" data-id="{{ $permission->id }}" data-name="{{ $permission->name }}" data-created_by="{{ $permission->created_by }}" data-created_at="{{ $permission->created_at }}"><i class="fa fa-eye"></i></button>
                    <button  class="btn btn-sm btn-warning action-select edit_permission" data-id="{{ $permission->id }}" data-name="{{ $permission->name }}"><i class="fa fa-pencil"></i></button>
                    <button  class="btn btn-sm btn-danger action-select delete_permission" data-id="{{ $permission->id }}" data-name="{{ $permission->name }}"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        @empty
            <tr><td colspan="3" class="text-center">No Data Found</td></tr>
        @endforelse
    </tbody>
</table>

@if ($totalPages > 1)
    <ul class="pagination">
        @for ($i = 1; $i <= $totalPages; $i++)
            <li class="page-item {{ $i == $page ? 'active' : '' }}">
                <a class="page-link pagination-link" href="#" data-page="{{ $i }}">{{ $i }}</a>
            </li>
        @endfor
    </ul>
@endif

<script src="https://code.jquery.com/jquery-3.7.1.min.js" ></script>
<script>
    let debounceTimer;

    function fetchData(page = 1, search = '') {
        $.ajax({
            url: "{{ route('admin.permission.ajax') }}",
            method: 'GET',
            data: { page: page, search: search },
            success: function(response) {
                $('#permissionsData').html(response);
            }
        });
    }

    // Live Search
    $('#searchInput').on('keyup', function() {
        clearTimeout(debounceTimer);
        let search = $(this).val();
        debounceTimer = setTimeout(() => {
            fetchData(1, search);
        }, 500); // debounce delay
    });

    // Pagination Click
    $(document).on('click', '.pagination-link', function(e) {
        e.preventDefault();
        let page = $(this).data('page');
        let search = $('#searchInput').val();
        fetchData(page, search);
    });
</script>
