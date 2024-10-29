<!-- resources/views/components/cardRevenue.blade.php -->
<div class="col">
    <div class="card mb-3 m-shadow">
        <div class="card-body">

          <div class="d-flex justify-content-between align-items-center p-1 mx-4">
            
            <div>
              <h5 class="d-flex justify-content-between align-items-center card-title fw-bold mb-1"> {{ $titleFirst }} <!-- Receita Hoje -->
              <span class="round-pill" data-bs-toggle="tooltip" title="{{ $tooltip }}"> {{ $comparison }} <!-- -6.8% --> </span>
              </h5>
              <h6 class="text-body-tertiary"> {{ $titleSecond }} <!-- Captado --> </h6>
            </div>
            
            <h2 class="card-title fw-bold"> {{ $revenue }} </h2>

          </div>

          <div class="revenue-dashboard" id='{{ $graphId }}'>
            
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
                      <td>{{ $customers }}</td>
                      <td>{{ $orders }}</td>
                      <td>{{ $amount }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="text-left p-1 mx-4">
              <h6 class="card-title fw-bold fs-6"> {{ $subtitleMain }} <!-- Pagamentos: --> </h6>
            </div>

            <div class="d-flex justify-content-evenly align-items-center">
                <div class="d-flex justify-content-evenly">
                  <h6 class="round-pill"></h6>
                  <h6 class="card-title fw-bold fs-custom"> {{ $subtitleFirst }} <!--Confirmados: --> </h6>
                  <h6 class="text-body fs-custom" id='payments-confimed'> {{ $valueFirst }} </h6>
                </div>

                <div class="d-flex justify-content-evenly">
                  <h6 class="round-pill"></h6>
                  <h6 class="card-title fw-bold fs-custom"> {{ $subtitleSecond }} <!-- Pendentes: --> </h6>
                  <h6 class="text-body fs-custom" id='payments-pending'> {{ $valueSecond }} </h6>
                </div>

            </div>

        </div>
    </div>
</div>