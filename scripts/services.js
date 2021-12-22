(function tabHandler() {
   
   let buttons = document.getElementsByClassName("tab_buttons");
   let articles = document.querySelectorAll("article");

   for (let i=0 ; i<buttons.length ; i++) 
   {
      buttons[i].addEventListener("click", () => {
         for (let article of articles) article.style.display = "none";
         articles[i].style.display = "flex";
      });
   }
})();

(function burgerHandler() {
   var burgerButton = document.querySelector("#drop_button");
   var buttons = document.getElementsByClassName("tab_buttons");
   
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