<div class="container mt-5">
  <!-- Dropdown with search -->
  <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
      Select Item
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <!-- Search input -->
      <input type="text" id="searchInput" class="form-control" placeholder="Search...">
      <ul id="dropdownItems" class="list-unstyled mt-2">
        @foreach ($dropdownContent as $item)
            <li><a class="dropdown-item" href="#">{{ $item }}</a></li>
        @endforeach
      </ul>
    </div>
  </div>
</div>

<script>
  // Search filter function
  $('#searchInput').on('keyup', function() {
    let value = $(this).val().toLowerCase();
    $('#dropdownItems li').filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
  });
</script>
