@include('components.head', ['pageName' => 'LIVE! Receita E-commerce'])

<body>
  <header class="header m-shadow">
  </header>

  <div class="row center">
    @foreach($cards as $cardData)
        @include('components.cardRevenue', $cardData)
    @endforeach
  </div>

  
  <div class="row center">
    @foreach($cardsDevolution as $cardData)
        @include('components.cardDevolution', $cardData)
    @endforeach
  </div>

</body>

</html>