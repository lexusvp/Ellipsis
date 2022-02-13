(function main() {

   displayModule();                // Pure front
   formModule();                   // Main user input handling
   chatModule();                   // Admin only
   //== TODO: Appels asynchrones récurrents pour refresh le chat, setInterval ?

   logOutEvent();
})();

function logOutEvent() {
   const logoutButton = document.querySelector("#logout_button");
   const nav = document.querySelector("#main_menu");

   logoutButton.addEventListener("click", (e) => {
      e.preventDefault();

      queryControler("logoutUser");
      localStorage.removeItem("userData");

      nav.style.animation = "fadeOut 0.3s forwards";
      location.replace("/1%20-%20Ellipsis/index.php");
   })
}
