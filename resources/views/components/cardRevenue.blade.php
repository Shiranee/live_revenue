<!-- resources/views/components/cardRevenue.blade.php -->
<div class="col">
    <div class="card mb-3 m-shadow">
        <div class="card-body">

          <div class="d-flex justify-content-between align-items-center p-1 mx-1">
            
            <div>
              <h5 class="d-flex justify-content-between align-items-center card-title fw-bold mb-1"> {{ $titleFirst }} <!-- Receita Hoje -->
              <span class="round-pill fs-c1" data-bs-toggle="tooltip" title="{{ $tooltip }}" function="checkNumber"> {{ $comparison }} <!-- -6.8% --> </span>
              </h5>
              <h6 class="text-body-tertiary"> {{ $titleSecond }} <!-- Captado --> </h6>
            </div>
            
            <h2 class="card-title fw-bold fs-t1"> {{ $revenue }} </h2>

          </div>

          <div class="revenue-dashboard" id="{{ $graphId }}"></div>
          <script type="module">
              import * as echartOptions from "{{ asset('echartOptions.js') }}";

              const seriesData = @json($revenuePeriod);

              let period = seriesData.map(item => item.period);
              let revenue = seriesData.map(item => parseFloat(item.revenue.replace(',', '.')));
              
              // let t = {
              //   revenue : [150, 230, 224, 218, 135, 147, 260],
              //   period : ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
              // }

              console.log(period, revenue);

              const gaugeData = [{
                value: 90,
                name: 'Faturado',
                itemStyle: {
                  color: 'rgb(211, 224, 199)'
                }
              }]

              if ('{{ $graphId }}' != 'chart-revenue-invoiced') {
                const chartOptions = echartOptions.optionLine('', revenue, period, false);
                startChart('{{ $graphId }}', chartOptions);
              } else {
                const gaugeOptions = echartOptions.optionBarGauge('', '{{$invoicedShare}}' );
                startChart('{{ $graphId }}', gaugeOptions);

              }
          </script>

            <div class="container text-center fs-c">
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

            <div class="text-left p-1 mx-1">
              <h6 class="card-title fw-bold fs-c"> {{ $subtitleMain }} <!-- Pagamentos: --> </h6>
            </div>

            <div class="row d-flex justify-content-evenly align-items-center">
                <div class="col d-flex justify-content-evenly">
                  <h6 class="round-pill"></h6>
                  <h6 class="card-title fw-bold fs-c1"> {{ $subtitleFirst }} <!--Confirmados: --> </h6>
                  <h6 class="text-body fs-c1" id='payments-confimed'> {{ $valueFirst }} </h6>
                </div>

                <div class="col d-flex justify-content-evenly">
                  <h6 class="round-pill pending"></h6>
                  <h6 class="card-title fw-bold fs-c1"> {{ $subtitleSecond }} <!-- Pendentes: --> </h6>
                  <h6 class="text-body fs-c1" id='payments-pending'> {{ $valueSecond }} </h6>
                </div>

            </div>

        </div>
    </div>
</div>