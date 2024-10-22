// Initialize the chart instance
let chartDivergences = echarts.init(document.getElementById('divergences-chart'));
let invoiceMeter = echarts.init(document.getElementById('invoice-meter'));
let invoiceGauge = echarts.init(document.getElementById('invoice-gauge'));
let divergencesBar = echarts.init(document.getElementById('divergences-bar'));
let invoicesBar = echarts.init(document.getElementById('invoices-bar'));

let charts = ['divergences-chart', 'invoice-meter', 'invoice-gauge', 'divergences-bar', 'invoices-bar'];

let apiDivergences = 'http://localhost:5000/api/revenue/divergences';

// Function to start and set options for the chart
function startChart(chartInstance, option) {
  // let chart = echarts.init(document.getElementById(chart))
  chartInstance.setOption(option); // Set the option on the ECharts instance
}

async function fetchData(url) {
  try {
    const response = await fetch(url);
    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }
    const result = await response.json();
    let data = result; // Assign result to data
    console.log('Fetched Data:', data);
    return data;  // Return the fetched data if needed
  } catch (error) {
    console.error('Error fetching data:', error);
  }
}

// Function to set dynamic options
function setDynamicOptions(chartInstance, graphOption, fontSize = 3) {
  const chartWidth = chartInstance.getWidth();
  const chartHeight = chartInstance.getHeight();

  const baseFontSize = Math.min(chartWidth, chartHeight) * (fontSize / 100); // Responsive font size

  graphOption.series[0].label.fontSize = baseFontSize; // Update the font size dynamically
  graphOption.legend.textStyle.fontSize = baseFontSize; // Apply the font size to the legend

  chartInstance.setOption(graphOption); // Reapply the updated option
}

let divergencesDay = [
  {
    name: 'Positiva',
    type: 'bar',
    data: [-120.25, 100.30, 47.00, -148.78, -659.77, -184.74, -665.09, -544.14, -38.93, 369.38, -865.77, 93.08, 35.81, -131.85, 226.45, -822.76, -944.53, -394.44, 184.08, -1817.77, -674.20, -437.97, -286.98, 33.59, -145, -964.55, -684.14, -166.46, 145.25, 0],
    itemStyle: {
      color: 'green' // Set the color to green
    },
    label: {
      show: true, // Shows labels on top
      position: 'top',
      formatter: function (params) {
        return 'R$' + params.value.toFixed(0); // Format with currency sign and two decimal places
      }
    }
  }
]

// Set the option for the chart
// Set the base option for the chart
let optionDonut = {
  tooltip: {
    trigger: 'item'
  },
  legend: {
    bottom: '5%',
    left: 'center',
    textStyle: {
      fontSize: '2vw' // Default base font size
    }
  },
  series: [
    {
      type: 'pie',
      radius: ['40%', '60%'],
      center: ['50%', '45%'],
      avoidLabelOverlap: false,
      label: {
        show: true,
        position: 'outside',
        verticalAlign: 'middle',
        backgroundColor: 'rgba(241, 237, 241, 0.7)', // Add transparency
        borderColor: 'grey',
        // borderWidth: 1,
        borderRadius: 10,
        padding: 5,
        formatter: '{b}: {c}',
        fontSize: '2vw', // Responsive font size
        color: 'black',
        fontWeight: 'bold'
      },
      itemStyle: {
        borderRadius: 4,
        borderColor: '#fff',
        borderWidth: 1
      },
      labelLine: {
        show: true
      },
      data: [] // Placeholder for fetched data
    }
  ]
};

let optionMeter = {
  tooltip: {
    trigger: 'item'
  },
  legend: {
    top: '5%',
    left: 'center',
    textStyle: {
      fontSize: '2vw' // Adjust legend font size if needed
    }
  },
  series: [
    {
      type: 'pie',
      radius: ['40%', '80%'],
      center: ['50%', '80%'],
      avoidLabelOverlap: false,
      startAngle: 180, // Start from the bottom
      endAngle: 360,   // End at the full circle
      label: {
        show: true,
        position: 'outside',
        verticalAlign: 'middle',
        backgroundColor: 'rgba(241, 237, 241, 0.7)',
        borderColor: 'grey',
        // borderWidth: 1,
        borderRadius: 10,
        padding: 5,
        formatter: '{b}: {c}',
        fontSize: '2vw', // Responsive font size, adjust as needed
        color: 'black',
        fontWeight: 'bold'
      },
      data: []
    }
  ]
};

let optionGauge = {
  series: [
    {
      type: 'gauge',
      startAngle: 225,
      endAngle: -45,
      min: 0,
      max: 100,
      radius: '100%',
      pointer: {
        show: false
      },
      progress: {
        show: true,
        overlap: false,
        roundCap: true,
        clip: false,
        itemStyle: {
          borderWidth: 0.5,
          borderColor: '#ccc'
        }
      },
      axisLine: {
        roundCap: true,
        lineStyle: {
          width: 20
        }
      },
      splitLine: {
        show: false,
        distance: 0,
        length: 10
      },
      axisTick: {
        show: false
      },
      axisLabel: {
        show: false,
        distance: 50
      },
      data: [],
      title: {
        fontSize: 14
      },
      detail: {
        width: 50,
        height: 14,
        fontSize: 14,
        color: 'black',
        borderColor: '#ccc',
        borderRadius: 20,
        borderWidth: 1,
        formatter: '{value}%'
      }
    }
  ]
};

let optionLines = {
  title: {
    text: 'Stacked Line'
  },
  tooltip: {
    trigger: 'axis',
    formatter: function (params) {
      let tooltipContent = '';
      params.forEach(item => {
        tooltipContent += `${item.seriesName}: R$${item.value.toFixed(0)}<br/>`; // Format with currency sign and two decimal places
      });
      return tooltipContent;
    }
  },
  legend: {
    data: ['Email', 'Union Ads', 'Video Ads', 'Direct', 'Search Engine']
  },
  grid: {
    left: '1%',
    right: '2%',
    bottom: '2%',
    containLabel: true
  },
  toolbox: {
    feature: {
      saveAsImage: {}
    }
  },
  xAxis: {
    type: 'category',
    boundaryGap: ['10%', '10%'],
    data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
    axisLine: {
      lineStyle: {
        width:1.5,
        color: 'grey',
        type: "dashed"
      }
    },
   axisTick: {
      show: false          // Hide the ticks on the x-axis
    }
  },
  yAxis: {
    type: 'value',
    axisLabel: {
      show: false // Hides the left labels
    },
    splitLine: {
      show: false // Hides the grid lines
    }
  },
  series: [
    {
      name: 'Email',
      type: 'line',
      stack: 'Total',
      data: [120, 132, 101, 134, 90, 230, 210],
    },
    {
      name: 'Union Ads',
      type: 'line',
      stack: 'Total',
      data: [220, 182, 191, 234, 290, 330, 310]
    },
    {
      name: 'Video Ads',
      type: 'line',
      stack: 'Total',
      data: [150, 232, 201, 154, 190, 330, 410]
    },
    {
      name: 'Direct',
      type: 'line',
      stack: 'Total',
      data: [320, 332, 301, 334, 390, 330, 320]
    },
    {
      name: 'Search Engine',
      type: 'line',
      stack: 'Total',
      data: [820, 932, 901, 934, 1290, 1330, -1320]
    }
  ]
};

optionLines.series.forEach(function(series) {
  series.lineStyle = {
    width: 3.5
  };
  series.symbolSize = 3.5;
  series.symbol = "circle";

  series.label = {
    show: true,
    position: 'outside',
    verticalAlign: 'middle',
    color: 'black',
    fontSize: 12,
    fontWeight: 'bold',
    backgroundColor: 'rgba(241, 237, 241, 0.7)',  // Transparent background for the label
    borderColor: 'grey',
    borderRadius: 10,
    padding: 5,
    formatter: function (params) {
      return `R$ ${params.value.toFixed(0)}`; // Display currency with no decimals
    }
  };
});

startChart(invoicesBar, optionLines);

setDynamicOptions(chartDivergences, optionDonut);
setDynamicOptions(invoiceMeter, optionMeter, 4.5);

async function initDivergencesChart() {
  const data = await fetchData(apiDivergences);
  if (data) {
    const formattedData = data.map(item => ({
      name: item.name,
      value: item.value,
      itemStyle: {
        color: item.color // Assuming item.color is defined
      }
    })).sort((a, b) => b.value - a.value); 
    
    chartDivergences.setOption({
      series: [
        {
          data: formattedData
        }
      ]
    });
  }
}

initDivergencesChart();

async function initInvoiceMeter() {
  const data = await fetchData(apiDivergences);
  if (data) {
    // Step 1: Map and format the data
    const formattedData = data.map(item => ({
      name: item.name === 'Sem Nota' ? 'Não Faturado' : 'Faturado',
      value: item.name === 'Sem Nota' ? item.value : item.value,
      itemStyle: {
        color: item.name === 'Sem Nota' ? '#e06666' : '#f6b26b',
      }
    }));

    // Step 2: Aggregate values by name
    const aggregatedData = formattedData.reduce((acc, curr) => {
      // Check if the name already exists in the accumulator
      const existing = acc.find(item => item.name === curr.name);
      if (existing) {
        // If it exists, sum the values
        existing.value += curr.value;
      } else {
        // If it doesn't exist, add it to the accumulator
        acc.push({ ...curr });
      }
      return acc;
    }, []);

    console.log(aggregatedData, aggregatedData[0].value / (aggregatedData[0].value + aggregatedData[1].value) * 100); // Log aggregated data for debugging

    let share = ((aggregatedData[0].value / (aggregatedData[0].value + aggregatedData[1].value) * 100).toFixed(0))

    // Step 3: Set the options for the invoice meter chart
    invoiceMeter.setOption({
      series: [
        {
          data: aggregatedData
        }
      ]
    });
    
    invoiceGauge.setOption({
      series: [
        {
        max: share <= 100 ? 100 : share,
        color: '#f6b26b',
        data: [{
          value: share,
          name: '(%) Faturada',
          title: {
            offsetCenter: ['0%', '20%']
          },
          detail: {
            valueAnimation: true,
            offsetCenter: ['0%', '40%']
          }
        }]
        }
      ]
    });
  }
}

initInvoiceMeter();

startChart(invoiceGauge, optionGauge);

window.addEventListener('resize', () => {
  chartDivergences.resize(); // Resize the chart on window resize
  invoiceMeter.resize();
  invoiceGauge.resize();
});



// function optionBar(xAxisData, seriesData) {
//   let option = {
//     tooltip: {
//       trigger: 'axis',
//       axisPointer: {
//         type: 'shadow'
//       },
//       formatter: function (params) {
//         let tooltipContent = '';
//         params.forEach(item => {
//           tooltipContent += `${item.seriesName}: R$${item.value.toFixed(0)}<br/>`; // Format with currency sign and two decimal places
//         });
//         return tooltipContent;
//       }
//     },
    
//     legend: {},
//     grid: {
//       left: '2%',
//       right: '2%',
//       bottom: '3%',
//       containLabel: true // Ensures the bars are centered
//     },
//     xAxis: [
//       {
//         type: 'category',
//         data: xAxisData,
//       }
//     ],
//     yAxis: [
//       {
//         type: 'value',
//         axisLabel: {
//           show: false // Hides the left labels
//         },
//         splitLine: {
//           show: false // Hides the grid lines
//         }
//       }
//     ],
//     series: seriesData
//   };

//   option.series.forEach(function(series) {
//     series.lineStyle = {
//       width: 3.5
//     };
//     series.symbolSize = 3.5;
//     series.symbol = "circle";
  
//     series.label = {
//       show: true,
//       position: 'top',
//       verticalAlign: 'middle',
//       color: 'black',
//       fontSize: 10,
//       fontWeight: 'bold',
//       backgroundColor: 'rgba(241, 237, 241, 0.7)',  // Transparent background for the label
//       borderColor: 'grey',
//       borderRadius: 10,
//       padding: 5,
//       // Adding an offset to the position
//       offset: [0, -10], // Move the label upwards by 10 pixels
//       formatter: function (params) {
//         return `R$ ${params.value.toFixed(0)}`; // Display currency with no decimals
//       }
//     };
//   });
// return option;
// }

// let dates =  ['29/09/2024', '01/09/2024', '02/09/2024', '03/09/2024', '04/09/2024', '05/09/2024', '17/09/2024', '06/09/2024', '18/09/2024', '08/09/2024', '10/09/2024', '26/09/2024', '07/09/2024', '09/09/2024', '12/09/2024', '11/09/2024', '13/09/2024', '14/09/2024', '15/09/2024', '16/09/2024', '19/09/2024', '20/09/2024', '21/09/2024', '22/09/2024', '23/09/2024', '24/09/2024', '25/09/2024', '27/09/2024', '28/09/2024'];
// let invoicesDay =  [
//   {
//     name: 'Faturado',
//     type: 'bar',
//     data: [370268, 275667, 332376, 302131, 324329, 340052, 321161, 280224, 387196, 300853, 403915, 398611, 274491, 393864, 385003, 376831, 303893, 279668, 352836, 296548, 330085, 366623, 352807, 322562, 345849, 378579, 388244, 355801, 313457, 0],
//     itemStyle: {
//       color: 'green' // Set the color to green
//     },
//   },
//   {
//   name: 'Captado',
//   type: 'bar',
//   data: [370268, 275667, 332376, 302131, 324329, 340052, 321161, 280224, 387196, 300853, 403915, 398611, 274491, 393864, 385003, 376831, 303893, 279668, 352836, 296548, 330085, 366623, 352807, 322562, 345849, 378579, 388244, 355801, 313457, 0],
//   itemStyle: {
//     color: 'green' // Set the color to green
//   },
//   label: {
//     show: true,
//     position: 'bottom',
//     verticalAlign: 'middle',
//     color: 'black',
//     fontSize: 10,
//     fontWeight: 'bold',
//     backgroundColor: 'rgba(241, 237, 241, 0.7)',  // Transparent background for the label
//     borderColor: 'grey',
//     borderRadius: 10,
//     padding: 5,
// }
//   }
// ]

// // setDynamicOptions(divergencesBar, optionBar);
// // startChart(divergencesBar, optionBar(dates, divergencesDay));
// startChart(invoicesBar, optionBar(dates, invoicesDay));