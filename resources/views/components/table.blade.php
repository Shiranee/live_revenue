<!-- resources/views/components/table.blade.php -->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.css">

<!-- Add jQuery first -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Add table export plugin and bootstrap-table dependencies -->
<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.29.0/tableExport.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table-locale-all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/extensions/export/bootstrap-table-export.min.js"></script>

<!-- Additional CSS for the table -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.css">

<table
  id="table"
  data-toggle="table"
  data-sort-class="table-active"
  data-sortable="true"
  data-pagination="true"
  data-page-size="10"
  data-height="600"
  data-show-export="true"
  data-export-types="['csv', 'excel', 'json']"
  data-url="json/data1.json"
  data-locale="en-US">
  <thead>
    <tr>
    <th data-field="Data" data-sortable="true">Data</th>
    <th data-field="Pedido" data-sortable="true">Pedido</th>
    <th data-field="Status" data-sortable="true">Status</th>
    <th data-field="Metodo Pagamento" data-sortable="true">Metodo Pagamento</th>
    <th data-field="Cupom" data-sortable="true">Cupom</th>
    <th data-field="Cupom Vendedor" data-sortable="true">Cupom Vendedor</th>
    <th data-field="Nota Fiscal" data-sortable="true">Nota Fiscal</th>
    <th data-field="Quantidade" data-sortable="true">Quantidade</th>
    <th data-field="Valor Admin" data-sortable="true">Valor Admin</th>
    <th data-field="Valor Pago" data-sortable="true">Valor Pago</th>
    <th data-field="Valor Pedido" data-sortable="true">Valor Pedido</th>
    <th data-field="Divergência" data-sortable="true">Divergência</th>
    <th data-field="Transportadora" data-sortable="true">Transportadora</th>
    <th data-field="Endereço" data-sortable="true">Endereço</th>
    </tr>
  </thead>
</table>

<script>
  // Initialize Bootstrap Table with Export options and locale customization
  $('#table').bootstrapTable({
    exportOptions: {
      fileName: 'table_data', // Set the downloaded file name
      ignoreColumn: ['actions'], // Ignore any columns if needed
    },
    formatNoMatches: function () {
      return 'No data available'; // Custom message when no data is present
    }
  });
</script>
