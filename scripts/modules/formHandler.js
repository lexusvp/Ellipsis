function formsHandler() {
   const forms = document.forms;

   for (let i=0 ; i<forms.length ; i++) {
      const currentForm = forms[i];
      currentForm.addEventListener("submit", (e) => {
         e.preventDefault();
         const formData = document.querySelectorAll(`form[name=${currentForm.name}] input`)

         if (currentForm.name === "chat") {
            const message = formData[0].value;
            const messageLog = new Log("message", message);
            // Info: Send to DB -> Display
         }
         else if (currentForm.name === "register") {
            if (registerValidation(formData)) {
               const data = {
                  id: formData[0].value,
                  email: formData[2].value
               };
               const registerLog = new Log("registerAttempt", data);
               
               // Info: Send to DB -> Confirm
               formSucceeded(currentForm, "register");
            }
            else {
               // TODO : Return which field failed from server
               // formFailed(currentForm, "register");            
            }
         }
         else if (currentForm.name === "login") {
            if (loginValidation(formData)) {
               const data = {
                  id: formData[0].value
               };
               const loginLog = new Log("loginAttempt", data);
   
               // Info: Send to DB -> Test -> Connect / Display
               formSucceeded(currentForm, "login");
            }
            else {
               // TODO : Return which field failed from server
               formFailed(currentForm, "login");            
            }
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

//=====================>> FORM ANIMS <<======================//

function formSucceeded(form, type, success = true) {

   const childs = document.querySelectorAll(`form[name=${type}] > *`);
   const container = document.querySelector(`#${type}_container`);
   const img = document.querySelector(`#${type}_container > img`);

   const textP = document.createElement("p");
   const answers = {
      login: {
         successText: "Welcome back !",
         failText: "Your pseudo and/or password are incorrect :( !"
      },
      register: {
         successText: "Welcome !",
         failTextId: "This pseudo is already in use :( !",
         failTextMail: "This mail is already in use :( !",
      }
   };

   form.style.transition = "1s background-color, 0.8s height";
   for (let child of childs) {
      child.style.display = "none";
   }

   if (success && type === "login") {
      form.style.backgroundColor = "var(--main-green)";
      form.style.height = "28px";
      container.style.height = "28px";
      img.style.visibility = "visible";
      
      textP.style.padding = "0px";
      textP.textContent = answers[type].successText;
   } else if (success && type === "register") {
      form.style.backgroundColor = "var(--main-green)";
      form.style.height = "28px";   
      container.style.height = "28px";
      img.style.visibility = "visible";

      textP.style.padding = "0px";
      textP.textContent = answers[type].successText;
   }  
   else {
      if (type === "login") {
         form.style.backgroundColor = "var(--main-red)";
         form.style.height = "60px";   
         container.style.height = "60px";

         textP.style.padding = "0px";
         textP.textContent = answers[type].failText;
      }
      else {
      }
   }
   form.appendChild(textP);
}   

function formFailed(form, type) {
   return formSucceeded(form, type, success = false);
}
