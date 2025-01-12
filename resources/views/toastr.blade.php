<div class="toast-container position-fixed top-0 end-0 p-3"></div>

<div class="d-none" id="toaster-content">
    <div class="toast fade text-12" role="alert" aria-live="assertive" aria-atomic="true" id="type">
        <div class="toast-header">
            <i class="me-2 mt-2px text-14 d-flex" id="icon"></i>
            <strong class="me-auto" id="header"></strong>
            <small>{{ get_phrase("Just Now") }}</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="message"></div>
    </div>
</div>
<script>
    "use strict";

    function toaster_message(type, icon, header, message) {
        $("#type").addClass(type);
        $("#icon").addClass(icon);
        $("#header").html(header);
        $("#message").html(message);
        var toasterMessage = $("#toaster-content").html();
       
        $('.toast-container').html(toasterMessage);
        const toast = new bootstrap.Toast('.toast')
        toast.show()
    }

    function success(message) {
        toaster_message('success', 'fi-sr-badge-check', '{{ get_phrase('Success !') }}', message);
    }

    function warning(message) {
        toaster_message('warning', 'fi-sr-exclamation', '{{ get_phrase('Attention !') }}', message);
    }

    function error(message) {
        toaster_message('error', 'fi-sr-triangle-warning', '{{ get_phrase('An Error Occurred !') }}', message);
    }
</script>

@if ($message = Session::get('success'))
    <script>
        "use strict";
        success("{{ $message }}");
    </script>
    @php Session()->forget('success'); @endphp
@elseif($message = Session::get('error'))
    <script>
        "use strict";
        error("{{ $message }}");
    </script>
    @php Session()->forget('error'); @endphp
@elseif(isset($errors) && $errors->any())
    @php
        $message = '<ul>';
        foreach ($errors->all() as $error):
            $message .= '<li>' . $error . '</li>';
        endforeach;
        $message .= '</ul>';
    @endphp
    <script>
        "use strict";
        error("{!! $message !!}");
    </script>
@endif
