@php
    use Illuminate\Support\Str;
@endphp

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap Table CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.css">

<!-- Bootstrap Table JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.js"></script>

<!-- Other Bootstrap Table Extensions -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table-locale-all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/extensions/export/bootstrap-table-export.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/extensions/auto-resize/bootstrap-table-auto-resize.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.29.0/tableExport.min.js"></script>



<!-- Toolbar with title -->
<div id="toolbar">
    <h5 class="card-title fw-bold mb-1"> {{ $title}} </h5>
</div>

<!-- Your table definition -->
<table class="fs-c1"
       id="table"
       data-toolbar="#toolbar" 
       data-toggle="table"
       data-sort-class="table-active"
       data-sortable="true"
       data-pagination="true"
       data-page-size="{{ $pageSize }}"
       data-height="600"
       data-show-export="true"
       data-export-types="['csv', 'excel', 'json']"
       data-locale="en-US">
    <thead>
    <tr>
        @foreach ($headerData as $item)
                <th data-field="{{ Str::slug($item, "_") }}" data-sortable="true" data-width="auto">{{ $item }}</th>
        @endforeach
    </tr>
    </thead>
</table>

<script>
    function callTableData() {
        // Convert tableData from PHP to JSON and initialize table data
        const tableData = {!! json_encode($tableData ?? []) !!}

        function orderIdFormatter(value, row, index) {
            return `<a href="https://admin.liveoficial.com.br/resources/orders/${value}" target="_blank">${value}</a>`;
        }

        // Initialize the table with tableData directly
        $('#table').bootstrapTable({
            data: tableData,
            autoResize: true,
            exportOptions: {
                fileName: 'table_data',
                ignoreColumn: ['actions'],
            },
            formatNoMatches: function () {
                return 'No data available';
            }
        });
    }

    $(document).ready(function() {
        // Call the function when the page is first loaded
        callTableData();
        console.log('im not running')
    });
</script>

