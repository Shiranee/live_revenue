@include('components.head', ['pageName' => 'Disparos Twillio'])

<header class="header m-shadow">
</header>

<body id="content-area">

    <div class="row center mb-3">
        <div class="col">
            @include('components.datepicker', ['route' => route('crmDispatches.filter')])
        </div>
    </div>

    <div id="dispatches-container" class="row center mb-3">
        @foreach($totalDispatches as $dispatchesData)
            @include('components.cardDispatches', $dispatchesData)
        @endforeach
    </div>

    <script>
        console.log(@json($totalDispatches));
    </script>

</body>

</html>