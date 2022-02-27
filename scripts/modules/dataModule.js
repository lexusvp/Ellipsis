import { queryControler } from './controlerModule.js';
import { admin } from './userModule.js';

export {dashboardControls, errorReview };

async function dashboardControls() {
   const sliders = Array.from(document.querySelectorAll(".slider_container > input"));
   const buttons = Array.from(document.querySelectorAll("#buttons_container > input"));
   const canva = document.querySelector("#chart1");   

   buttons[0].classList.toggle("active_control");

   let dataset = {};
   let target = "Logins";
   let resolution = "Daily";
   let range = "30";
   let args = {
      'type': "getData",
      'target[]': [ target ],
      'resolution': resolution,
      'range': range
   };
   let stepVal = [2, 4, 7, 14, 30, 60, 90];

   dataset = await queryControler("adminControler", args);
   const chart = drawChart(canva, dataset["Logins"], {
      titre: `${resolution} ${target}`,
      label: target
   })

   sliders[0].addEventListener("change", async (e) => {
      const value = e.target.value;
      if (value === "1") {
         args.resolution = "Hourly";
         stepVal = [2, 4, 6, 10, 12, 16, 24];
      } else if (value === "2") {
         args.resolution = "Daily";
         stepVal = [2, 4, 7, 14, 30, 60, 90];
      } else if (value === "3") {
         args.resolution = "Weekly";
         stepVal = [2, 3, 4, 6, 8, 10, 12];
      }
      
      args["target[]"] = [];
      for (let i=0 ; i < chart.data.datasets.length ; i++) {
         args["target[]"].push(chart.data.datasets[i].label);
      }
      const updatedDatasets = await queryControler("adminControler", args);
      replaceDatasetArr(chart, updatedDatasets);
   });
   sliders[1].addEventListener("input", async (e) => {
      args.range = stepVal[parseInt(e.target.value)];

      args["target[]"] = [];  
      for (let i=0 ; i < chart.data.datasets.length ; i++) {
         args["target[]"].push(chart.data.datasets[i].label);
      }
      const updatedDatasets = await queryControler("adminControler", args);
      replaceDatasetArr(chart, updatedDatasets);
   });

   buttons[0].addEventListener("click", async () => {
      for (let i=0 ; i < chart.data.datasets.length ; i++) {
         if (chart.data.datasets[i].label === "Logins") {
            chart.data.datasets.splice(i, 1);
            
            chart.update();
            buttons[0].classList.toggle("active_control");
            return;
         }
      }

      args["target[]"].push("Logins");
      buttons[0].classList.toggle("active_control");
      dataset = await queryControler("adminControler", args);
      addDataset(chart, dataset, "Logins");         
   });
   buttons[1].addEventListener("click", async () => {
      for (let i=0 ; i < chart.data.datasets.length ; i++) {
         if (chart.data.datasets[i].label === "Registrations") {
            chart.data.datasets.splice(i, 1);
            chart.update();
            buttons[1].classList.toggle("active_control");
            return;
         }
      }

      args["target[]"].push("Registrations");
      buttons[1].classList.toggle("active_control");
      dataset = await queryControler("adminControler", args);
      addDataset(chart, dataset, "Registrations");   
   });
   buttons[2].addEventListener("click", async () => {
      for (let i=0 ; i < chart.data.datasets.length ; i++) {
         if (chart.data.datasets[i].label === "Messages") {
            chart.data.datasets.splice(i, 1);
            chart.update();
            buttons[2].classList.toggle("active_control");
            return;
         }
      }

      args["target[]"].push("Messages");
      buttons[2].classList.toggle("active_control");
      dataset = await queryControler("adminControler", args);
      addDataset(chart, dataset, "Messages");   
   });
}

function addDataset(chart, dataset, type) {
   const datasetObj = formatDataset(dataset[type], type);
   chart.data.datasets.push(datasetObj);
   chart.update();
}
function replaceDatasetArr(chart, datasetsObj) {
   let datasetArr = [];
   for (let dataset in datasetsObj) {
      if (dataset === "authorized") return null;
      datasetArr.push(formatDataset(datasetsObj[dataset], dataset)); 
   }
   chart.data.datasets = datasetArr;
   console.log("datasetArr : ", datasetArr)
   chart.update();
}
function formatDataset(dataset, type) {
   let color = ``;
   if (type === "Messages") {
      color = `169, 185, 118`;
   } else if (type === "Logins") {
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
         'type': "getData",
         'target[]': ["Errors"],
         'resolution': "",
         'range': 1,
      });
      if (errors !== null) console.table("Errors : ", errors);	
   }
}
