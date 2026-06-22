$(function () {
 //Accounting JS for Accounting module blade templates
 'use strict';

 //Universal ChartJs Options for Accounting Module
 var options = {
  tooltips: {
    callbacks: {
        label: function(tooltipItem, data) {
            var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
            return value.toLocaleString('en-US', { style: 'currency', currency: 'UGX' });
        }
    }
  },
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true,
          callback: function(value, index, values) {
            // Convert value to currency format
            return value.toLocaleString();
          }
        }
      }]
    },
    legend: {
      display: false,
      position: 'bottom',
      onClick : function(){
       alert('hello')
      }
    },
    elements: {
      point: {
        radius: 4,
        hitRadius: 7,
        pointStyle: 'star'
      }
    }

  };


  //Monthly Expense Chart
  if(typeof termlyMonthlyExpenseLineChartLabels !== 'undefined' && typeof termlyMonthlyExpenseLineChartData !== 'undefined'){
    var termlyMonthlyExpenseChartData = {
      labels: termlyMonthlyExpenseLineChartLabels,
      datasets: [{
        label: 'Expenses',
        data: termlyMonthlyExpenseLineChartData,
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(255, 159, 64, 0.2)',
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
          'rgba(255,99,132,1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)',
          'rgba(255,99,132,1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 2,
        fill: false
      }]
    };
    if ($("#termlyMonthlyExpenseLineChart").length) {
      var lineChartCanvas = $("#termlyMonthlyExpenseLineChart").get(0).getContext("2d");
      var lineChart = new Chart(lineChartCanvas, {
        type: 'bar',
        data: termlyMonthlyExpenseChartData,
        options: options
      });
     }

  }

  if(typeof cashBalanceChartLabels !== 'undefined' && typeof cashBalanceChartData !== 'undefined'){
    var cashBalanceChartDataSetUp = {
      labels: cashBalanceChartLabels,
      datasets: [{
        label: 'Running Balance',
        data: cashBalanceChartData,
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(255, 159, 64, 0.2)',
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
          'rgba(255,99,132,1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)',
          'rgba(255,99,132,1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 2,
        fill: false
      }]
    };
    if ($("#cashBalanceChart").length) {
      let cashBalanaceChartCanvas = $("#cashBalanceChart").get(0).getContext("2d");
      var lineChart = new Chart(cashBalanaceChartCanvas, {
        type: 'bar',
        data: cashBalanceChartDataSetUp,
        options: options
      });
     }

  }



  //Compare cash balances donut chart

  var availableTags = [
    "ActionScript",
    "AppleScript",
    "Asp",
    "BASIC",
    "C",
    "C++",
    "Clojure",
    "COBOL",
    "ColdFusion",
    "Erlang",
    "Fortran",
    "Groovy",
    "Haskell",
    "Java",
    "JavaScript",
    "Lisp",
    "Perl",
    "PHP",
    "Python",
    "Ruby",
    "Scala",
    "Scheme"
  ];

  $( "#reference" ).autocomplete({
    source: availableTags, // Data source
    minLength: 1, // Minimum characters before triggering autocomplete
    delay: 300, // Delay in milliseconds before sending the request to fetch data (useful for performance)
    autoFocus: true // Automatically focus on the first item in the dropdown
  });

  $( "#datepicker" ).datepicker({
    dateFormat: 'yy-mm-dd', // Format of the date
    changeMonth: true, // Show month dropdown
    changeYear: true, // Show year dropdown
    yearRange: '1900:2100', // Range of years to display
    minDate: new Date(1900, 0, 1), // Minimum selectable date
    maxDate: new Date(2100, 11, 31), // Maximum selectable date
    showButtonPanel: true, // Show button panel for today and done buttons
    onClose: function(dateText, inst) {
      // Handle close event, if needed
    }
  });


 
});