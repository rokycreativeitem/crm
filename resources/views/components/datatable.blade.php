<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap5.css')}}">
<script src="{{asset('assets/js/jquery-3.7.1.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap5.js')}}"></script>
<script>

    new DataTable('#basic-datatable', {
        orderCellsTop: true,
        ordering: false
    });

   // server side data table rendering
   function server_side_datatable(columnsParam, type) {
        let columnsArray = Array.isArray(columnsParam) ? columnsParam : JSON.parse(columnsParam);
        if (!Array.isArray(columnsArray)) {
            console.error("{{get_phrase('The columns parameter should be an array or a JSON-encoded array')}}.");
            return;
        }
        let columns = columnsArray.map(columnKey => {
            return { data: columnKey };
        });
        var table = new DataTable('.server-side-datatable', {
            processing: true,
            serverSide: true,
            info: true,
            ajax: {
                url: "{{ route('server.side.datatable') }}",
                type: 'GET',
                data: function (d) {
                    d.customSearch = $('#custom-search-box').val();
                    d.type = type;
                }
            },
            columns: columns,
            orderCellsTop: true,
            ordering: false,
            pageLength: 10,
            paging: true,
        });


        $('#custom-search-box').on('keyup', function(e) {
            table.ajax.reload();
        });

        $('#page-length-select').on('change', function () {
            var newLength = $(this).val();
            table.page.len(newLength).draw();
        });

    }


    $( document ).ready(function() {
        $('#delete-selected').click(function () {
            var selectedIds = [];
            $('.table-checkbox:checked').each(function () {
                var rowId = $(this).closest('tr').find('.datatable-row-id').val();
                if (rowId) {
                    selectedIds.push(rowId);
                }
            });
            var database_type = $('#datatable_type').val();
            if (selectedIds.length > 0) {
                multiDelete(selectedIds, database_type);
                $('#delete-selected').addClass('d-none');
            } else {
                alert('Please select at least one file to delete.');
            }
        });
    });

</script>