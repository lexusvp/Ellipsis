import { queryControler } from './controlerModule.js';
import { admin } from './userModule.js';

export {dashboardControls, errorReview };

async function dashboardControls() {
   const slide = Array.from(document.querySelectorAll(".slider_container > input"));
   const buttons = Array.from(document.querySelectorAll("#buttons_container > input"));
   const canva = document.querySelector("#chart1");   
   buttons[0].classList.toggle("active_control");

   let dataset = {};
   let target = "Login";
   let resolution = "Daily";
   let range = "30";
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
      const datasetArr = [];
      const value = e.target.value;
      args.resolution = value === "1" ? "Hourly" : value === "2" ? "Daily" : "Weekly";

      // Aller chercher les datasets utilisés, query tout les data nécessaires => replace tout les anciens datasets
      // avec la nouvelle résolution

      for (let i=0 ; i<chart.data.datasets.length ; i++) {
         args.target = chart.data.datasets[i].label;
         dataset = await queryControler("adminControler", args);
         datasetArr.push([dataset, args.target]);
      }
      
      replaceDatasetArr(chart, datasetArr);
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

      const obj = chart.data.datasets;
      for (let i=0 ; i<chart.data.datasets.length ; i++) {
         if (obj[i].label === "Login") {
            obj.splice(i, 1);
            chart.update();
            buttons[0].classList.toggle("active_control");
            return;
         }
      }

      buttons[0].classList.toggle("active_control");
      dataset = await queryControler("adminControler", args);
      addDataset(chart, dataset, "Login");         
   });
   buttons[1].addEventListener("click", async () => {
      args.target = "Registration";

      const obj = chart.data.datasets;
      for (let i=0 ; i<chart.data.datasets.length ; i++) {
         if (obj[i].label === "Registration") {
            obj.splice(i, 1);
            chart.update();
            buttons[1].classList.toggle("active_control");
            return;
         }
      }

      buttons[1].classList.toggle("active_control");
      dataset = await queryControler("adminControler", args);
      addDataset(chart, dataset, "Registration");   
   });
   buttons[2].addEventListener("click", async () => {
      args.target = "Message";

      const obj = chart.data.datasets;
      for (let i=0 ; i<chart.data.datasets.length ; i++) {
         if (obj[i].label === "Message") {
            obj.splice(i, 1);
            chart.update();
            buttons[2].classList.toggle("active_control");
            return;
         }
      }

      buttons[2].classList.toggle("active_control");
      dataset = await queryControler("adminControler", args);
      addDataset(chart, dataset, "Message");   
   });
}

function addDataset(chart, dataset, type) {
   const datasetObj = formatDataset(dataset, type);
   chart.data.datasets.push(datasetObj);
   chart.update();
}
function replaceDatasetArr(chart, datasetArr) {
   chart.data.datasets = formatDatasetArr(datasetArr);
   chart.update();
}
function formatDatasetArr(arr) {
   let resultArr = [];
   for (let i = 0; i<arr.length ; i++) {
      resultArr.push(formatDataset(arr[i][0], arr[i][1])); 
   }
   return resultArr;
}
function formatDataset(dataset, type) {
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
      data: dataset,  
      normalized: true,
      
      fill: true,
      backgroundColor: `rgba(${color}, 0.2)`,
      borderColor: `rgb(${color})`,
   }
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
            backgroundColor: 'rgba(118, 169, 185, 0.2)',
            borderColor: 'rgb(118, 169, 185)',
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
