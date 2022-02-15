function displayModule() {
   initialState();
   dynamicState();
}

//=====================>> RESPONSIVENESS <<======================//


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
   const nav = document.querySelector("#main_menu") ?? null;
   if (nav === null) return;
   
   const links = document.querySelectorAll("#main_menu li > a, #main_menu li > button");
   const accountButton = document.querySelector("#account_button");
   const iconsClasses = [
      ["fas", "fa-home"], 
      ["fas", "fa-code"], 
      ["far", "fa-user-circle"], 
      ["far" , "fa-comment-dots"],
      ["far", "fa-right-from-bracket"]
   ];
   
   if (size === "small") {
      accountButton.style.right = "48px";
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
      accountButton.style.right = "";
      const names = ["Acceuil", "Services", "Account", "Chat", "Log Out"];
      for (let i=0 ; i<links.length ; i++) {
         links[i].textContent = names[i];
      }
   }
}

//=======================>> FORM ANIMS <<========================//

//== Note: Possbile refactoring / improvements possible
function formAnim(form, success, type, message="") {

   const childs = document.querySelectorAll(`form[name=${type}] *`);
   const img = document.querySelector(`form[name=${type}] img`);
   const textP = document.createElement("p");

   const answers = {
      login: {
         success: "Welcome back !",
         pseudoFail: "Your pseudo and/or password are incorrect :( !"
      },
      register: {
         success: "Welcome !",
         loginFail: "This pseudo did not fit the requirements !",
         passwordFail: "The password did not fit the requirements !",
         mailFail: "The mail is not valid !",
      },
      update: {
         success: "Update successful !",
         loginFail: "This pseudo did not fit the requirements !",
         passwordFail: "The new password did not fit the requirements !",
         mailFail: "The new mail is not valid !",
      }
   };

   for (let child of childs) {
      if (child.tagName == "IMG" && type !== "update") continue;
      child.style.display = "none";
   }
   
   textP.style.color = "var(--main-white)";
   textP.style.fontSize = "1.6rem";
   form.style.transition = "1s background-color, 0.8s height, 0.8s width";
   form.style.cursor = "pointer";

   if (success) {
      form.style.backgroundColor = "var(--hard-green)";
      form.style.height = "65px";
      if (window.innerWidth > 650) form.style.width = "500px";   
      else form.style.width = "400px";   


      textP.textContent = answers[type].success;
      textP.style.animation = "fadeIn 1s ease-in forwards";
      img.style.visibility = "visible";
      img.style.animation = "wiggle 0.2s linear infinite alternate";
   }
   else {
      form.style.backgroundColor = "var(--main-red)";
      form.style.height = "100px";
      if (window.innerWidth > 650) form.style.width = "500px";   
      else form.style.width = "400px";   

      textP.style.animation = "fadeIn 1.3s linear forwards";
      textP.textContent = answers[type][`${message}Fail`];
   }
   form.addEventListener("click", () => {
      for (let child of childs) {
         form.style.backgroundColor = "";
         form.style.height = "";   
         form.style.width = "";   
         form.style.cursor = "";

         child.style.animation = "fadeIn 1.3s ease-in forwards";
         child.style.display = "";

         textP.style.display = "block";
         if (type !== "update") img.style.visibility = "hidden";
      }
      textP.remove();
   })
   form.appendChild(textP);
}
