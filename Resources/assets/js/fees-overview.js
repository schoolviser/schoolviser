$(function () {
 /* ChartJS
  * -------
  * Data and config for chartjs
  */
 'use strict';

 var doughnutPieData = {
  datasets: [{
    data: feeCollectionDoughnutChartData,
    backgroundColor: [
     'rgba(75, 192, 192, 0.5)',
      'rgba(255, 0, 0, 0.5)',
    ],
    borderColor: [
     'rgba(75, 192, 192, 1)',
      'rgba(255, 0, 0, 1)',
    ],
 }],

  // These labels appear in the legend and in the tooltips when hovering different arcs
  labels: [
    'Collected Fees',
    'Uncollected Fees',
  ],
  weight: 900
};

 var doughnutPieOptions = {
   responsive: true,
   animation: {
     animateScale: true,
     animateRotate: true
   },
   rotation: 40
 };

 if ($("#feeCollectionDoughnutChart").length) {
   var doughnutChartCanvas = $("#feeCollectionDoughnutChart").get(0).getContext("2d");
   var doughnutChart = new Chart(doughnutChartCanvas, {
     type: 'doughnut',
     data: doughnutPieData,
     options: doughnutPieOptions
   });
 }
 
});