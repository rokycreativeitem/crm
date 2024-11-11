<div class="toast-container position-fixed top-0 end-0 p-3"></div>

<script>
    "use strict";

    function toaster_message(type, icon, header, message) {
        var toasterMessage = '<div class="toast ' + type +
            ' fade" role="alert" aria-live="assertive" aria-atomic="true"><div class="toast-header"> <i class="' +
            icon + ' me-2 mt-2px text-20px"></i> <strong class="me-auto"> ' + header +
            ' </strong><small>Just Now</small><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div><div class="toast-body">' +
            message + '</div></div>';
        $('.toast-container').prepend(toasterMessage);
        const toast = new bootstrap.Toast('.toast')
        toast.show()
    }

    function success(message) {
        toaster_message('success', 'fi-sr-badge-check', 'Success !', message);
    }

    function warning(message) {
        toaster_message('warning', 'fi-sr-exclamation', 'Attention !', message);
    }

    function error(message) {
        toaster_message('error', 'fi-sr-triangle-warning', 'An Error Occurred !', message);
    }
</script>
