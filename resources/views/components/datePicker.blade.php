<form id="dateFilterForm" style="width: 400px" data-route="{{ route('crmDispatches.filter') }}">
    <div class="input-group input-daterange align-items-center">
        <span class="input-group-text fw-bold">Período: </span>
        <input type="text" class="form-control" id="startDate" name="startDate" placeholder="Início" value="{{ request()->get('startDate') }}">
        <span class="input-group-text fw-bold">à</span>
        <input type="text" class="form-control" id="endDate" name="endDate" placeholder="Fim" value="{{ request()->get('endDate') }}">
    </div>
</form>


<script>
$(document).ready(function(){
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
        });
});
</script>
