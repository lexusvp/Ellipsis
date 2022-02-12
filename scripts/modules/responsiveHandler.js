function responsiveHandler() {
   initialState();
   dynamicState();
}

function initialState() {
   if (window.innerWidth < 1300) { 
      navIcons("small");
   }
   if (window.innerWidth >= 1300) {
      navIcons("big");
   }
}
function dynamicState() {
   window.addEventListener(("resize"), (e) => {
      if (window.innerWidth < 1300) { 
         navIcons("small");
      }
      if (window.innerWidth >= 1300) {
         navIcons("big");
      }
   });
}

//== TODO: SVG icons insted of this BS
function navIcons(size) {
   const links = document.querySelectorAll("#main_menu li > a, #main_menu li > button");
   const lefSideButton = document.querySelector("#main_menu li:nth-child(3)");
   const iconsClasses = [
      ["fas", "fa-home"], 
      ["fas", "fa-code"], 
      ["far", "fa-user-circle"], 
      ["far" , "fa-comment-dots"],
      ["far", "fa-right-from-bracket"]
   ];
   
   if (size === "small") {
      lefSideButton.style.right = "48px";
      for (let link of links) {
         link.textContent = "";
      }
      for (let i=0 ; i<links.length ; i++) {
         const iElement = document.createElement("i");
         iElement.classList.add(iconsClasses[i][0], iconsClasses[i][1]);
         links[i].appendChild(iElement);
      }
   }
   if (size === "big") {
      lefSideButton.style.right = "";
      const names = ["Acceuil", "Services", "Account", "Chat", "Log Out"];
      for (let i=0 ; i<links.length ; i++) {
         links[i].textContent = names[i];
      }
   }
}