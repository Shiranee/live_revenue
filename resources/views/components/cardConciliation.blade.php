@php
    use Illuminate\Support\Str;
@endphp

<div class="col-12 col-md-6 col-lg-4">
    <div class="card mb-3 m-shadow">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mx-2">
                <div>
                    <h3 class="card-title fw-bold mb-1 fs-t1">
                        {{ $data['name'] }}
                    </h3>
                    <h6 class="text-body-tertiary fs-c"> {{ $data['name'] }} no Período </h6>
                </div>
                <h1 class="card-title fw-bold fs-t1">
                    {{ $data['revenue'] }}
                </h1>
            </div>

            <div class="revenue-dashboard my-chart dashboard-fit" 
                 id="chart-campaigns-{{ Str::slug($data['operations']['name']) }}" 
                 style="height: 50vh; width: 100%;">
            </div>

            <div class="container text-center fs-c1 table-responsive mt-1">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>Clientes</th>
                            <th>Pedidos</th>
                            <th>Peças</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> {{ $data['customers'] }} </td>
                            <td> {{ $data['orders'] }} </td>
                            <td> {{ $data['amount'] }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script type="module">
    import * as echartOptions from "{{ asset('echartOptions.js') }}";

    // Assuming $data is passed correctly as a JSON object
    let data = @json($data);

    // Combine `operation` and `orders` into a single array
    let campaignsData = data.operations.operation.map((operation, index) => ({
        value: data.operations.orders[index],
        name: operation
    }));

    // Use the processed data for your chart
    const campaignsChart = echartOptions.optionDonut('', campaignsData);
    startChart('chart-campaigns-{{ Str::slug($data['operations']['name']) }}', campaignsChart);
</script>