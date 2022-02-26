import { sessionSpecific, responsiveModule, modalsHandler } from './modules/displayModule.js';
import { formModule, logOutEvent } from './modules/userModule.js';
import { chatModule } from './modules/chatModule.js';
import { errorReview } from './modules/dataModule.js';
import { homeAnim } from './modules/homeAnim.js';

(async function main() {
   responsiveModule();
   sessionSpecific();  
   homeAnim();

   modalsHandler();

   chatModule();
   formModule(); 

   logOutEvent();

   errorReview();
})();


