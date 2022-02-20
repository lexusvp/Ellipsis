(function main() {
   if (logged) {
      logOut();
      chatModule();                     
      //== TODO: Appels asynchrones récurrents pour refresh le chat, setInterval ?
   }

   displayModule();                // Pure front && Sessions display filtering
   formModule();                   // Main user input handling
})();

async function logOut() {
   const logoutButton = document.querySelector("#logout_button");
   const nav = document.querySelector("#main_menu");

   logoutButton.addEventListener("click", async (e) => {
      e.preventDefault();
      nav.style.animation = "fadeOut 0.3s forwards";

      await queryControler("logoutUser");
      localStorage.removeItem("userData");
      localStorage.removeItem("target");
      
      location.replace("/1%20-%20Ellipsis/index.php");
   })
}
