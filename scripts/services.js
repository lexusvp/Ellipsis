import { sessionSpecific, responsiveModule, tabHandler, burgerHandler} from './modules/displayModule.js';
import { logOutEvent } from './modules/userModule.js';
import { chatModule } from './modules/chatModule.js';
import { suggestionHandler } from './modules/searchModule.js';

(async function main() {
   responsiveModule();
   sessionSpecific();    

   tabHandler();
   suggestionHandler();
   burgerHandler();

   chatModule();

   logOutEvent();
})();


