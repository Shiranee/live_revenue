function formatDateForBackend(dateString) {
    const [day, month, year] = dateString.split('/');
    return `${year}-${month}-${day}`; // Convert to 'YYYY-MM-DD'
}

$(document).ready(function () {
    // Listen for changes in the form
    $('#dateFilterForm').on('change', function (e) {
        e.preventDefault();

        // Get the route dynamically from data-route
        const route = $(this).data('route');

        if (!route) {
            console.error('Route is not defined for this form');
            return;
        }

        const startDate = formatDateForBackend($('#startDate').val());
        const endDate = formatDateForBackend($('#endDate').val());

        // Send AJAX request
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
                $('#content-area').html(response);
                console.log("Page updated successfully with new data.");
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            },
        });
    });
});
