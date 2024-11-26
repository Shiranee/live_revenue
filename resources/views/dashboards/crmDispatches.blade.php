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
    @for($i = 0; $i < count($totalDispatches); $i++)
        @include('components.cardDispatches', ['dispatchesData' => $totalDispatches[$i], 'campaignsData' => $totalCampaigns[$i]])
    @endfor
</div>

</body>
</html>
