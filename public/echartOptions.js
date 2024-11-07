export function optionLine(title, seriesData, xAxisData, showLegends, formatter) {
  let optionLabels = {
    type: 'line',
    lineStyle: {
      width: 3.5
    },
    symbolSize: 3.5,
    symbol: 'circle',
    label: {
      show: showLegends,
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
        return `${formatter} ${params.value.toFixed(0)}`; // Display currency with no decimals
      }
    }
  };

  let option = {
    title: {
      text: title,
      left: 4,
      textStyle: {
        fontWeight: 'bold',
        fontSize: 15,
        color: 'black'
      }
    },
    tooltip: {
      trigger: 'axis',
      formatter: function (params) {
        let tooltipContent = `${params[0].axisValue}<br/>`;
        params.forEach(item => {
          tooltipContent += `${formatter} ${item.value.toFixed(0)}<br/>`;
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
      data: xAxisData,
      show: showLegends,
      axisLine: {
        lineStyle: {
          width: 1.5,
          color: 'grey',
          type: 'line'
        }
      },
      axisTick: {
        show: false
      }
    },
    yAxis: {
      type: 'value',
      axisLabel: {
        show: false
      },
      splitLine: {
        show: false
      }
    },
    series: [
      {
        name: 'Your Series Name',
        data: seriesData,
        ...optionLabels
      }
    ]
  };

  return option;
}

export function optionHalfGauge(title, seriesData) {
  return {
    title: {
      text: `${title}`,
      left: 4,
      textStyle: {
        fontWeight: 'bold',
        fontSize: 15,
        color: 'black'
      }
    },
    series: [
      {
        type: 'gauge',
        startAngle: 225,
        endAngle: -45,
        min: 0,
        max: 100,
        radius: '80%',
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
        title: {
          left: 'center',
          textStyle: {
            fontWeight: 'bold',
            fontSize: 20,
            color: 'black'
          }
        },
        detail: {
          valueAnimation: true,
          width: 50,
          height: 14,
          fontSize: 14,
          color: 'black',
          borderColor: '#ccc',
          borderRadius: 20,
          borderWidth: 1,
          formatter: '{value}%',
          offsetCenter: ['0%', '40%']
        },
        data: seriesData
      }
    ]
  };
};

export function optionBarGauge(title, seriesData) {
  return {
    title: {
      text: `${title}`,
      left: 4,
      textStyle: {
        fontWeight: 'bold',
        fontSize: 15,
        color: 'black'
      }
    },
    height: 80,
    grid: {
      left: '2%',
      right: '2%',
      top: '20%', // Adjust this value to add space at the top
      // bottom: '20%', // Adjust this value to add space at the bottom
      containLabel: true // Ensures the bars are properly centered
    },
    xAxis: {
      type: 'value',
      max: 100, // Set the maximum value to 100%
      axisLabel: {
        show: false // Hides the axis labels
      },
      splitLine: {
        show: false // Hides the grid lines
      }
    },
    yAxis: {
      type: 'category',
      data: [''], // Adding an empty string for category to help center the bar
      axisLabel: {
        show: false // Hides the axis labels
      },
      lineStyle: {
        width: 0 // Hides the y-axis line
      },
      axisLine: {
        show: false
      },
      axisTick: {
        show: false
      }
    },
    series: [
      {
        name: 'Usage', // Optional: Name of the series
        data: [seriesData], // Value to display
        type: 'bar',
        itemStyle: {
          color: 'rgb(211, 224, 199)',
          borderRadius: 40
        },
        showBackground: true,
        backgroundStyle: {
          color: 'rgba(180, 180, 180, 0.2)', // Background color for the bar
          borderRadius: 40
        },
        label: {
            show: true,
            position: 'inside', // Change to 'inside' to center the label in the bar
            formatter: 'Faturado: {c}%', // Show the percentage value next to the bar
            backgroundColor: 'white', // Background color for the label
            borderColor: 'grey', // Border color for the label
            borderWidth: 1, // Border width for the label
            borderRadius: 10, // Rounded corners for the label
            padding: 7, // Padding around the label
            textStyle: {
                fontWeight: 'bold',
                fontSize: 15,
                color: 'black'
            }
        }
      }
    ]
  };
};

export function optionFullGauge(title, seriesData) {
  return {
      title: {
        text: `${title}`,
        left: 'center',
        textStyle: {
          fontWeight: 'bold',
          fontSize: 15,
          color: 'black'
        }
      },
      series: [
        {
          type: 'gauge',
          startAngle: 90,
          endAngle: -270,
          pointer: {
            show: false
          },
          progress: {
            show: true,
            overlap: false,
            roundCap: true,
            clip: false,
            itemStyle: {
              borderWidth: 1,
              borderColor: '#ccc'
            }
          },
          axisLine: {
            lineStyle: {
              width: 40
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
          data: seriesData,
          title: {
            show:false
          },
          detail: {
            width: 55,
            height: 14,
            fontSize: 14,
            fontWeight: 'bold',
            color: 'white',
            backgroundColor: 'inherit',
            borderColor: 'inherit',
            borderRadius: 20,
            borderWidth: 1,
            formatter: '{value}%',
          }
        }
      ]
    };
};

export function optionDonut(title, data) {
  return {
    tooltip: {
      trigger: 'item'
    },
    title: {
      text: title,
      left: 4,
      textStyle: {
        fontWeight: 'bold',
        fontSize: 15,
        color: 'black'
      }
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
        data: data
      }
    ]
  };
};