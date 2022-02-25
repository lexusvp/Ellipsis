import { sessionSpecific, responsiveModule, modalsHandler } from './modules/displayModule.js';
import { formModule, logOutEvent } from './modules/userModule.js';
import { chatModule } from './modules/chatModule.js';
import { errorReview } from './modules/dataModule.js';

(async function main() {
   responsiveModule();
   sessionSpecific();               
   modalsHandler();

   chatModule();
   formModule(); 

   logOutEvent();

   errorReview();
})();
