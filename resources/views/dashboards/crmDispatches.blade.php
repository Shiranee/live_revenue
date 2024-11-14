@include('components.head', ['pageName' => 'LIVE! Receita E-commerce'])

<body>
  <header class="header m-shadow">
  </header>

  <div class="row center mb-3 h-5">
    <div class="col d-flex container-fluid justify-content-start align-items-center">
        @include('components.datePicker')
        @include('components.dropdownFilter', ['dropdownContent' => $campaigns])
    </div>
  </div>

  <!-- @foreach ($dispatches as $dispatch)
    <tr>
        <td>{{ $dispatch['template_key'] }}</td>
        <td>{{ $dispatch['dispatches'] }}</td>
        <td>{{ $dispatch['dispatches_confimed'] }}</td>
        <td>{{ $dispatch['dispatches_pending'] }}</td>
        <td>{{ $dispatch['dispatches_inactive'] }}</td>
        <td>{{ $dispatch['dispatches_failed'] }}</td>
    </tr>
@endforeach -->

</body>
</html>