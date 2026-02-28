function customErrorHandler(err) {
let message = "Something went wrong.";
if (err.responseJSON?.message) {
message = err.responseJSON.message || "Failed to fetch data.";
} else if (err.status === 404) {
message = "Requested URL was not found";
} else if (err.status === 401) {
message = "Unauthorized access";
} else if (err.status === 403) {
message = "Access forbidden";
} else if (err.status === 419) {
message = "CSRF token mismatch";
} else if (err.status === 422) {
message = "Validation error";
} else if (err.status === 429) {
message = "Too many requests";
} else if (err.status === 500) {
message = "Internal server error";
} else if (err.status === 502) {
message = "Bad gateway";
} else if (err.status === 503) {
message = "Service unavailable";
} else if (err.status === 504) {
message = "Gateway timeout";
}
toastr.error(message);
}
