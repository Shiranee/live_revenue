let debounceTimeout;
let lastDates = []; // Array to store the date pairs

$('#dateFilterForm').on('focusout', function (e) {
    e.preventDefault();

    // Get the current values of the date fields
    const currentStartDate = $('#startDate').val();
    const currentEndDate = $('#endDate').val();

    // Store the current date pair in the lastDates array
    lastDates.push({ startDate: currentStartDate, endDate: currentEndDate });

    // Clear the previous debounce timeout
    clearTimeout(debounceTimeout);

    // Set a new timeout for the debounce period (500ms)
    debounceTimeout = setTimeout(function () {
        // Only send the last date pair in the array (the final change)
        const finalDatePair = lastDates[lastDates.length - 1];

        // Format the dates for the backend
        const startDate = formatDateForBackend(finalDatePair.startDate);
        const endDate = formatDateForBackend(finalDatePair.endDate);

        // Get the route dynamically from data-route
        const route = $('#dateFilterForm').data('route');
        if (!route) {
            console.error('Route is not defined for this form');
            return;
        }

        // Send the final request with the last valid date pair
        $.ajax({
            url: route,
            type: 'GET',
            data: {
                startDate: startDate,
                endDate: endDate,
                _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token
            },
            success: function (response) {
                // Update the content of the page with the new data
                $('#dispatches-container').html(response);
                console.log("Page updated successfully with new data.");
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            },
        });

        // Clear the lastDates array to reset after sending the final request
        lastDates = [];
    }, 2000); // Debounce delay (500ms)
});

function formatDateForBackend(dateString) {
    const [day, month, year] = dateString.split('/');
    return `${year}-${month}-${day}`; // Convert to 'YYYY-MM-DD'
}
