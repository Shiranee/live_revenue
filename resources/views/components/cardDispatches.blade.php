<div class="col-12 col-md-6 col-lg-4">
    <div class="card mb-3 m-shadow">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mx-2">
                <div>
                    <h3 class="card-title fw-bold mb-1 fs-t1">
                        Disparos {{ $dispatchesData['source'] }}
                    </h3>
                    <h6 class="text-body-tertiary fs-c"> Disparos Confirmados no Período </h6>
                </div>
                <h1 class="card-title fw-bold fs-t1">
                    {{ $dispatchesData['total_confirmed'] }}
                </h1>
            </div>

            <div class="revenue-dashboard my-chart dashboard-fit" 
                 id="chart-campaigns-{{ $dispatchesData['source'] }}" 
                 style="height: 50vh; width: 100%;"></div>

            <div class="container text-center fs-c1 table-responsive mt-1">
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

    <div class="card mb-3 m-shadow h-20">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mx-2">
                <div>
                    <h6 class="card-title fw-bold mb-1 fs-t2">
                        Disparos Por Modalidade {{ $dispatchesData['source'] }}
                    </h6>
                </div>
            </div>

            <div class="container text-center fs-c2 table-responsive mt-1" style="overflow-x: auto;">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>Modalidade</th>
                            <th>Confirmados</th>
                            <th>Pendentes</th>
                            <th>Inativados</th>
                            <th>Falhos</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($dispatchesData['dispatch_modality'] as $item)
                            <tr>
                                <td> {{ $item['dispatch_modality'] }} </td>
                                <td> {{ $item['total_confirmed'] }} </td>
                                <td> {{ $item['total_pending'] }} </td>
                                <td> {{ $item['total_inactive'] }} </td>
                                <td> {{ $item['total_failed'] }} </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

<script type="module">
    import * as echartOptions from "{{ asset('echartOptions.js') }}";

    // Assuming $dispatchesData is passed correctly as a JSON object
    let dispatchesData = @json($dispatchesData);

    // Extract `template_key` as `name` and `total_confirmed` as `value` from `total_campaigns`
    let campaignsData = dispatchesData.total_campaigns.map(campaign => ({
        value: campaign.total_confirmed,
        name: campaign.template_key
    }));

    // Use the processed data for your chart
    const campaignsChart = echartOptions.optionDonut('', campaignsData);
    startChart('chart-campaigns-{{ $dispatchesData['source'] }}', campaignsChart);
</script>