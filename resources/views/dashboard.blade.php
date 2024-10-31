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

      <div class="col">
          <div class="card mb-2 m-shadow">
              <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mx-4">
                  
                  <div >
                    <h6 class="d-flex justify-content-between align-items-center card-title fw-bold mb-1">Devoluções Hoje
                      <span class="round-pill fs-custom">-6.8%</span>
                    </h6>
                  </div>
                  
                  <h3 class="card-title fw-bold">R$16.247</h3>

                </div>

              </div>
          </div>
      </div>


      <div class="col">
          <div class="card mb-3 m-shadow">
              <div class="card-body">

              </div>
          </div>
      </div>


      <div class="col">
          <div class="card mb-3 m-shadow">
              <div class="card-body">

              </div>
          </div>
      </div>

  </div>

</body>

</html>