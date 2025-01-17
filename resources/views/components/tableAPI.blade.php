<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bootstrap Table with API</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.21.2/dist/bootstrap-table.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.21.2/dist/bootstrap-table.min.js"></script>
</head>
<body>
<table
  id="table"
  data-toggle="table"
  data-url="http://127.0.0.1:8035/api/conciliation/2025-01-01/2025-01-16/table"
  data-pagination="true"
  data-side-pagination="server"
  data-page-list="[5, 10, 20, 50]"
  data-query-params="queryParams"
  data-total-field="total_rows"
  data-data-field="data">
  <thead>
    <tr>
      <th data-field="order_id">Order ID</th>
      <th data-field="customer_id">Customer ID</th>
      <th data-field="cpf_cnpj">CPF/CNPJ</th>
      <th data-field="nf_number">NF Number</th>
      <th data-field="nf_date">NF Date</th>
      <th data-field="payment_method">Payment Method</th>
      <th data-field="price_paid">Price Paid</th>
    </tr>
  </thead>
</table>

<script>
function queryParams(params) {
  console.log("Bootstrap Table Params:", params); // Debug parameters sent by Bootstrap Table

  // Construct the URL with query parameters
  const page = Math.ceil((params.offset + 1) / params.limit); // Convert offset to page number
  const page_size = params.limit; // Set the page size

  // Construct the full URL
  const baseUrl = "http://127.0.0.1:8035/api/conciliation/2025-01-01/2025-01-16/table";
  const urlWithParams = `${baseUrl}?page=${page}&page_size=${page_size}`;

  console.log("Generated API URL:", urlWithParams); // Log the full URL being requested

  // Return the query parameters to be used by Bootstrap Table
  return {
    page: page,
    page_size: page_size,
  };
}

$('#table').on('load-success.bs.table', function (e, data) {
  console.log("API Response:", data); // Debug the API response
});

$(function () {
  $('#table').bootstrapTable();
});

</script>


</body>
</html>
