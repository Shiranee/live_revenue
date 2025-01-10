import * as echartOptions from './echartOptions.js';

let charts = ['chart-revenue-today', 'chart-divergences', 'goal-gauge'];

window.startChart = function(chartId, option) {
  let chartElement = document.getElementById(chartId);
  if (chartElement) {
      let chart = echarts.init(chartElement);
      chart.setOption(option);
  }
};

let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})

function checkNumber() {
  // Select all spans with the function attribute set to "checkNumber"
  document.querySelectorAll('span[function="checkNumber"]').forEach(span => {
      // Get the text content of the span
      let text = span.textContent.trim();

      // Extract the percentage number from the text (e.g., "-5%")
      let percentage = parseFloat(text.replace('%', ''));

      // Check if the number is negative
      if (percentage < 0) {
          // Add the class "pending" to the span
          span.classList.add('pending');
      }
  });
}

// Run the function when the page loads
document.addEventListener("DOMContentLoaded", checkNumber);

// Function to initialize and resize all charts
function resizeCharts() {
  // Select all chart containers (divs with the 'dashboard-fit' class)
  const chartContainers = document.querySelectorAll('.my-chart');

  // Loop through each container and resize the chart
  chartContainers.forEach(function(container) {
      const chart = echarts.getInstanceByDom(container); // Get the instance of the chart
      if (chart) {
          chart.resize(); // Resize the chart
      }
  });
}

// Trigger resize on window resize event
window.addEventListener('resize', resizeCharts);

// Optionally, call resizeCharts initially in case charts are not loaded correctly initially
resizeCharts();

const gaugeData = [
  {
    value: 20,
    name: 'Meta',
    title: {
      offsetCenter: ['0%', '-30%']
    },
    detail: {
      valueAnimation: true,
      offsetCenter: ['0%', '-20%']
    }
  },
  {
    value: 40,
    name: 'Super Meta',
    title: {
      offsetCenter: ['0%', '0%']
    },
    detail: {
      valueAnimation: true,
      offsetCenter: ['0%', '10%']
    }
  },
  {
    value: 60,
    name: 'Diretoria',
    title: {
      offsetCenter: ['0%', '30%']
    },
    detail: {
      valueAnimation: true,
      offsetCenter: ['0%', '40%']
    }
  }
];

document.addEventListener('DOMContentLoaded', () => {
  const queryForm = document.querySelector('#form-query');
  const queryText = document.querySelector('#list-query');
  const fileForm = document.querySelector('#form-file');
  const fileInput = document.querySelector('#formFileLg');
  const importForm = document.querySelector('#import-container');
  const importMenuButton = document.querySelector('#importMenuButton');
  const checkboxes = document.querySelectorAll('.item-checkbox[data-id="import"]');

  if (!queryForm || !fileForm || !importForm || !importMenuButton) {
    console.error('Required elements are missing from the DOM.');
    return;
  }

  // Function to reset the visibility of forms
  function resetForms() {
    queryForm.classList.add('hidden');
    fileForm.classList.add('hidden');
    importForm.classList.add('hidden');
  }

  // Function to handle the visibility of forms based on checkbox selection
  function handleCheckboxChange(event) {
    // Uncheck all other checkboxes in the group
    checkboxes.forEach((checkbox) => {
      if (checkbox !== event.target) {
        checkbox.checked = false;
      }
    });

    let selectedValue = null;

    // Find the first checked checkbox
    checkboxes.forEach((checkbox) => {
      if (checkbox.checked) {
        selectedValue = checkbox.value;
      }
    });

    console.log('Selected Value:', selectedValue);

    resetForms(); // Hide all forms initially

    if (selectedValue) {
      importForm.classList.remove('hidden'); // Always show the container

      if (selectedValue === 'Query') {
        queryForm.classList.remove('hidden'); // Show Query form
        fileInput.value = ''; // Clear file input
      } else if (selectedValue === 'Csv') {
        fileForm.classList.remove('hidden'); // Show CSV form
        queryText.value = ''; // Clear query text
      }
    }

    // Update the dropdown button text
    importMenuButton.textContent = selectedValue || 'Metodo de Importação';
  }

  // Attach change event listener to all checkboxes
  checkboxes.forEach((checkbox) => {
    checkbox.addEventListener('change', handleCheckboxChange);
  });
});
