<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>LIVE! Receita E-commerce</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2/dist/umd/popper.min.js"></script>
	<link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/echarts@5.5.0/dist/echarts.min.js"></script>
	<link href="styles.css" rel="stylesheet">
  <script src="script.js" type="module" defer></script>
  <script src="echartOptions.js" type="module" defer></script>
</head>

<body>
  <header class="header m-shadow">
  </header>

  <div class="row center">
  @include('components.cardRevenue', [
            'titleFirst' => $titleFirst,
            'tooltip' => $tooltip,
            'comparison' => $comparison,
            'titleSecond' => $titleSecond,
            'revenue' => $revenue,
            'graphId' => $graphId,
            'customers' => $customers,
            'orders' => $orders,
            'amount' => $amount,
            'subtitleMain' => $subtitleMain,
            'subtitleFirst' => $subtitleFirst,
            'subtitleSecond' => $subtitleSecond,
            'valueFirst' => $valueFirst,
            'valueSecond' => $valueSecond
        ])


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