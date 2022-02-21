const userData = JSON.parse(localStorage.getItem("userData")) ?? null;
let logged;
let adminRole;
if (userData !== null) {
   logged = userData["logged"] ?? null;
   adminRole = userData["admin"] ?? null;
}

function displayModule() {
   sessionSpecific();
   initialState();
   dynamicState();
}

//=====================>> RESPONSIVENESS <<======================//

function sessionSpecific() {
   const adminSpecific = document.querySelectorAll(".admin_specific");
   const loggedSpecific = document.querySelectorAll(".logged_specific");
   const unloggedSpecific = document.querySelectorAll(".unlogged_specific");

   if (logged) {
      for (let element of loggedSpecific) element.style.visibility = "visible";
      for (let element of unloggedSpecific) element.style.visibility = "hidden";
   }
   if (adminRole) {
      for (let element of adminSpecific) element.style.display = "flex";
   }
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
   
   const links = Array.from(document.querySelectorAll("#main_menu li > a, #main_menu li > button"));
   const accountButton = document.querySelector("#account_button");
   const logoutButton = document.querySelector("#logout_button");

   const iconsPaths = [
      `
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 45 42" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
         <path id='home_icon' d="M43.63,18.673L36.905,11.948L36.905,4.179C36.905,2.775 35.766,1.636 34.36,1.636C32.956,1.636 31.818,2.775 31.818,4.179L31.818,6.861L26.81,1.854C24.335,-0.621 20.03,-0.616 17.56,1.858L0.744,18.673C-0.248,19.668 -0.248,21.277 0.744,22.27C1.738,23.265 3.35,23.265 4.343,22.27L21.157,5.455C21.705,4.91 22.67,4.91 23.215,5.453L40.032,22.27C40.53,22.768 41.18,23.015 41.83,23.015C42.482,23.015 43.133,22.767 43.63,22.27C44.623,21.277 44.623,19.668 43.63,18.673ZM23.071,10.282C22.582,9.794 21.791,9.794 21.304,10.282L6.513,25.069C6.28,25.302 6.147,25.621 6.147,25.953L6.147,36.738C6.147,39.269 8.199,41.321 10.73,41.321L18.053,41.321L18.053,29.98L26.32,29.98L26.32,41.321L33.643,41.321C36.174,41.321 38.226,39.269 38.226,36.738L38.226,25.953C38.226,25.621 38.095,25.302 37.86,25.069L23.071,10.282Z" style="fill-rule:nonzero;"/>
      </svg>
      `, 
      `
      <svg viewBox="0 0 44 37" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;">
         <path d="M9.557,10.146L2,18.202L9.57,26.189M33.683,26.211L41.235,18.149L33.661,10.168M26.036,2L17.245,34.321" style="fill:none;stroke-width:4px;"/>
      </svg>
      `, 
      `                         
      <svg viewBox="0 0 36 36" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;">
         <path d="M17.757,1.5C26.73,1.5 34.014,8.741 34.014,17.66C34.014,26.58 26.73,33.821 17.757,33.821C8.785,33.821 1.5,26.58 1.5,17.66C1.5,8.741 8.785,1.5 17.757,1.5ZM17.84,9.24C20.326,9.24 22.344,11.246 22.344,13.717C22.344,16.189 20.326,18.195 17.84,18.195C15.354,18.195 13.336,16.189 13.336,13.717C13.336,11.246 15.354,9.24 17.84,9.24ZM6.902,29.301C9.353,25.68 12.276,23.953 14.055,24.008L22.344,24.008C24.254,24.144 27.291,26.703 28.663,29.641" style="fill:none;stroke-width:3px;"/>
      </svg>
      `, 
      `
      <svg viewBox="0 0 41 36" version="1.1" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;">
         <path d="M11.29,13.841C12.729,13.841 13.896,15.009 13.896,16.447C13.896,17.886 12.729,19.054 11.29,19.054C9.852,19.054 8.684,17.886 8.684,16.447C8.684,15.009 9.852,13.841 11.29,13.841ZM20.212,13.841C21.651,13.841 22.819,15.009 22.819,16.447C22.819,17.886 21.651,19.054 20.212,19.054C18.774,19.054 17.606,17.886 17.606,16.447C17.606,15.009 18.774,13.841 20.212,13.841ZM29.204,13.841C30.643,13.841 31.81,15.009 31.81,16.447C31.81,17.886 30.643,19.054 29.204,19.054C27.766,19.054 26.598,17.886 26.598,16.447C26.598,15.009 27.766,13.841 29.204,13.841Z" style="stroke-opacity:0;stroke-width:5px;"/>
         <path d="M21.186,1.508C31.165,1.758 39.001,8.648 38.933,16.413C38.8,22.785 34.237,27.892 27.016,30.303C24.427,30.923 18.965,32.455 12.467,29.72C8.591,32.764 5.017,33.99 1.678,33.802C3.99,30.193 4.082,30.224 5.913,26.071C-0.069,20.659 0.007,11.384 6.287,6.226C10.415,2.834 15.917,1.378 21.186,1.508Z" style="fill:none;stroke-width:3px;"/>
      </svg>
      `, 
      `                        
      <svg viewBox="0 -1 39 36" version="1.1" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;">
         <path d="M12.672,2L7.607,2C4.574,2 2.112,4.451 2.097,7.483C2.07,13.225 2.027,22.19 2,27.935C1.993,29.389 2.566,30.785 3.591,31.816C4.617,32.846 6.011,33.425 7.464,33.425L12.473,33.425M13.556,17.822L36.833,17.822L26.484,7.439M13.556,17.822L36.833,17.822L26.484,28.206" style="fill:none;stroke-width:4px;"/>
      </svg>
      `
   ];
   
   if (size === "small") {
      accountButton.style.right = "";
      accountButton.style.width = "60px";
      logoutButton.style.right = "136px";
      logoutButton.style.width = "60px";
      for (let i=0 ; i<links.length ; i++) {
         links[i].style.padding = "11px 15px 11px 15px ";
         links[i].textContent = "";
         links[i].innerHTML = iconsPaths[i];
      }
   }
   if (size === "big") {
      accountButton.style.right = "";
      accountButton.style.width = "";
      logoutButton.style.right = "";
      logoutButton.style.width = "";
      const names = ["Home", "Services", "Account", "Chat", "Log Out"];
      for (let i=0 ; i<links.length ; i++) {
         links[i].style.padding = "";
         links[i].innerHTML = "";      
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
