//== TODO: Implement session handling, message author link handling

//== NOTE: User feedback on failures / could be great too.

async function formModule() {
   const forms = document.forms;

   for (let i=0 ; i<forms.length ; i++) {
      const currentForm = forms[i];

      currentForm.addEventListener("submit", (e) => {
         e.preventDefault();
         const formData = document.querySelectorAll(`form[name=${currentForm.name}] input`)

         if (currentForm.name === "chat") {
            if(formData[0].value !== "") {
               sendMessageAttempt(currentForm);
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
         }
      })
   }
}

async function registerAttempt(form) {
   const formattedFormData = new FormData(form);
   const answer = await queryControler("registerUser", formattedFormData);

   if (answer.check_success) {
      formAnim(form, true, "register");
   } else {
      formAnim(form, false, "register");
   }
}
async function loginAttempt(form) {
   const formattedFormData = new FormData(form);
   const answer = await queryControler("loginUser", formattedFormData);

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
   const answer = await queryControler("update", formattedFormData);

   if (answer.check_success) {
      formAnim(currentForm, true, "update");
   } else {
      //== TODO: User Feedback on failed constraints
   }
}
async function sendMessageAttempt(form) {
   const formattedMessage = new FormData(form);
   const admin = await queryControler("authorize");

   if (admin) {
      await queryControler("createMessage", formattedMessage, pseudoCibléParClicOnglet);
   } else {
      await queryControler("createMessage", formattedMessage);
   }

   displayChatMessages();
}