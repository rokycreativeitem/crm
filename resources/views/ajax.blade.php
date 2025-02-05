<script>
    "use strict";
    setTimeout(() => {
        $(document).ready(function() {
            $('#ajaxForm').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                let url = $(this).attr('action');
                let method = $(this).attr('method') || 'POST';
                $.ajax({
                    type: method,
                    url: url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        
                        $('.offcanvas').hide();
                        $('.offcanvas-backdrop').hide();
    
                        processServerResponse(response);
    
                        if (window.location.pathname.includes('/admin/events')) {
                            location.reload();
                        }
                        reloadDataTable();
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                });
            });
        });
    }, 500);
</script>
