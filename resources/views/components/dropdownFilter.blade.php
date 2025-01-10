<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="{{ $id }}MenuButton" data-bs-toggle="dropdown" aria-expanded="false">
    {{ $title }}
  </button>
  <div class="dropdown-menu w-33" aria-labelledby="{{ $id }}MenuButton" style="max-height: 300px; overflow-y: auto;">
    <!-- Search input -->
    <input type="text" id="{{ $id }}SearchInput" class="form-control" placeholder="Search...">
    <ul id="{{ $id }}DropdownItems" class="list-unstyled mt-2">
      @foreach ($dropdownContent as $item)
        <li>
          <label class="dropdown-item">
            <input type="checkbox" class="item-checkbox" data-id="{{ $id }}" value="{{ $item }}"> {{ $item }}
          </label>
        </li>
      @endforeach
    </ul>
  </div>
</div>

<script>
  $(document).ready(function() {
    // Search filter function
    $('#{{ $id }}SearchInput').on('keyup', function() {
      let value = $(this).val().toLowerCase();
      $('#{{ $id }}DropdownItems li').filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
      });
    });

    // Handle checkbox selection
    let selectedItems{{ $id }} = [];
    $(document).on('change', '.item-checkbox[data-id="{{ $id }}"]', function() {
      const value = $(this).val();

      if ($(this).is(':checked')) {
        selectedItems{{ $id }}.push(value);
      } else {
        selectedItems{{ $id }} = selectedItems{{ $id }}.filter(item => item !== value);
      }

      // Update button text with selected items or placeholder
      if (selectedItems{{ $id }}.length > 0) {
        $('#{{ $id }}MenuButton').text(selectedItems{{ $id }}.join(', '));
      } else {
        $('#{{ $id }}MenuButton').text('{{ $title }}');
      }
    });
  });
</script>
