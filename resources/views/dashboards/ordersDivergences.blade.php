@include('components.head', ['pageName' => 'Divergencias De Pagamento'])

<body>
  <header class="header m-shadow">
  </header>

  <div class="row center mb-3" style="height: 80vh;">

    <div class="col h-100">

      <div class="card m-shadow h-100 d-flex flex-column justify-content-between p-3">

          <div class="d-flex justify-content-between align-items-center mx-4">

            <div>
              <h3 class="d-flex justify-content-between align-items-center card-title fw-bold mb-1">
                Divergências                
              </h3>
              <h5 class="text-body-tertiary"> Pedidos </h5>
            </div>
            <h1 class="card-title fw-bold"> 
            {{ $cardData['orders'] }}
           </h1>

          </div>

          <div class="revenue-dashboard my-chart" id='chart-divergences' style="height: 50vh;"></div>

          <div class="container text-center mt-3 fs-5">
            <div class="row">
              <table class="table">
                <thead class="thead-light">
                  <tr>
                    <th>Clientes</th>
                    <th>Pedidos</th>
                    <th>Peças</th>
                    <th>Positivas</th>
                    <th>Negativas</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td> {{ $cardData['customers'] }} </td>
                    <td> {{ $cardData['orders'] }} </td>
                    <td> {{ $cardData['amount'] }} </td>
                    <td>
                    {{ optional($divergencesType->firstWhere('name', 'Positivas'))['revenue'] ?? '0' }}
                    </td>
                    <td>
                      {{ optional($divergencesType->firstWhere('name', 'Negativas'))['revenue'] ?? '0' }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
      
      </div>

    </div>

    <div class="col d-flex flex-column h-100 justify-content-between">
      <div class="card m-shadow h-49 p-3 mx-1 d-flex justify-content-between align-items-center">
            <div class="d-flex justify-content-between align-items-center w-100">
              <div>
                <h5 class="card-title fw-bold mb-1">Divergências Por Hora</h5>
                <h5 class="text-body-tertiary fs-c">Horários em que ocorreram pedidos com divergência</h5>
              </div>
            </div>
        <div class="dashboard-fit my-chart" id='divergences-hour'></div>
      </div>

      <div class="card m-shadow h-49 p-3 mx-1 d-flex justify-content-between align-items-center">
            <div class="d-flex justify-content-between align-items-center w-100">
              <div>
                <h5 class="card-title fw-bold mb-1">Divergências Por Dia</h5>
                <h5 class="text-body-tertiary fs-c">Dias em que ocorreram pedidos com divergência</h5>
              </div>
            </div>
        <div class="dashboard-fit my-chart" id='divergences-day'></div>
      </div>
    </div>

  </div>
  
  <div class="row center mb-5">
    <div class="col">
      <div class="card p-3 m-shadow">
        @include('components.table',  ['tableData' => $tableData])
      </div>
    </div>
  </div>

<script type="module">
    import * as echartOptions from "{{ asset('echartOptions.js') }}";

    let donData = @json($divergencesTypeGraph);

    const donChartOptions = echartOptions.optionDonut('', donData);
    startChart('chart-divergences', donChartOptions);

    const seriesData = [
        { elementId: 'divergences-hour', data: @json($divergencesHour) },
        { elementId: 'divergences-day', data: @json($divergencesDay) }
    ];

    // Loop through each data set and generate charts
    seriesData.forEach(({ elementId, data }) => {
        // Extract periods and orders from each data object
        let period = data.map(item => item.period);
        let orders = data.map(item => item.orders);

        // Configure chart options
        const chartOptions = echartOptions.optionLine('', orders, period, true, '');

        // Initialize chart for each element
        startChart(elementId, chartOptions);
    });
</script>

</body>

</html>