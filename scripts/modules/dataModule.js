import { queryControler } from './controlerModule.js';
import { admin } from './userModule.js';

export {dashboardControls, errorReview };

async function dashboardControls() {
   const slide = Array.from(document.querySelectorAll(".slider_container > input"));
   const buttons = Array.from(document.querySelectorAll("#buttons_container > input"));
   const canva = document.querySelector("#chart1");   

   let dataset = {};
   let target = "Message";
   let resolution = "Daily";
   let range = "30";
   let clicked1, clicked2, clicked3 = [ false, false, true ];
   let args = {
      type: "getData",
      target: target,
      resolution: resolution,
      range: range
   };

   dataset = await queryControler("adminControler", args);
   const chart = drawChart(canva, dataset, {
      titre: `${resolution} ${target}`,
      label: target
   })

   slide[0].addEventListener("input", async (e) => {
      const value = e.target.value;
      args.resolution = value === "1" ? "Hourly" : value === "2" ? "Daily" : "Weekly";

      // Aller chercher les datasets utilisés, query tout les data nécessaires => replace tout les anciens datasets
      // avec la nouvelle résolution

      dataset = await queryControler("adminControler", args);
      replaceDataset(chart, dataset, chart.data.datasets[0].label);
   });
   // slide[1].addEventListener("input", async (e) => {
   //    args.range = parseInt(e.target.value);

   //    if (!used) {
   //       used = true;
   //       dataset = await queryControler("adminControler", args);
   //       replaceDataset(chart, dataset);       
   //    }
   // });

   buttons[0].addEventListener("click", async () => {
      args.target = "Login";

      if (!clicked1) {
         dataset = await queryControler("adminControler", args);
         addDataset(chart, dataset, "Login");     
         clicked1 = true; 
      } else {
         chart.data.datasets.pop();
         chart.update();
         clicked1 = false; 
      }
   });
   buttons[1].addEventListener("click", async () => {
      args.target = "Registration";

      if (!clicked2) {
         dataset = await queryControler("adminControler", args);
         addDataset(chart, dataset, "Registration");    
         clicked2 = true; 
      } else {
         chart.data.datasets.pop();
         chart.update();         
         clicked2 = false; 
      }      
   });
   buttons[2].addEventListener("click", async () => {
      args.target = "Message";

      if (!clicked3) {
         dataset = await queryControler("adminControler", args);
         addDataset(chart, dataset, "Message");         
         clicked3 = true; 
      } else {
         chart.data.datasets.pop();
         chart.update();
         clicked3 = false; 
      }        
   });
}
function formatDataset(data, type) {
   let color = ``;
   if (type === "Message") {
      color = `169, 185, 118`;
   } else if (type === "Login") {
      color = `118, 169, 185`;
   } else {
      color = `185, 118, 169`;
   }

   return {
      label: type,
      data: data,  
      normalized: true,
      
      fill: true,
      backgroundColor: `rgba(${color}, 0.2)`,
      borderColor: `rgb(${color})`,
   }
}
function replaceDataset(chart, dataset, type) {
   const datasetObj = formatDataset(dataset, type);
   chart.data.datasets.pop();
   chart.data.datasets.push(datasetObj);
   chart.update();
}
function addDataset(chart, dataset, type) {
   const datasetObj = formatDataset(dataset, type);
   chart.data.datasets.push(datasetObj);
   chart.update();
}
function drawChart(ctx, datasets, style) {
   const config = {
      type: 'line',
      data: {
         datasets: 
      [
         {
            label: style.label,
            data: datasets,  
            normalized: true,
            
            fill: true,
            backgroundColor: 'rgba(169, 185, 118, 0.2)',
            borderColor: 'rgb(169, 185, 118)',
         }
      ]
   },
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
               display: false,
               align: "center",
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
               position: "bottom",
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
   };
   const chart = new Chart(ctx, config);
   return chart;
}




async function errorReview() {
   if (admin()) {
      const errors = await queryControler("adminControler", {
         type: "getData",
         target: "Error",
         resolution: "Hourly",
         range: 1,
      });
      if (errors !== null) console.table("Errors : ", errors);	
   }
}
