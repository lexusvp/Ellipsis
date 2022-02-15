(async function main() {

   await logOut();
   displayModule();                // Pure front

   formModule();                   // Main user input handling
   chatModule();                   // Admin only
   //== TODO: Appels asynchrones récurrents pour refresh le chat, setInterval ?

})();

function logOut() {
   const nav = document.querySelector("#main_menu") ?? null;

   if (nav !== null) {
      const logoutButton = document.querySelector("#logout_button");
      logoutButton.addEventListener("click", (e) => {
         e.preventDefault();
         nav.style.animation = "fadeOut 0.3s forwards";
         logOutDisplay();
      })
   }
}
async function logOutDisplay() {
   await queryControler("logoutUser");
   localStorage.removeItem("userData");

   location.replace("/1%20-%20Ellipsis/index.php");
}
