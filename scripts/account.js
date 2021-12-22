/*=================================>> CHARTS  <<=================================*/

Chart.defaults.font  = {
   size: 12,
   family: "Quicksand",
}
const chartList = [];
const ctx = 'testChart';
const config = {
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
      datasets: [
      {
         label: "Prévision du nombre d'utilisateurs de mon site :)",
         data: [1, 500, 2500, 12500, 75000, 375000],
         
         backgroundColor: ['#a9b976', "#ffffff", '#b65a5a'],
         borderColor: '#a9b976',
         pointBackgroundColor: 'rgba(100, 150, 100, 0.0)',
         // cubicInterpolationMode: "monotone",
      },
      {
         label: "Prévision du nombre d'utilisateurs des autres sites :/",
         data: [375000, 75000, 12500, 2500, 500, 1],

         backgroundColor: '#b65a5a',
         borderColor: '#b65a5a',
         fill: '#b65a5a20',

         pointBackgroundColor: "#ffffff",
         // cubicInterpolationMode: "monotone",
      },
      {
         type: 'bar', 
         label: "Des barres stylées",
         data: [0, 50000, 120000, 190000, 50000, 0],
         
         backgroundColor: ['#CED7EF', "#CED7EF", '#CED7EF', '#7083bb', "#CED7EF", "#CED7EF"],
      },
   ]},
   options: {
      responsive: false, 
      plugins: {
         title: {
            display: true,
            text: "Mon super graphique de test !",
            align: "center",
            position: "bottom",
            font: {
               size: 18,
               family: 'Quicksand',
            },
            padding: {
               top: 10,
               bottom: 30
            }
         },
      },
      elements: {
         bar: {
            borderRadius: 5,
         }
      }
   },
}
const chart = new Chart(ctx, config);
chartList.push(chart);

//== TODO: Factor this in respHandler
function responsiveChart(chartList) {
   if(window.innerWidth > 800) {
      chart.resize(500, 400);
   } else {
      chart.resize(400, 350);
   }
   window.addEventListener("resize", (e) => {
      if(window.innerWidth > 800) {
         chart.resize(500, 400);
      } else {
         chart.resize(400, 350);
      }
   }) 
}
responsiveChart(chartList);

