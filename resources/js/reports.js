$(function () {
 /* ChartJS
  * -------
  * Data and config for chartjs
  */
 'use strict';

 var doughnutPieData = {
  datasets: [{
    data: [1000000,300000,10000000,3000,400000,800000],
    backgroundColor: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(255, 206, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(255, 159, 64, 0.2)'
    ],
    borderColor: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(255, 206, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(255, 159, 64, 0.2)'
    ],
 }],

  // These labels appear in the legend and in the tooltips when hovering different arcs
  labels: [
    'S.1',
    'S.2',
    'S.3',
    'S.4',
    'S.5',
    'S.6',
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

 if ($("#feesReceivableDoughnutChart").length) {
   var doughnutChartCanvas = $("#feesReceivableDoughnutChart").get(0).getContext("2d");
   var doughnutChart = new Chart(doughnutChartCanvas, {
     type: 'doughnut',
     data: doughnutPieData,
     options: doughnutPieOptions
   });
 }
 
});