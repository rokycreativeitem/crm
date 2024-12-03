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
   function server_side_datatable(columnsParam, url) {
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
                url: url,
                type: 'GET',
                data: function (d) {
                    $('#filters-container :input').each(function () {
                        var name = $(this).attr('name');
                        var value = $(this).val();
                        if (name) {
                            d[name] = value || null;
                        }
                    });
                },
                // success: function(e){
                //     console.log(e);
                //     alert()
                // },
                error: function (xhr, error, thrown) {
                    console.log(xhr.responseText);
                }
            },
            columns: columns,
            orderCellsTop: true,
            ordering: false,
            pageLength: 10,
            paging: true,
        });

        table.on('xhr', function (e, settings, json, xhr) {
            if (json && json.filter_count !== undefined) {
                if (json.filter_count > 0) {
                    $('#filter-count-display').text(json.filter_count).removeClass('d-none');
                    $('#filter-reset').removeClass('d-none');
                    $('#filterDropdownButton').addClass('p3-0');
                }
            }
            if (json && json.context_menu) {
                try {
                    const context_menu = JSON.parse(json.context_menu);
                    console.log("Received context menu:", context_menu);
                    init_context_menu(context_menu);
                } catch (e) {
                    console.error("Error parsing context menu JSON:", e);
                }
            }
        });

        $('#custom-search-box').on('keyup', function(e) {
            table.ajax.reload();
        });

        $('#page-length-select').on('change', function () {
            var newLength = $(this).val();
            table.page.len(newLength).draw();
        });

    }

    function init_context_menu(context_menu) {
        const contextMenuItems = {};
        $.each(context_menu, function (key, value) {
            contextMenuItems[key] = {
                name: value.name,
                callback: function (itemKey, opt, e) {
                    const url = value.action_link;
                    window.location.href = url;
                }
            };
        });

        console.log("Initializing context menu with:", contextMenuItems);
        $.contextMenu({
            selector: '.category-context-menu',
            autoHide: false,
            items: contextMenuItems
        });
    }


$(document).ready(function () {
    // Handle delete-selected button click
    $('#delete-selected').on('click', function () {
        var selectedIds = [];
        $('.table-checkbox:checked').each(function () {
            var rowId = $(this).closest('tr').find('.datatable-row-id').val();
            if (rowId) {
                selectedIds.push(rowId);
            }
        });

        var database_type = $('#datatable_type').val();
        if (selectedIds.length > 0) {
            multiDelete(selectedIds, database_type); // Call the multiDelete function
            $('#delete-selected').addClass('d-none');
        } else {
            alert('Please select at least one file to delete.');
        }
    });

    // Handle filter button click
    $('#filter').on('click', function () {
        $('.server-side-datatable').DataTable().ajax.reload(null, false); // Reload the DataTable
    });

    // Handle filter-reset button click
    $('#filter-reset').on('click', function () {
        // Reset select elements to 'all'
        $('#status, #client, #staff, #category, #task, #team').val('all');

        // Clear specific input fields
        $('#start_date, #end_date, #progress, .minPrice').val('');

        // Hide filter-related elements
        $('.filter-count-display, #filter-reset').addClass('d-none');

        // Reload the DataTable
        $('.server-side-datatable').DataTable().ajax.reload(null, false);
    });
});


</script>