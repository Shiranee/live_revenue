<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.1/bootstrap-daterangepicker.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.1/bootstrap-daterangepicker.min.js"></script>
</head>
<body>
    <div class="container">
        <header>
            <h1>Dashboard</h1>
        </header>

        <!-- Date Range Picker -->
        <div class="row mt-3">
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control" id="dateRangePicker" placeholder="Select date range">
                    <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                </div>
            </div>
        </div>
    </div>

<form action="{{ route('/dashboard') }}" method="GET">
    <div class="row mt-3">
        <div class="col-md-4">
            <div class="input-group">
                <input type="text" class="form-control" name="date_range" id="dateRangePicker" placeholder="Select date range">
                <span class="input-group-text"><i class="bi bi-calendar"></i></span>
            </div>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>

    
    <script>
        $(function() {
            $('#dateRangePicker').daterangepicker({
                opens: 'left',
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('#dateRangePicker').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            });

            $('#dateRangePicker').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>
</body>
</html>
