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

// var $jq = jQuery.noConflict();
// $jq(document).ready(function() {
//     $jq('#table').bootstrapTable({
//         data: tableData,
//         autoResize: true,
//         exportOptions: {
//             fileName: 'table_data',
//             ignoreColumn: ['actions'],
//         },
//         formatNoMatches: function () {
//             return 'No data available';
//         }
//     });
// });

// Function to capture the selected values
function getSelectedValues() {
  // Get all checkboxes inside the dropdown
  const checkboxes = document.querySelectorAll('.item-checkbox:checked');
  // Create an array of selected values
  const selectedValues = Array.from(checkboxes).map(checkbox => checkbox.value);
  
  console.log(selectedValues);  // Log selected values to console
}

// Add event listeners to track changes on checkboxes
document.querySelectorAll('.item-checkbox').forEach(checkbox => {
  checkbox.addEventListener('change', getSelectedValues);
});


function modalAction(button, modal) {
  if (!button || !modal) return;  // Check if button and modal exist

  const openModal = function () {
    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');
  };

  const closeModal = function () {
    modal.classList.add('hidden');
    overlay.classList.add('hidden');
  };

  button.addEventListener('click', openModal);

  modal.querySelector('.close-modal').addEventListener('click', closeModal);
  overlay.addEventListener('click', closeModal);
  
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
      closeModal();
    }
  });
}
