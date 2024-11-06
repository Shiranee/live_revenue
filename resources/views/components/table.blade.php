<!-- resources/views/components/table.blade.php -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.29.0/tableExport.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table-locale-all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/extensions/export/bootstrap-table-export.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/extensions/auto-resize/bootstrap-table-auto-resize.min.js"></script>


<table class="fs-c1"
       id="table"
       data-toggle="table"
       data-sort-class="table-active"
       data-sortable="true"
       data-pagination="true"
       data-page-size="10"
       data-height="600"
       data-show-export="true"
       data-export-types="['csv', 'excel', 'json']"
       data-locale="en-US">
    <thead>
    <tr>
        <th data-field="order_date" data-sortable="true" data-width="auto">Data</th>
        <th data-field="order_id" data-sortable="true" data-formatter="orderIdFormatter">Pedido</th>
        <th data-field="status" data-sortable="true">Status</th>
        <th data-field="payment" data-sortable="true">Metodo Pagamento</th>
        <th data-field="coupon_discount" data-sortable="true">Cupom</th>
        <th data-field="coupon_seller" data-sortable="true">Vendedor</th>
        <th data-field="nf" data-sortable="true">NF</th>
        <th data-field="transporter" data-sortable="true">Transportadora</th>
        <th data-field="amount" data-sortable="true">Quantidade</th>
        <th data-field="order_discount" data-sortable="true">Desconto</th>
        <th data-field="order_value" data-sortable="true">Valor Admin</th>
        <th data-field="payment_value" data-sortable="true">Valor Pago</th>
        <th data-field="itens_value" data-sortable="true">Valor Pedido</th>
        <th data-field="divergence" data-sortable="true">Divergência</th>
    </tr>
    </thead>
</table>

<script>
    // Convert tableData from PHP to JSON and initialize table data
    const tableData = {!! json_encode($tableData) !!};

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
</script>