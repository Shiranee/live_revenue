import * as echartOptions from './echartOptions.js';

let charts = ['chart-revenue-today', ];

function startChart(chartId, option) {
  let chart = echarts.init(document.getElementById(chartId));
  chart.setOption(option);
}

startChart(charts[0], echartOptions.optionLine);

async function fetchData(url) {
  try {
    const response = await fetch(url);
    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }
    const result = await response.json();
    console.log('Fetched Data:', result);
    return result;
  } catch (error) {
    console.error('Error fetching data:', error);
  }
}

(async () => {
  const data = await fetchData("http://192.168.100.95:8000/api/revenue/2024-09-01/2024-09-30/summary");
  console.log(data);
})();

let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})