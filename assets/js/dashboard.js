/* globals Chart:false, feather:false */
if (document.querySelector("#paiement_paidAt") !== null){
  document.querySelector("#paiement_paidAt").valueAsDate = new Date();
} else if(document.querySelector("#advance_member_date_nais") !== null){
  document.querySelector("#advance_member_date_nais").valueAsDate = new Date();
}

(function () {
    'use strict'
  
    feather.replace()
    
    // Graphs
    //  var ctx = document.getElementById('myChart')
    // eslint-disable-next-line no-unused-vars
    /* var myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: [
          'Sunday',
          'Monday',
          'Tuesday',
          'Wednesday',
          'Thursday',
          'Friday',
          'Saturday'
        ],
        datasets: [{
          data: [
            15339,
            21345,
            18483,
            24003,
            23489,
            24092,
            12034
          ],
          lineTension: 0,
          backgroundColor: 'transparent',
          borderColor: '#007bff',
          borderWidth: 4,
          pointBackgroundColor: '#007bff'
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: false
            }
          }]
        },
        legend: {
          display: false
        }
      }
    }) */

  }())