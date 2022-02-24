//== NOTE: User feedback on failures / could be great too.

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
   const answer = await queryControler("userControler", [`type=registerUser`], formattedFormData);

   if (answer.success) {
      formAnim(form, true, "register");
   } else {

      //Feedback
      formAnim(form, false, "register");
   }
}
async function loginAttempt(form) {
   const formattedFormData = new FormData(form);
   const answer = await queryControler("userControler", [`type=loginUser`], formattedFormData);
   console.log("answer : ", answer);

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
   const answer = await queryControler("userControler", [`type=updateUser`], formattedFormData);

   // if (answer.check_success) {
   //    formAnim(currentForm, true, "update");
   // } else {
   //    //== TODO: User Feedback on failed constraints
   // }
}

async function sendMessageAttempt(form) {
   const formattedMessage = new FormData(form);

   if (adminRole) {
      const target = localStorage.getItem("target");
      await queryControler("messageControler", [
         `type=createMessage`,
         `target=${target}`
      ], formattedMessage);

      fetchMessages(target);
   } else {
      await queryControler("messageControler", [`type=createMessage`], formattedMessage);
      
      fetchMessages();
   }

}