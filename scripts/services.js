(function tabHandler() {  
   console.log(window.location)
   let buttons = document.getElementsByClassName("tab_buttons");
   let articles = document.querySelectorAll("article");
   let section = document.querySelector("main section");
   let clicked = false;

   for (let i=0 ; i<buttons.length ; i++) {
      buttons[i].addEventListener("click", () => {
         if (!clicked) {
            for (let article of articles) article.style.display = "none";

            articles[i].style.display = "flex";
            section.style.maxHeight = "1500px";

            clicked = true;
         } else {
            section.style.maxHeight = "0";

            clicked = false;
         }
      });
   }
})();

(function burgerHandler() {
   let burgerButton = document.querySelector("#drop_button");
   let buttons = document.getElementsByClassName("tab_buttons");
   burgerButton.addEventListener("click", () => {
      for (let button of buttons) {
         if (button.style.display === "block") {
            button.style.display = "none";
         } else {
            button.style.display = "block";
         }
      }
   })
})();

