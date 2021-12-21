/*=================================>> CHARTS  <<=================================*/

const ctx1 = 'testChart';
const config1 = {
   type: 'line',
   data: {
      labels: [
         'January',
         'February',
         'March',
         'April',
         'May',
         'June',
      ],
      datasets: [{
         backgroundColor: 'rgb(255, 99, 132)',
         borderColor: 'rgb(255, 99, 132)',
         data: [0, 10, 5, 2, 20, 30, 45]
      }]
   },
   options: {
      responsive: false,
   }
}
const ctx2 = 'testChart2';
const config2 = {
   type: 'line',
   data: {
      labels: [
         'January',
         'February',
         'March',
         'April',
         'May',
         'June',
      ],
      datasets: [{
         backgroundColor: 'rgb(255, 99, 132)',
         borderColor: 'rgb(255, 99, 132)',
         data: [0, 10, 5, 2, 20, 30, 45]
      }]
   },
   options: {
      responsive: false,
   }
}

const myChart = new Chart(ctx1, config1);
const myChart2 = new Chart(ctx2, config2);