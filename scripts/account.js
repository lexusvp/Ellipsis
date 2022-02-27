import { sessionSpecific, responsiveModule } from './modules/displayModule.js';
import { formModule, logOutEvent } from './modules/userModule.js';
import { chatModule } from './modules/chatModule.js';
import { deleteUserEvent } from './modules/userModule.js';
import { dashboardControls } from './modules/dataModule.js';

(async function main() {
   responsiveModule();
   sessionSpecific();    
   
   chatModule();
   formModule(); 

   logOutEvent();

   dashboardControls();

   deleteUserEvent();
})();
