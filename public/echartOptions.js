let optionLinesLabels = {
  type: 'line',
  lineStyle: {
    width: 3.5
  },
  symbolSize: 3.5,
  symbol: 'circle',
  label: {
    show: true,
    position: 'outside',
    verticalAlign: 'middle',
    color: 'black',
    fontSize: 12,
    fontWeight: 'bold',
    backgroundColor: 'rgba(241, 237, 241, 0.7)', // Transparent background for the label
    borderColor: 'grey',
    borderRadius: 10,
    padding: 5,
    formatter: function (params) {
      return `R$ ${params.value.toFixed(0)}`; // Display currency with no decimals
    }
  }
};

export const optionLine = {
  tooltip: {
    trigger: 'axis',
    formatter: function (params) {
      let tooltipContent = `${params[0].axisValue}<br/>`; // Display the x-axis date (or category value)
      params.forEach(item => {
        tooltipContent += `${item.marker} ${item.seriesName}: R$${item.value.toFixed(0)}<br/>`; // Format with currency sign and zero decimal places
      });
      return tooltipContent;
    }
  },
  legend: {
    data: []
  },
  grid: {
    left: '1%',
    right: '2%',
    bottom: '2%',
    containLabel: true
  },
  xAxis: {
    type: 'category',
    boundaryGap: ['10%', '10%'],
    data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
    show: false,
    axisLine: {
      lineStyle: {
        width: 1.5,
        color: 'grey',
        type: 'dashed'
      }
    },
    axisTick: {
      show: false
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
      name: 'Your Series Name',
      data: [150, 230, 224, 218, 135, 147, 260],
      ...optionLinesLabels // Spread the properties from optionLinesLabels here
    }
  ]
};
