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


    <div id="dispatches-container" class="row center mb-3">
        @foreach($conciliationOverview as $data)
            @include('components.cardConciliation', $data)
        @endforeach
    </div>

    <div class="center p-2">

        @include('components.cardLineGraph', ['title' => 'Captado x Faturado', 'subtitle' => 'Receita Dia a Dia', 'id' => 'day-revenue', 'classes' => [false, 'conciliation-dashboard']])

				@include('components.cardLineGraph', ['title' => 'Divergências no Período', 'subtitle' => 'Pedidos que tiveram divergência', 'id' => 'day-divergences', 'classes' => [false, 'conciliation-dashboard']])

    </div>

		<div class="row center mb-5">
				<div class="col">
						<div class="card p-3 m-shadow">
								<div id="preview-results">
											@include('components.tableAPI')
								</div>
						</div>
				</div>
		</div>

</body>

<script type="module">
	import * as echartOptions from "{{ asset('echartOptions.js') }}";

	// Assuming $conciliationOverview is passed correctly as a JSON object
	let data = @json($conciliationOverview);
	let tableData = @json($conciliationTable);

	console.log(tableData)

	// Prepare the data for the chart
	const periods = data.map(item => item.period.date); // Extract periods for x-axis
	const seriesData = data.map(item => item.period.value); // Extract revenue for y-axis
	const seriesNames = data.map(item => item.name); // Extract revenue for y-axis

	// Prepare multi-series data for the chart
	const doubleData = data.map(item => item.period.value); // Multiple series (if applicable)

	// Configure chart options
	const chartOptions = echartOptions.optionLine('', [doubleData[0], doubleData[1]], periods[0], [seriesNames[0], seriesNames[1]], true, 'R$');
	
	// Initialize chart for the fixed element ID 'day-revenue'
	startChart('day-revenue', chartOptions);

	console.log([doubleData[0], doubleData[1]], periods[0], [seriesNames[0], seriesNames[1]])

	const groupedByDivergence = {};
	const datesSet = new Set();

	// Group data
	data[2].period.date.forEach((date, index) => {
			const divergenceType = data[2].period.divergence_type[index];
			const value = data[2].period.value[index];

			if (!groupedByDivergence[divergenceType]) {
					groupedByDivergence[divergenceType] = [];
			}

			// Add value to the appropriate divergence type, indexed by date
			groupedByDivergence[divergenceType].push({ date, value });
			datesSet.add(date);
	});

	// Extract final arrays
	const dates = Array.from(datesSet).sort(); // Distinct and sorted dates
	const names = Object.keys(groupedByDivergence); // Divergence types
	const values = names.map(name =>
			dates.map(date => {
					const entry = groupedByDivergence[name].find(d => d.date === date);
					return entry ? entry.value : 0; // Fill missing dates with 0
			})
	);

	const divergencesOptions = echartOptions.optionLine('', values, dates, names, true, '');
	startChart('day-divergences', divergencesOptions);
	// callTableData()
</script>

</html>