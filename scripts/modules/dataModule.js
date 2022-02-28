import { queryControler } from './controlerModule.js';
import { admin } from './userModule.js';

export { dashboardControls, errorReview };

const displayed = [true, false, false, false];
const curveColors = [
   `120, 150, 185`,
   `150, 190, 150`,
   `225, 210, 144`,
   `209, 104, 104`,
]

async function dashboardControls() {
   const sliders = Array.from(document.querySelectorAll(".slider_container > input"));
   const buttons = Array.from(document.querySelectorAll("#buttons_container > input"));
   const canva = document.querySelector("#chart1");

   for (let i = 0; i < buttons.length; i++) {
      buttons[i].addEventListener("mouseover", () => {
         if (chart.data.datasets[i].hidden === true) {
            buttons[i].style.backgroundColor = `rgb(${curveColors[i]})`;
            buttons[i].style.color = `white`;
         }
      });
      buttons[i].addEventListener("mouseout", () => {
         if (chart.data.datasets[i].hidden === true) {
            buttons[i].style.backgroundColor = ``;
            buttons[i].style.color = ``;
         }
      });
   }
   buttons[0].style.backgroundColor = `rgb(${curveColors[0]})`;
   buttons[0].style.color = `white`;

   let stepVal = [2, 4, 7, 14, 30, 60, 90];
   let resolution = "Daily";
   let range = "30";
   let args = {
      'type': "getData",
      'target[]': ["Logins", "Registrations", "Messages", "Errors"],
      'resolution': resolution,
      'range': range
   };

   let datasets = await queryControler("adminControler", args);
   const chart = drawChart(canva, datasets);
   chart.show(0);
   chart.data.datasets[0].hidden = false;

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

      const updatedDatasets = await queryControler("adminControler", args);
      chart.data.datasets = formatDatasets(updatedDatasets);
      chart.update();
      for (let i = 0; i < chart.data.datasets.length; i++) {
         if (displayed[i]) {
            chart.show(i);
            chart.data.datasets[0].hidden = false;
         }
      }
   });
   sliders[1].addEventListener("input", async (e) => {
      args.range = stepVal[parseInt(e.target.value)];

      const updatedDatasets = await queryControler("adminControler", args);
      chart.data.datasets = formatDatasets(updatedDatasets);
      chart.update();
      for (let i = 0; i < chart.data.datasets.length; i++) {
         if (displayed[i]) {
            chart.show(i);
            chart.data.datasets[0].hidden = false;
         }
      }
   });

   buttons[0].addEventListener("click", async () => {
      toogleCurve(buttons, 0, chart);
   });
   buttons[1].addEventListener("click", async () => {
      toogleCurve(buttons, 1, chart);
   });
   buttons[2].addEventListener("click", async () => {
      toogleCurve(buttons, 2, chart);
   });
   buttons[3].addEventListener("click", async () => {
      toogleCurve(buttons, 3, chart);
   });
}

function toogleCurve(buttons, index, chart) {
   if (displayed[index]) {
      buttons[index].style.backgroundColor = ``;
      buttons[index].style.color = `var(--main-black)`;
      displayed[index] = false;
      chart.data.datasets[index].hidden = true;

      chart.stop();
      chart.hide(index);

      return;
   }
   chart.data.datasets[index].hidden = false;
   displayed[index] = true;
   buttons[index].style.backgroundColor = `rgb(${curveColors[index]})`;
   buttons[index].style.color = `white`;

   chart.show(index);
}
function formatDatasets(datasets) {
   let color = ``;
   let datasetsArr = [];
   for (let key in datasets) {
      if (key === "authorized") return null;
      if (key === "Logins") color = curveColors[0];
      else if (key === "Registrations") color = curveColors[1];
      else if (key === "Messages") color = curveColors[2];
      else if (key === "Errors") color = curveColors[3];

      datasetsArr.push({
         label: key,
         data: datasets[key],
         normalized: true,

         fill: true,
         backgroundColor: `rgba(${color}, 0.2)`,
         borderColor: `rgb(${color})`,
         hidden: true
      });
   }

   return datasetsArr;
}
function drawChart(ctx, datasets) {
   const config = {
      type: 'line',
      data: {
         datasets: formatDatasets(datasets)
      },
      options: {
         responsive: false,
         elements: {
            line: {
               cubicInterpolationMode: "monotone",
               borderWidth: 2.5,
               borderJoinStyle: "round",
            },
            bar: {

            },
            point: {
               radius: 5,
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
               display: false,
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
            x: {
               ticks: {
                  maxRotation: 0,
                  maxTicksLimit: 10,
                  padding: 10
               },
            },
            y: {
               ticks: {
                  maxRotation: 0,
                  maxTicksLimit: 10,
                  padding: 10
               },
            }
         },
         transitions: {
            show: {
               animations: {
                  easing: "linear",
                  y: {
                     from: 500
                  }
               }
            },
            hide: {
               animations: {
                  easing: "linear",
                  y: {
                     to: 500
                  }
               }
            }
         }
      }
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
