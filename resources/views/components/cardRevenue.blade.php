<!-- resources/views/components/cardRevenue.blade.php -->
<div class="col">
    <div class="card mb-3 m-shadow">
        <div class="card-body">

          <div class="d-flex justify-content-between align-items-center p-1 mx-4">
            
            <div>
              <h5 class="d-flex justify-content-between align-items-center card-title fw-bold mb-1">Receita Hoje
              <span class="round-pill" data-bs-toggle="tooltip" title="This is a tooltip">-6.8%</span>
              </h5>
              <h6 class="text-body-tertiary">Captado</h6>
            </div>
            
            <h2 class="card-title fw-bold">R$16.247</h2>

          </div>

          <div class="revenue-dashboard" id='revenue-hour'>
            
          </div>

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

            <div class="text-left p-1 mx-4">
              <h6 class="card-title fw-bold fs-6">Pagamentos:</h6>
            </div>

            <div class="d-flex justify-content-evenly align-items-center">
                <div class="d-flex justify-content-evenly">
                  <h6 class="round-pill"></h6>
                  <h6 class="card-title fw-bold fs-custom">Confirmados:</h6>
                  <h6 class="text-body fs-custom" id='payments-confimed'>1.000.000</h6>
                </div>

                <div class="d-flex justify-content-evenly">
                  <h6 class="round-pill"></h6>
                  <h6 class="card-title fw-bold fs-custom">Pendentes:</h6>
                  <h6 class="text-body fs-custom" id='payments-pending'>1.000.000</h6>
                </div>

            </div>

        </div>
    </div>
</div>