@include('components.head', ['pageName' => 'LIVE! Receita E-commerce'])

<body>
  <header class="header m-shadow">
  </header>
  <div class="row center">

    <div class="col">
      <div class="card mb-3 m-shadow">
        <div class="card-body">

          <div class="d-flex justify-content-between align-items-center p-1 mx-4">

            <div>
              <h5 class="d-flex justify-content-between align-items-center card-title fw-bold mb-1">
                Divergencias
                <span class="round-pill" data-bs-toggle="tooltip" title="Comparado ao Mês Anterior"> -6.8% </span>
              </h5>
              <h6 class="text-body-tertiary"> Pedidos </h6>
            </div>

            <h2 class="card-title fw-bold"> 100.000 </h2>

          </div>

          <div class="revenue-dashboard" id='chart-divergences' style="height: 250px;"></div>

          <div class="container text-center fs-custom">
            <div class="row">
              <table class="table mt-1">
                <thead class="thead-light">
                  <tr>
                    <th>Clientes</th>
                    <th>Pedidos</th>
                    <th>Peças</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>10.000</td>
                    <td>10.000</td>
                    <td>10.000</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  
  </div>
</body>

</html>