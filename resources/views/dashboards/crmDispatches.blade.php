@include('components.head', ['pageName' => 'Disparos Twillio'])

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
        @foreach($totalDispatches as $dispatchesData)
            @include('components.cardDispatches', $dispatchesData)
        @endforeach
    </div>

    <script>
        console.log(@json($totalDispatches));
    </script>

</body>

</html>