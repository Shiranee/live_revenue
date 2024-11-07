<!-- resources/views/components/cardGauges.blade.php -->
<div class="col">
    <div class="card mb-3 m-shadow">
        <div class="card-body">

          <div class="d-flex justify-content-between align-items-center mx-1">
            <h3 class="card-title fw-bold fs-t1"> Meta </h3>
          </div>
          <div class="revenue-dashboard gauges-height" id='{{ $graphId }}'></div>
        </div>
    </div>
    <script type="module">
    import * as echartOptions from "{{ asset('echartOptions.js') }}";

    let donData

    // const donChartOptions = echartOptions.optionDonut('', donData);
    // startChart('chart-divergences', donChartOptions);

    </script>
</div>