import { sessionSpecific, responsiveModule } from './modules/displayModule.js';
import { formModule, logOutEvent } from './modules/userModule.js';
import { chatModule } from './modules/chatModule.js';
import { deleteUserEvent } from './modules/userModule.js'
import { displayDatasets } from './modules/dataModule.js'

(async function main() {
   responsiveModule();
   sessionSpecific();    
   
   chatModule();
   formModule(); 

   logOutEvent();

   displayDatasets();
   deleteUserEvent();
   const userData = localStorage.getItem("userData");
   const userPseudoSlot = document.querySelector("#user_pseudo");
   userPseudoSlot.textContent = userData.pseudo;
   userPseudoSlot.style.fontWeight = 800;
})();