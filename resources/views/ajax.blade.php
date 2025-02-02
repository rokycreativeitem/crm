{{-- <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script> --}}
<script type="text/javascript" src="{{ asset('assets/vendors/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/datatable/dataTables.js') }}"></script>
<script src="{{ asset('assets/datatable/dataTables.bootstrap5.js') }}"></script>

<script>
    // "use strict";
    // $(document).ready(function() {
    // Set up the CSRF token for AJAX requests
    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });

    // Form validation setup
    // $("#ajaxForm").validate({
    //     rules: {
    //         title: {
    //             minlength: 4
    //         },
    //         customField: {
    //             customRule: true
    //         }
    //     },
    //     messages: {
    //         title: {
    //             required: "Please enter your title",
    //             minlength: "Your title must consist of at least 4 characters"
    //         }
    //     },
    //     highlight: function(element) {
    //         $(element).addClass('border-custom-error');
    //     },
    //     unhighlight: function(element) {
    //         $(element).removeClass('border-custom-error');
    //     }
    // });

    // Add custom validation method
    // $.validator.addMethod("customRule", function(value, element) {
    //     return this.optional(element) || value === "customValue";
    // }, "Please enter the custom value");

    // Handle form submission via AJAX
    // $('#ajaxForm').submit(function(e) {
    //     e.preventDefault();

    //     if ($("#ajaxForm").valid()) {
    //         const url = $(this).attr('action');
    //         const formData = new FormData(this);

    //         $.ajax({
    //             type: 'POST',
    //             url: url,
    //             data: formData,
    //             contentType: false,
    //             processData: false,
    //             success: function(response) {
    //                 if (response) {
    //                     processServerResponse(response);
    //                     $('.global.offcanvas').offcanvas('hide');
    //                     $('.server-side-datatable').DataTable().ajax.reload(null, false);
    //                     $('.global.modal').modal('hide');
    //                 }
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error('AJAX Error:', status, error);
    //             }
    //         });
    //     }
    // });
    // });


    // function ajaxCall(url, userData) {
    //     return $.ajax({
    //         type: 'POST',
    //         url: url,
    //         data: {
    //             data: userData
    //         },
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function(response) {
    //             if (response) {
    //                 processServerResponse(response);
    //             }
    //         }
    //     });
    // }



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
                    $('.global.offcanvas').offcanvas('hide');
                    $('.modal.global').hide();
                    $('.server-side-datatable').DataTable().ajax.reload(null, false);
                    processServerResponse(response);
                    if (window.location.pathname.includes('/admin/events')) {
                        location.reload();
                    }

                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        });


        function processServerResponse(response) {
            if (response.success) {
                success(response.success)
            }

            if (response.error) {
                error(response.error)
            }

            if (response.validationError) {
                // Clear previous errors
                $('.error-message').remove(); // Remove any previously appended error messages

                // Loop through each error in the validationError object
                for (let field in response.validationError) {
                    if (response.validationError.hasOwnProperty(field)) {
                        let messages = response.validationError[field];

                        // Find the input field by name and append the error messages
                        let inputField = $(`[name="${field}"]`);
                        if (inputField.length) {
                            inputField.after(
                                `<div class="error-message text-danger">${messages.join('<br>')}</div>`);
                        } else {
                            console.warn(`Input field with name '${field}' not found.`);
                        }
                    }
                }
            }

        }
    });
</script>

@include('toastr')
