function formsHandler() {
   const forms = document.forms;

   for (let i=0 ; i<forms.length ; i++) {
      forms[i].addEventListener("submit", (e) => {
         e.preventDefault();
         const currentForm = forms[i];
         const formData = document.querySelectorAll(`form[name=${currentForm.name}] input`)

         if (currentForm.name === "chat") {
            const message = formData[0].value;
            const messageLog = new Log("message", message);
            // Info: Send to DB -> Display
         }
         else if (currentForm.name === "register" && registerValidation(formData)) {
            const data = {
               id: formData[0].value,
               email: formData[2].value
            };
            const registerLog = new Log("registerAttempt", data);

            // Info: Send to DB -> Confirm
         }
         else if (currentForm.name === "login" && loginValidation(formData)) {
            const data = {
               id: formData[0].value
            };
            const loginLog = new Log("loginAttempt", data);

            // Info: Send to DB -> Test -> Connect / Display
         }
      })
   }
}
function registerValidation(data) {
   let count = 0;
   for (let i=0 ; i<data.length ; i++) {
      switch(data[i].name) {  
         case "id":
            if(pseudoValidation(data[i].value)) {
               count++;
            } else {
               console.log("pseudo invalide");
            }
            break;
         case "password":
            if(passwordValidation(data[i].value)) {
               count++;
            } else {
               console.log("mdp invalide");
            }
            break;
         case "email":
            if(mailValidation(data[i].value)) {
               count++;
            } else {
               console.log("mail invalide");
            }
            break;
         default:
            break;
      }
   }
   return count === 3;
}
function loginValidation(data) {
   const id = data[0].value;
   if (pseudoValidation(id)) {
      return true;
   }  else {
      console.log("pseudo invalide");
      return false;
   }
}