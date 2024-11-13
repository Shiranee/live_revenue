@php
    $dropdownContent = ['Apple', 'Banana', 'Cherry', 'Grapes', 'Lemon', 'Mango', 'Orange', 'Pineapple', 'Strawberry'];
@endphp

@include('components.head', ['pageName' => 'LIVE! Receita E-commerce'])

<body>
  <header class="header m-shadow">
  </header>

  @include('components.datePicker')
  @include('components.dropdownFilter', ['dropdownContent' => $dropdownContent])

</body>
</html>