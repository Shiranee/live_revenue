<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>LIVE! Receita E-commerce</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	<link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/echarts@5.5.0/dist/echarts.min.js"></script>
	<link href="styles.css" rel="stylesheet">
  <script src="script.js" type="module" defer></script>
  <script src="echartOptions.js" type="module" defer></script>
</head>

<body>
  
  <header class="header m-shadow"></header>

  <div class="row center">

      <div class="col">
          <div class="card mb-3 m-shadow">
              <div class="card-body">

                <div class="d-flex justify-content-between align-items-center p-1 mx-4">
                  
                  <div >
                    <h5 class="d-flex justify-content-between align-items-center card-title fw-bold mb-1">Receita Hoje
                      <span class="round-pill">-6.8%</span>
                    </h5>
                    <h6 class="text-body-tertiary">Captado</h6>
                  </div>
                  
                  <h2 class="card-title fw-bold">R$16.247</h2>

                </div>

                <div class="revenue-dashboard" id='revenue-hour'>
                  
                </div>

                  <div class="container text-center mb-2 fs-custom">
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

                  <div class="d-flex justify-content-evenly align-items-center">
                      <div class="d-flex justify-content-evenly align-items-center">
                        <h6 class="round-pill"></h6>
                        <h6 class="card-title fw-bold fs-custom">Pagamentos Confirmados:</h6>
                        <h6 class="text-body fs-custom" id='payments-confimed'>Loading...</h6>
                      </div>

                      <div class="d-flex justify-content-evenly align-items-center">
                        <h6 class="round-pill"></h6>
                        <h6 class="card-title fw-bold fs-custom">Pagamentos Confirmados:</h6>
                        <h6 class="text-body fs-custom" id='payments-pending'>Loading...</h6>
                      </div>

                  </div>

              </div>
          </div>
      </div>

      <div class="col">
          <div class="card mb-3 m-shadow">
              <div class="card-body">
                  <h5 class="card-title fw-bold">Receita Acumulada</h5>
              </div>
          </div>
      </div>

      <div class="col">
          <div class="card mb-3 m-shadow">
              <div class="card-body">
                  <h5 class="card-title fw-bold">Receita Faturada</h5>
              </div>
          </div>
      </div>

  </div>

  <div class="row center">

      <div class="col">
          <div class="card mb-3 m-shadow">
              <div class="card-body">

                <div class="d-flex justify-content-between align-items-center p-1 mx-4">
                  
                  <div >
                    <h5 class="d-flex justify-content-between align-items-center card-title fw-bold mb-1">Devoluções Hoje
                      <span class="round-pill">-6.8%</span>
                    </h5>
                  </div>
                  
                  <h2 class="card-title fw-bold">R$16.247</h2>

                </div>

              </div>
          </div>
      </div>


      <div class="col">
          <div class="card mb-3 m-shadow">
              <div class="card-body">

                <!-- <div class="d-flex justify-content-between align-items-center p-1 mx-4">
                  
                  <div >
                    <h5 class="d-flex justify-content-between align-items-center card-title fw-bold mb-1">Devoluções Acumuladas
                      <span class="round-pill">-6.8%</span>
                    </h5>
                  </div>
                  
                  <h2 class="card-title fw-bold">R$16.247</h2>

                </div> -->

              </div>
          </div>
      </div>


      <div class="col">
          <div class="card mb-3 m-shadow">
              <div class="card-body">

                <!-- <div class="d-flex justify-content-between align-items-center p-1 mx-4">
                  
                  <div >
                    <h5 class="d-flex justify-content-between align-items-center card-title fw-bold mb-1">Devoluções Faturadas
                      <span class="round-pill">-6.8%</span>
                    </h5>
                  </div>
                  
                  <h2 class="card-title fw-bold">R$16.247</h2>

                </div> -->

              </div>
          </div>
      </div>

  </div>

</body>

</html>