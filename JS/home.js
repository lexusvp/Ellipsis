(function navAndChatMovement() {
   const triggElement = document.querySelector("main > div");
   const nav = document.querySelector("nav");
   const chat = document.querySelector("#chat_container");
   window.addEventListener("scroll", () => {
      if (window.scrollY > triggElement.offsetTop) {
         nav.style.bottom = "0px";
         chat.style.bottom = "";
      } if (window.scrollY + window.innerHeight < triggElement.offsetTop) {
         chat.style.bottom = "15px";
         nav.style.bottom = "";
      }
   })
})();
