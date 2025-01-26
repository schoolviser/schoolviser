/******/ (() => { // webpackBootstrap
/*!********************************************************!*\
  !*** ./Resources/assets/js/monthly-expense-summary.js ***!
  \********************************************************/
$(function () {
  "use strict";

  // Universal Chart.js Options for the Student Module
  var options = {
    tooltips: {
      callbacks: {
        // Customize tooltip label to display values in UGX currency format
        label: function label(tooltipItem, data) {
          var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
          return value.toLocaleString("en-US", {
            style: "currency",
            currency: "UGX"
          });
        }
      }
    },
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true,
          // Ensure Y-axis starts at zero
          callback: function callback(value, index, values) {
            // Convert Y-axis tick values to localized number format
            return value.toLocaleString();
          }
        }
      }]
    },
    legend: {
      display: false,
      // Hide the legend by default
      position: "bottom",
      // Legend position if displayed
      onClick: function onClick() {
        // Example event: Alert message on legend click
        alert("hello");
      }
    },
    elements: {
      point: {
        radius: 4,
        // Default point size in the chart
        hitRadius: 7,
        // Increased hit radius for better interactivity
        pointStyle: "star" // Custom point style
      }
    },
    // Add a plugin to render values at the top of points
    plugins: {
      afterDatasetsDraw: function afterDatasetsDraw(chart) {
        var ctx = chart.ctx;
        chart.data.datasets.forEach(function (dataset, i) {
          var meta = chart.getDatasetMeta(i);
          if (!meta.hidden) {
            meta.data.forEach(function (element, index) {
              // Get the data value
              var dataValue = dataset.data[index];
              // Convert the data value to localized format
              var displayValue = dataValue.toLocaleString("en-US", {
                style: "currency",
                currency: "UGX"
              });

              // Set font style and alignment for rendering
              ctx.font = Chart.helpers.fontString(12, "normal", Chart.defaults.global.defaultFontFamily);
              ctx.fillStyle = "black"; // Text color
              ctx.textAlign = "center";
              ctx.textBaseline = "bottom";

              // Calculate the position of the text
              var position = element.tooltipPosition();
              ctx.fillText(displayValue, position.x, position.y - 10);
            });
          }
        });
      }
    }
  };

  // Check if the chart data and labels are defined before proceeding
  if (typeof monthlyExpenseSummaryChartLabels !== "undefined" && typeof monthlyExpenseSummaryChartData !== "undefined") {
    // Define chart data structure for monthly expenses
    var monthlyExpenseSummary = {
      labels: monthlyExpenseSummaryChartLabels,
      // Chart labels (e.g., months)
      datasets: [{
        label: "Expenses",
        // Dataset label
        data: monthlyExpenseSummaryChartData,
        // Dataset values
        backgroundColor: [
        // Background colors for the chart elements
        "rgba(54, 162, 235, 0.2)", "rgba(255, 206, 86, 0.2)", "rgba(75, 192, 192, 0.2)", "rgba(153, 102, 255, 0.2)", "rgba(255, 159, 64, 0.2)", "rgba(255, 99, 132, 0.2)", "rgba(54, 162, 235, 0.2)", "rgba(255, 206, 86, 0.2)", "rgba(75, 192, 192, 0.2)", "rgba(153, 102, 255, 0.2)", "rgba(255, 159, 64, 0.2)"],
        borderColor: [
        // Border colors for the chart elements
        "rgba(54, 162, 235, 1)", "rgba(255, 206, 86, 1)", "rgba(75, 192, 192, 1)", "rgba(153, 102, 255, 1)", "rgba(255, 159, 64, 1)", "rgba(255,99,132,1)", "rgba(54, 162, 235, 1)", "rgba(255, 206, 86, 1)", "rgba(75, 192, 192, 1)", "rgba(153, 102, 255, 1)", "rgba(255, 159, 64, 1)"],
        borderWidth: 1 // Border width of chart elements
      }]
    };

    // Get the 2D context of the chart container
    var ctx = $("#monthlyExpenseSummaryChart").get(0).getContext("2d");

    // Initialize the chart with specified type, data, and options
    var monthlyExpenseSummaryChart = new Chart(ctx, {
      type: "bar",
      // Chart type: line chart
      data: monthlyExpenseSummary,
      // Chart data
      options: options // Chart configuration options
    });
  }
});
/******/ })()
;