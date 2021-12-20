(function navAndChatMovement() {
   const triggElement = document.querySelector("main > div");
   const nav = document.querySelector("nav");
   const chat = document.querySelector("form[name=chat]");

   chat.style.bottom = "15px";
   window.addEventListener("scroll", () => {
      if (window.scrollY > triggElement.offsetTop) {
         nav.style.bottom = "0px";
         chat.style.bottom = "70px";
      } if (window.scrollY + window.innerHeight < triggElement.offsetTop) {
         nav.style.bottom = "";
         chat.style.bottom = "15px";
      }
   })
})();
