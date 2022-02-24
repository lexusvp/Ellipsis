(async function main() {
   displayModule();                // Pure front && Sessions display filtering
   
   logOutEvent();
   chatModule();    
   
   formModule();                   // Main user forms handling
})();

async function logOutEvent() {
   const logoutButton = document.querySelector("#logout_button");
   const nav = document.querySelector("#main_menu");

   logoutButton.addEventListener("click", async (e) => {
      e.preventDefault();
      nav.style.animation = "fadeOut 0.3s forwards";

      const success = await queryControler("userControler", [`type=logoutUser`]);
      if (success) {
         logOut();
      }
   })
}
function logOut() {
   localStorage.removeItem("userData");
   localStorage.removeItem("target");
   location.replace("/1%20-%20Ellipsis/index.html");     
}
