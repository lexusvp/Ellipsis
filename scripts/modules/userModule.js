import { queryControler } from './controlerModule.js';
import { fetchMessages } from './chatModule.js';
import { formAnim } from './displayModule.js';

export { formModule, logOutEvent, logOut, deleteUserEvent, admin, logged };

function formModule() {
   const forms = document.forms;

   for (let i=0 ; i<forms.length ; i++) {
      const currentForm = forms[i];

      currentForm.addEventListener("submit", (e) => {
         e.preventDefault();
         const formData = document.querySelectorAll(`form[name=${currentForm.name}] input`)
         
         if (currentForm.name === "chat") {
            if(formData[0].value !== "") {
               
               sendMessageAttempt(currentForm);
               formData[0].value = "";
            }
         }
         else if (currentForm.name === "register") {
            const failedConstraint = registerValidation(formData);
            if (failedConstraint === "") {
               registerAttempt(currentForm);
            }
            else {
               formAnim(currentForm, false, "register", failedConstraint)
            }
         }
         else if (currentForm.name === "login") {
            loginAttempt(currentForm);            
         }
         else if (currentForm.name === "update") {
            updateAttempt(currentForm)
         }
      })
   }
}

async function registerAttempt(form) {
   const formattedFormData = new FormData(form);
   const answer = await queryControler("userControler", { type: "registerUser"}, formattedFormData);

   if (answer.success) {
      formAnim(form, true, "register");
   } else {

      //Feedback
      formAnim(form, false, "register");
   }
}
async function loginAttempt(form) {
   const formattedFormData = new FormData(form);
   const answer = await queryControler("userControler", { type: "loginUser"}, formattedFormData);

   if (answer.logged) { 
      localStorage.setItem("userData", JSON.stringify(answer));
      formAnim(form, true, "login");

      setTimeout(() => location.reload(), 1150);
   } else {
      formAnim(form, false, "login");
   }
}
async function updateAttempt(form) {
   const formattedFormData = new FormData(form);
   const answer = await queryControler("userControler", { type: "updateUser"}, formattedFormData);

   // if (answer.check_success) {
   //    formAnim(currentForm, true, "update");
   // } else {
   //    //== TODO: User Feedback on failed constraints
   // }
}

async function sendMessageAttempt(form) {
   const formattedMessage = new FormData(form);

   if (admin()) {
      const target = localStorage.getItem("target");
      await queryControler("messageControler", {
         type: "createMessage",
         target: target,
      }, formattedMessage);

      fetchMessages(target);
   } else {
      await queryControler("messageControler", { type: "createMessage" }, formattedMessage);
      
      fetchMessages();
   }
}

async function logOutEvent() {
   const logoutButton = document.querySelector("#logout_button");
   const nav = document.querySelector("#main_menu");

   logoutButton.addEventListener("click", async (e) => {
      e.preventDefault();
      nav.style.animation = "fadeOut 0.3s forwards";

      const success = await queryControler("userControler", { type: "logoutUser" });
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
function deleteUserEvent() {
   const deleteButton = document.querySelector("input[name=delete]");
   
   deleteButton.addEventListener("click", async (e) => {
      e.preventDefault();  
      if (confirm("Are you sure you want to delete your account ?")) {
         const query = await queryControler("userControler", { type: "deleteUser" });
         if (query.success) {
            logOut();
         } 
      }
   })
}
function logged() {
   const userData = JSON.parse(localStorage.getItem("userData")) ?? null;
   if (userData !== null) {
      const logged = userData["logged"];
      return logged;
   }
   return false;  
}
function admin() {
   const userData = JSON.parse(localStorage.getItem("userData")) ?? null;
   if (userData !== null) {
      const logged = userData["admin"];
      return logged;
   }
   return false;  
}
 
