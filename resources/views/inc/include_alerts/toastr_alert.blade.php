<script>
    $(document).ready(function() {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            preventDuplicates: true,
            onclick: null,
            showDuration: 300,
            hideDuration: 1000,
            timeOut: 2000,
            extendedTimeOut: 1000,
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
        };


        @if (session('toastr_warning'))
            toastr.warning("{{ session('toastr_warning') }}");
        @endif


        @if (session('toastr_error'))
            toastr.error("{{ session('toastr_error') }}");
        @endif


        @if (session('toastr_success'))
            toastr.success("{{ session('toastr_success') }}");
        @endif


        @if (session('session_success_toastr'))
            toastr.success("{{ session('session_success_toastr') }}");
        @endif


        @if (session('session_delete_toastr'))
            toastr.error("{{ session('session_delete_toastr') }}");
        @endif


        @if (session('session_delete'))
            toastr.success("{{ session('session_delete') }}");
        @endif


        @if (session('session_flash'))
            toastr.success("{{ session('session_flash') }}");
        @endif

    });
</script>
