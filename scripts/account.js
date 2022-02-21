/*=================================>> CHARTS  <<=================================*/

(async function main() {

   if (adminRole) {
      const canva = document.querySelector("#chart1");
      const canva2 = document.querySelector("#chart2");
      const userCountSlot = document.querySelector("#userCount");
      const regCountSlot = document.querySelector("#regCount");
      const userCount = await queryControler([
         `type=getData`,
         `query=countUsers`
      ]);
      const regCount = await queryControler([
         `type=getData`,
         `query=countRegistrations`
      ]);
      const loginCount = await queryControler([
         `type=getData`,
         `query=countLogins`,
         `interval=daily`
      ]);
      console.log("loginCount : ", loginCount);

      userCountSlot.textContent = `Il y a ${userCount[0]} utilisateurs inscrits !`;
      regCountSlot.textContent = `Il y a eu ${regCount[0]} inscriptions !`;

      drawChart(canva); 
      drawChart(canva2);
   }

   const userPseudoSlot = document.querySelector("#user_pseudo");
   userPseudoSlot.textContent = userData.pseudo;
})();

function drawChart(canva) {
   Chart.defaults.font  = {
      size: 12,
      family: "Quicksand",
   }
   const chartList = [];
   const ctx = canva;
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
            cubicInterpolationMode: "monotone",
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
            legend: {
               display: true
            }
         },
         // elements: {
         //    bar: {
         //       borderRadius: 5,
         //    }
         // }
      },
   }
   const chart = new Chart(ctx, config);
   chartList.push(chart);

   // if(window.innerWidth > 800) {
   //    chart.resize(500, 400);
   // } else {
   //    chart.resize(400, 350);
   // }
   // window.addEventListener("resize", (e) => {
   //    if(window.innerWidth > 800) {
   //       chart.resize(500, 400);
   //    } else {
   //       chart.resize(400, 350);
   //    }
   // }) 
}

