<div class="container" style="width: 400px">
    <div class="input-group input-daterange align-items-center">
        <span class="input-group-text fw-bold">Período: </span>
        <input type="text" class="form-control" id="startDate" placeholder="Início">
        <span class="input-group-text fw-bold">à</span>
        <input type="text" class="form-control" id="endDate" placeholder="Fim">
    </div>
</div>

<script>
$(document).ready(function() {
    // Calculate default start and end dates
    var today = new Date();
    var firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);

    // Format dates as 'dd/mm/yyyy'
    function formatDate(date) {
        var day = String(date.getDate()).padStart(2, '0');
        var month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed
        var year = date.getFullYear();
        return day + '/' + month + '/' + year;
    }

    // Set default values
    $('#startDate').val(formatDate(firstDayOfMonth));
    $('#endDate').val(formatDate(today));

    // Initialize date range picker with pt-BR locale
    $('.input-daterange').datepicker({
        format: 'dd/mm/yyyy',
        language: 'pt-BR',   // Set language to pt-BR for Portuguese
        autoclose: true,
        todayHighlight: true
    });

    // Event: On selecting a start date, move focus to the end date
    $('#startDate').datepicker()
        .on('changeDate', function(e) {
            $('#endDate').focus(); // Automatically move focus to end date
            triggerDateChange();   // Call to trigger when both dates are selected
        });

    // Event: On selecting an end date, trigger the function if both dates are set
    $('#endDate').datepicker()
        .on('changeDate', function(e) {
            triggerDateChange();   // Call to trigger when both dates are selected
        });

    // Function to check if both dates are set and trigger the required action
    function triggerDateChange() {
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();

        // Ensure both start and end dates are selected
        if (startDate && endDate) {
            // If both dates are selected, trigger your desired action
            console.log('Both dates selected: ', startDate, endDate);

            // Send the dates to the server (optional)
            $.ajax({
                url: '/your-endpoint', // Your endpoint to handle the request
                type: 'GET', // Or 'POST' if needed
                data: {
                    startDate: startDate,
                    endDate: endDate
                },
                success: function(response) {
                    console.log('Dates sent successfully:', response);
                    // Handle the response here
                },
                error: function(error) {
                    console.log('Error sending dates:', error);
                }
            });
        }
    }
});
</script>
