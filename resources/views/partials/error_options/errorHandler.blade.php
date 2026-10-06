<script>
    function customErrorHandler(error) {
        const status = error?.status ?? error?.response?.status;
        const responseData = error?.responseJSON ?? error?.response?.data ?? {};
        let message = responseData?.message || null;

        // Network / Connection Error
        if (!status) {
            if (error?.statusText === "timeout" || error?.textStatus === "timeout") {
                message = "Request timed out. Please try again.";

            } else if (error?.statusText === "error" && !error?.responseJSON) {
                message = "Please check your internet connection.";

            } else {
                message = "Unable to connect to the server.";
            }

            toastr.error(message);
            return;
        }

        // Backend Message
        if (message) {
            toastr.error(message);
            return;
        }

        // HTTP Status Fallback
        switch (status) {
            case 400:
                message = "Please check the submitted data.";
                break;

            case 401:
                message = "Please log in and try again.";
                break;

            case 403:
                message = "You do not have permission.";
                break;

            case 404:
                message = "The request was not found.";
                break;

            case 405:
                message = "This action is not allowed.";
                break;

            case 408:
                message = "Request timed out. Please try again.";
                break;

            case 409:
                message = "This request conflicts. Please try again.";
                break;

            case 419:
                message = "Your session has expired. Please try again.";
                break;

            case 422:
                message = "Please check the submitted information.";
                break;

            case 429:
                message = "Too many requests. Please try again.";
                break;

            case 500:
                message = "Something went wrong. Please try again.";
                break;

            case 502:
                message = "Server is temporarily unavailable. Please try again.";
                break;

            case 503:
                message = "Service is temporarily unavailable. Please try again.";
                break;

            case 504:
                message = "Server took too long to respond. Please try again.";
                break;

            default:
                if (status >= 400 && status < 500) {
                    message = "Request could not be completed.";

                } else if (status >= 500 && status < 600) {
                    message = "Server error. Please try again later.";

                } else {
                    message = "Something went wrong.";
                }
        }
        toastr.error(message);
    }
</script>
