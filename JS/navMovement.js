(() => {
   const triggElement = document.querySelector("main > div");
   const nav = document.querySelector("nav");
   console.log(triggElement.offsetTop);
   window.addEventListener("scroll", () => {
      if (window.scrollY > triggElement.offsetTop) {
         nav.style.bottom = "0px";
      } 
      if (window.scrollY + window.innerHeight < triggElement.offsetTop) {
         nav.style.bottom = "";
      }
   })
})();