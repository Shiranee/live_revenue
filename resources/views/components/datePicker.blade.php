    <div class="input-group input-daterange">
        <form method="GET" action="{{ url()->current() }}" id="dateFilterForm">
            <div class="input-group input-daterange align-items-center">
                <span class="input-group-text fw-bold">Período: </span>
                <input type="text" class="form-control" id="startDate" name="startDate" placeholder="Início">
                <span class="input-group-text fw-bold">à</span>
                <input type="text" class="form-control" id="endDate" name="endDate" placeholder="Fim">
            </div>
        </form>
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

    // Event: On selecting a start date, move focus to the end date and check if both dates are selected
    $('#startDate').datepicker()
        .on('changeDate', function(e) {
            $('#endDate').focus(); // Automatically move focus to end date
            checkAndSubmit();      // Call function to check if both dates are selected
        });

    // Event: On selecting an end date, trigger form submission if both dates are selected
    $('#endDate').datepicker()
        .on('changeDate', function(e) {
            checkAndSubmit();      // Call function to check if both dates are selected
        });

    // Function to check if both dates are selected and submit the form
    function checkAndSubmit() {
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();

        // Ensure both start and end dates are selected
        if (startDate && endDate) {
            // If both dates are selected, submit the form automatically
            $('#dateFilterForm').submit();  // Trigger form submission
        }
    }
});
</script>