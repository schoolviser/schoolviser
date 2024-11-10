$(function () {
 /* ChartJS
  * -------
  * Data and config for chartjs
  */
 'use strict';

 var doughnutPieData = {
  datasets: [{
    data: [1000000, 400000, 300000, 789000, 500000, 600000, 700000, 5000000],
    backgroundColor: [
      'rgba(255, 99, 132, 0.5)',
      'rgba(54, 162, 235, 0.5)',
      'rgba(255, 206, 86, 0.5)',
      'rgba(75, 192, 192, 0.5)',
      'rgba(255, 99, 132, 0.5)',

    ],
    borderColor: [
      'rgba(255,99,132,1)',
      'rgba(54, 162, 235, 1)',
      'rgba(255, 206, 86, 1)',
      'rgba(75, 192, 192, 1)',
      'rgba(255,99,132,1)',
    ],
 }],

  // These labels appear in the legend and in the tooltips when hovering different arcs
  labels: [
    'Pink',
    'Blue',
    'Yellow',
    'hello',
    'hellog',
    'girls',
    'hellor',
    'xdd',
  ]
};
var doughnutPieOptions = {
  responsive: true,
  animation: {
    animateScale: true,
    animateRotate: true
  }
};

 if ($("#pieChart").length) {
   var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
   var pieChart = new Chart(pieChartCanvas, {
     type: 'pie',
     data: doughnutPieData,
     options: doughnutPieOptions
   });
 }
 
});