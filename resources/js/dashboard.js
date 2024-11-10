$(function () {
 /* ChartJS
  * -------
  * Data and config for chartjs
  */
 'use strict';
 
 
 var options = {
   scales: {
     yAxes: [{
       ticks: {
         beginAtZero: true
       }
     }]
   },
   legend: {
     display: false
   },
   elements: {
     point: {
       radius: 1
     }
   },

   animation : {
    duration: 500,
    easing: "easeOutQuart",
    onComplete: function () {
        var ctx = this.chart.ctx;
        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
        ctx.textAlign = 'center';
        ctx.textBaseline = 'bottom';

        this.data.datasets.forEach(function (dataset) {
            for (var i = 0; i < dataset.data.length; i++) {
                var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
                scale_max = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._yScale.maxHeight;
                ctx.fillStyle = '#444';
                var y_pos = model.y - 1;
                // Make sure data value does not get overflown and hidden
                // when the bar's value is too close to max value of scale
                // Note: The y value is reverse, it counts from top down
                if ((scale_max - model.y) / scale_max >= 0.93)
                    y_pos = model.y + 20;
                ctx.fillText(dataset.data[i], model.x, y_pos);
            }
        });
    }
   }

 };


 // Get context with jQuery - using jQuery's .get() method.
 if ($("#studentsPerCourseChart").length && studentsPerCourseChartLabels !== undefined && studentsPerCourseChartLabels !== undefined) {
  var StudentsPerCourseChartData = {
    labels: studentsPerCourseChartLabels,
    datasets: [{
      label: '# of Students',
      data: studentsPerCourseChartData,
      backgroundColor: [
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
        'rgba(255, 159, 64, 1)'
      ],
      borderWidth: 2,
      fill: false
    }]
  };
   var barChartCanvas = $("#studentsPerCourseChart").get(0).getContext("2d");
   // This will get the first returned node in the jQuery collection.
   var barChart = new Chart(barChartCanvas, {
     type: 'bar',
     data: StudentsPerCourseChartData,
     options: options
   });
 }

  // Get context with jQuery - using jQuery's .get() method.
  if ($("#expenseSummaryBarChart").length) {
    var barChartCanvas = $("#expenseSummaryBarChart").get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    var barChart = new Chart(barChartCanvas, {
      type: 'bar',
      data: studentsPerClazzData,
      options: options
    });
  }

  // Get context with jQuery - using jQuery's .get() method.
  var termlyRegisstrationSummaryChartData = {
    labels: ['Term 1', 'Term 2', 'Term 3'],
    datasets: [{
      label: '# of Students',
      data: [2000, 300, 500],
      backgroundColor: [
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
        'rgba(255, 159, 64, 1)'
      ],
      borderWidth: 2,
      fill: true
    }]
  };

  if ($("#termlyRegistrationSummaryLineGraph").length) {
    var lineChartCanvas = $("#termlyRegistrationSummaryLineGraph").get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    var barChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: termlyRegisstrationSummaryChartData,
      options: options
    });
  }


  let monthlyRevenueExpenseLineChartData = {
    labels: ['Jan', 'Fab', 'Mar', 'Apr', 'May', 'June'],
    datasets: [
      {
        label: 'Expenses',
        data: [50, 100, 30,45,300,100],
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(255, 99, 132, 0.2)',
        ],
        borderColor: [
          'rgba(255,99,132,1)',
          'rgba(255,99,132,1)',
        ],
        borderWidth: 2,
        fill : false
      },
      {
        label: 'Revenue',
        data: [100, 500, 100,20,300,577],
        backgroundColor: [
          'rgba(255, 206, 86, 0.2)',
          'rgba(255, 206, 86, 0.2)',
        ],
        borderColor: [
          'rgba(255, 206, 86, 1)',
          'rgba(255, 206, 86, 1)',
        ],
        borderWidth: 2,
        fill : false
      }
    ]
  };
  if ($("#monthlyRevenueExpenseLineChart").length) {
    var lineChartCanvas = $("#monthlyRevenueExpenseLineChart").get(0).getContext("2d");
    var lineChart = new Chart(lineChartCanvas, {
      type: 'bar',
      data : monthlyRevenueExpenseLineChartData,
    });
  }
 
});