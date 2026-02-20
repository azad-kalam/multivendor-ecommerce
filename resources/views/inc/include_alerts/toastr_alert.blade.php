<script>
    $(document).ready(function() {
        @include('partials.toastr_options.toastr_option')


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
