  <!-- Dropdown with search and multiple selection -->
  <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
      Select Item(s)
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <!-- Search input -->
      <input type="text" id="searchInput" class="form-control" placeholder="Search...">
      <ul id="dropdownItems" class="list-unstyled mt-2">
        @foreach ($dropdownContent as $item)
          <li>
            <label class="dropdown-item">
              <input type="checkbox" class="item-checkbox" value="{{ $item }}"> {{ $item }}
            </label>
          </li>
        @endforeach
      </ul>
    </div>
  </div>

<script>
  // Array to store selected items
  let selectedItems = [];

  // Search filter function
  $('#searchInput').on('keyup', function() {
    let value = $(this).val().toLowerCase();
    $('#dropdownItems li').filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
  });

  // Handle checkbox selection
  $('.item-checkbox').on('change', function() {
    const value = $(this).val();

    if ($(this).is(':checked')) {
      selectedItems.push(value);
    } else {
      selectedItems = selectedItems.filter(item => item !== value);
    }

    // Update button text with selected items or placeholder
    if (selectedItems.length > 0) {
      $('#dropdownMenuButton').text(selectedItems.join(', '));
    } else {
      $('#dropdownMenuButton').text('Select Item(s)');
    }
  });
</script>
