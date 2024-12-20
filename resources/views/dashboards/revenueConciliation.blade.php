@include('components.head', ['pageName' => 'Conciliador E-commerce'])

<header class="header m-shadow">
</header>

<body id="content-area">

    <div class="row center mb-3">
        <div class="col">
            @include('components.datepicker', ['route' => route('crmDispatches.filter')])
        </div>
    </div>

    <script>
        console.log(@json($responseConciliation));
    </script>

</body>

</html>