import { queryControler } from './controlerModule.js';
import { admin } from './userModule.js';

export { displayDatasets, errorReview };

async function displayDatasets() {

   if (!admin()) return;

   const canva = document.querySelector("#chart1");   
   const userCountSlot = document.querySelector("#userCount");
   const userCount = await queryControler("adminControler", [
      `type=getData`,
      `target=userCount`
   ]);

   const setup = {
      range: 30,
      resolution: "Minutely",
      title: `Hourly Connexions / Messages for the last 24 Hours`
   }
   const loginCount = await queryControler("adminControler", [
      `type=getData`,
      `target=Login`,
      `resolution=${setup.resolution}`,
      `range=${setup.range}`
   ]);
   const messCount = await queryControler("adminControler", [
      `type=getData`,
      `target=Messages`,
      `resolution=${setup.resolution}`,
      `range=${setup.range}`
   ]);
   console.log("messCount : ", messCount);

   userCountSlot.textContent = `The website has ${userCount} registered users !`;
   drawChart(canva, [ loginCount, messCount ], [
      setup.title,
      ["Connexions", "Messages"],
   ]); 
}

function drawChart(canva, datasets, style) {
   const chartList = [];
   const ctx = canva;
   const config = {
      type: 'line',
      data: {
         datasets: [
         {
            label: style[1][0],
            data: datasets[0],  
            normalized: true,
            
            fill: true,
            backgroundColor: 'rgba(169, 185, 118, 0.2)',
            borderColor: 'rgb(169, 185, 118)',
         },
         {
            label: style[1][1],
            data: datasets[1],
            normalized: true,

            fill: true,
            backgroundColor: 'rgba(112, 131, 187, 0.2)',
            borderColor: 'rgb(112, 131, 187)',
         },
      ]},
      options: {
         responsive: false, 
         elements: {
            line: {
               cubicInterpolationMode: "monotone",
               borderWidth: 2.5,
               borderJoinStyle: "round",
            } 
         },
         plugins: {
            title: {
               display: true,
               text: style[0],
               align: "center",
               position: "bottom",
               font: {
                  size: 20,
                  family: 'Viga',
                  weight: 500
               },
               padding: {
                  top: 15,
                  bottom: 30
               }
            },
            legend: {
               display: true,
               labels: {
                  font: {
                     size: 15,
                     family: 'Viga',
                     weight: 300
                  },
                  boxWidth: 60,
                  boxHeight: 20,
               }
            },
            tooltip: {
               padding: 10,
            }
         },
         scales: {
            x : {
               ticks: {
                  maxRotation: 0,
                  maxTicksLimit: 10,
                  padding: 10
               },
            },
            y : {
               ticks: {
                  maxRotation: 0,
                  maxTicksLimit: 10,
                  padding: 10
               },
            }
         }
      },
   }
   const chart = new Chart(ctx, config);
   chartList.push(chart);
}

async function errorReview() {
	const errors = await queryControler("adminControler", [
		`type=getData`,
		`target=Error`,
		`resolution=Hourly`,
		`range=${1}`
	]);
	if (errors !== null) console.table("Errors : ", errors);	
}