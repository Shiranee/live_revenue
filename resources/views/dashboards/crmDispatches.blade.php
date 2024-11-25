@include('components.head', ['pageName' => 'LIVE! Disparos Twillio'])

<header class="header m-shadow">
</header>

<body id="content-area">

  <div class="row center mb-3 h-5">
      <div class="col d-flex container-fluid justify-content-start align-items-center">
          @include('components.datepicker', ['route' => route('crmDispatches.filter')])
          @include('components.dropdownFilter', ['dropdownContent' => $campaigns])
      </div>
  </div>

  <div class="row center">
    <div class="card m-shadow h-100 d-flex flex-column justify-content-between p-3">
      
      <div class="d-flex justify-content-between align-items-center mx-4">

        <div>
          <h3 class="d-flex justify-content-between align-items-center card-title fw-bold mb-1">
            Disparos                
          </h3>
        </div>
        <h1 class="card-title fw-bold"> 
          {{ $totalDispatches}}
        </h1>

      </div>
      
      <div class="revenue-dashboard my-chart" id='chart-templates' style="height: 50vh;"></div>
    </div>
  </div>

  <!-- @foreach ($dispatches as $dispatch)
      <tr>
          <td>{{ $dispatch['dispatches_confimed'] }}</td>
      </tr>
  @endforeach -->

</body>
</html>
