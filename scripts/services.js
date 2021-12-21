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