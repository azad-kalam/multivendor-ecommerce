<style>
    #toast-container {
        opacity: 1 !important;
    }

    #toast-container>.toast {
        opacity: 1 !important;
        background-image: none !important;
        filter: none !important;
    }

    #toast-container>.toast .toast-close-button {
        opacity: 1 !important;
    }
</style>

<script>
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
        hideMethod: "fadeOut"
    };
</script>
