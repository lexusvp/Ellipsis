(async function main() {
   displayModule();                // Pure front && Sessions display filtering
  
   if (logged) {
      logOut();
      chatModule();                     
      //== TODO: Appels asynchrones récurrents pour refresh le chat, setInterval ?
   }
   formModule();                   // Main user input handling

   const errors = await queryControler([
      `type=getData`,
      `target=allErrors`
   ]);
   if (errors !== null) console.table("Errors : ", errors);
})();

async function logOut() {
   const logoutButton = document.querySelector("#logout_button");
   const nav = document.querySelector("#main_menu");

   logoutButton.addEventListener("click", async (e) => {
      e.preventDefault();
      nav.style.animation = "fadeOut 0.3s forwards";

      await queryControler([`type=logoutUser`]);
      localStorage.removeItem("userData");
      localStorage.removeItem("target");
      
      location.replace("/1%20-%20Ellipsis/index.html");
   })
}
