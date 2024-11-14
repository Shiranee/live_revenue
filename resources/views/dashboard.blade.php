@include('components.head', ['pageName' => 'LIVE! Receita E-commerce'])

<body>
  <header class="header m-shadow">
  </header>
  <div class="center container-fluid mb-3 d-flex justify-content-start">
    <div class="d-flex justify-content-start" style="width: 400px;">
      @include('components.datePicker')
    </div>
  </div>

  <div class="row center">
    @foreach($cardsRevenue as $cardData)
        @include('components.cardRevenue', $cardData)
    @endforeach
  </div>
  
  <div class="row center">
    @foreach($cardsDevolution as $cardData)
        @include('components.cardDevolution', $cardData)
    @endforeach
  </div>

  <div class="row center">
    @include('components.cardGauges', ['graphId' => 'goal-gauge'])
    @include('components.cardGauges', ['graphId' => 'goal-gauge1'])
    @include('components.cardGauges', ['graphId' => 'goal-gauge2'])
  </div>

</body>

</html>