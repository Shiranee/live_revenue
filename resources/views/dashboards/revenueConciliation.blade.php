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
    
    </div>

</body>

    <script>
        console.log(@json($conciliationData));
    </script>

</html>