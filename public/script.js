import * as echartOptions from './echartOptions.js';

let charts = ['chart-revenue-today', 'chart-divergences'];

function startChart(chartId, option) {
  let chartElement = document.getElementById(chartId);
  if (chartElement) { // Only initialize if element exists
      let chart = echarts.init(chartElement);
      chart.setOption(option);
  }
}

startChart(charts[0], echartOptions.optionLine);
startChart(charts[1], echartOptions.optionDonut);

let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})

// async function fetchData(url) {
//   try {
//     const response = await fetch(url);
//     if (!response.ok) {
//       throw new Error(`HTTP error! Status: ${response.status}`);
//     }
//     const result = await response.json();
//     console.log('Fetched Data:', result);
//     return result;
//   } catch (error) {
//     console.error('Error fetching data:', error);
//   }
// }

// (async () => {
//   const data = await fetchData("http://192.168.100.95:8000/api/revenue/2024-09-01/2024-09-30/summary");
//   console.log(data);
// })();