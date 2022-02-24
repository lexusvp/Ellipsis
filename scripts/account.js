/*=================================>> CHARTS  <<=================================*/

(async function main() {
   if (adminRole) {
      displayDatasets();
   }
   deleteUserEvent();

   const userPseudoSlot = document.querySelector("#user_pseudo");
   userPseudoSlot.textContent = userData.pseudo;
   userPseudoSlot.style.fontWeight = 800;
})();

function deleteUserEvent() {
   const deleteButton = document.querySelector("input[name=delete]");
   
   deleteButton.addEventListener("click", async (e) => {
      e.preventDefault();  
      if (confirm("Are you sure you want to delete your account ?")) {
         const query = await queryControler("userControler", [`type=deleteUser`]);
         if (query.success) {
            logOut();
         } 
      }
   })
}