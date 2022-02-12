(function main() {
   responsiveHandler();
   formHandler();
   dynamicSessions();
   
   logOutEvent();
})();

function dynamicSessions() {

   const userData = JSON.parse(localStorage.getItem("userData"));
   const nav = document.querySelector("#main_menu");
   if (userData !== null) {  
      if (userData.logged) {  
         nav.style.display = "block";
      } 
   }   
}

function logOutEvent() {
   const logoutButton = document.querySelector("#logout_button");
   const nav = document.querySelector("#main_menu");

   logoutButton.addEventListener("click", (e) => {
      e.preventDefault();

      queryControler("logoutUser");
      localStorage.removeItem("userData");
      nav.style.display = "none";

      location.reload();
   })
}
