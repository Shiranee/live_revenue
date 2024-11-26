<div class="col card m-shadow h-100 d-flex flex-column justify-content-between p-3">

    <div class="d-flex justify-content-between align-items-center mx-4">

        <div>
            <h3 class="d-flex justify-content-between align-items-center card-title fw-bold mb-1 fs-t1">
                Disparos {{ $dispatchesData['source'] }}
            </h3>
            <h6 class="text-body-tertiary fs-c"> Disparos Confirmados no Período </h6>
        </div>
        <h1 class="card-title fw-bold">
            {{ $dispatchesData['total_confirmed'] }}
        </h1>

    </div>

    <div class="revenue-dashboard my-chart" id='chart-campaigns-{{ $dispatchesData['source'] }}' style="height: 40vh;"></div>

    <div class="container text-center mt-3 fs-5">
        <div class="row">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>Disparos</th>
                        <th>Confirmados</th>
                        <th>Pendentes</th>
                        <th>Inativados</th>
                        <th>Falhos</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> {{ $dispatchesData['total'] }} </td>
                        <td> {{ $dispatchesData['total_confirmed'] }} </td>
                        <td> {{ $dispatchesData['total_pending'] }} </td>
                        <td> {{ $dispatchesData['total_inactive'] }} </td>
                        <td> {{ $dispatchesData['total_failed'] }} </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="module">
  import * as echartOptions from "{{ asset('echartOptions.js') }}";

  // Pass the data from Blade to JavaScript
  let dispatchData = @json($dispatchesData);
  let campaigns = @json($campaignsData);

  // Assuming dispatchData has a `dispatches_confirmed` field and campaigns is an array
  let campaignsData = dispatchData.map((dispatch) => ({
    value: dispatch['total_confirmed'],  // Adjusted field
    name: campaigns.find(campaign => campaign.template_key === dispatch.template_key)?.template_key || 'Unknown'  // Adjust based on your structure
  }));

  // Generate the chart options
  const campaignsChart = echartOptions.optionDonut('', campaignsData);
  startChart('chart-campaigns-{{ $dispatchesData['source'] }}', campaignsChart);
</script>

<script type="module">
  import * as echartOptions from "{{ asset('echartOptions.js') }}";

  let dispatchData = @json($dispatchesData).map(dispatchesData => dispatchesData.dispatches_confirmed);
  let campaigns = @json($campaignsData);

  let campaignsData = dispatchData.map((value, index) => ({
    value: value,
    name: campaigns[index]
  }));

  const campaignsChart = echartOptions.optionDonut('', campaignsData);
  startChart('chart-campaigns-{{ $dispatchesData['source'] }}', campaignsChart);
</script>

<script>
  console.log(@json($dispatchesData), @json($campaignsData))
</script>