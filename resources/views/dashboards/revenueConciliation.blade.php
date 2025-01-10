@php
    $contents = [
        'titles' => ['Hoje', 'Acumulada', 'Faturada'],
        'subTitles' => ['Captado', 'Líquido', 'Líquido'],
    ];
@endphp

@include('components.head', ['pageName' => 'Conciliador E-commerce'])

<header class="header m-shadow">
</header>

<body id="content-area">

    <div class="row center mb-3">
        <div class="col">
            @include('components.datepicker', ['route' => route('crmDispatches.filter')])
        </div>
    </div>

    <div id="dispatches-container" class="row center mb-3">
        @foreach($conciliationData as $data)
            @include('components.cardConciliation', $data)
        @endforeach
    </div>

    <div class="center p-2">

        @include('components.cardLineGraph', ['title' => 'Captado x Faturado', 'subtitle' => 'Receita Dia a Dia', 'id' => 'captado-dia'])

    </div>

</body>

<script type="module">
    import * as echartOptions from "{{ asset('echartOptions.js') }}";

    // Assuming $conciliationData is passed correctly as a JSON object
    let data = @json($conciliationData);

    // Map data to extract periods and orders
    const seriesData = data.map(item => {
        const period = item.period.date; // Dates from period
        const value = item.period.value; // Revenue from period

        return {
            period,
            value
        };
    });

    const chartOptions = echartOptions.optionLine('', seriesData[0].value, seriesData[0].period, true, 'R$');

    // Initialize chart for the fixed element ID 'divergences-hour'
    startChart('captado-dia', chartOptions);

    console.log(seriesData[0].value, seriesData[0].period);

    // // Generate charts for each data object
    // seriesData.forEach(({ period, orders }) => {
    //     // Configure chart options
    //     const chartOptions = echartOptions.optionLine('Period vs Revenue', orders, period, true, '');

    //     // Initialize chart for the fixed element ID 'divergences-hour'
    //     startChart('divergences-hour', chartOptions);
    // });

</script>

</html>