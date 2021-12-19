const currentUser = "moi" // TODO: Find a way to define current user in the backend

function formsHandler() {
   const forms = document.forms;

   for (let i=0 ; i<forms.length ; i++) {
      const currentForm = forms[i];

      currentForm.addEventListener("submit", (e) => {
         e.preventDefault();
         const formData = document.querySelectorAll(`form[name=${currentForm.name}] input`)

         if (currentForm.name === "chat") {
            const messageHistory = [];

            if(formData[0].value !== "") {
               messageHistory.push(["moi", formData[0].value]);
               const messageLog = new Log("message", formData[0].value);
               // Info: Send to DB -> Display
   
               chatDisplay(messageHistory);
            }
         }
         else if (currentForm.name === "register") {
            const failedConstraint = registerValidation(formData);
            if (failedConstraint === "") {
               const data = {
                  id: formData[0].value,
                  email: formData[2].value
               };
               const registerLog = new Log("registerAttempt", data);
               
               // Info: Send to DB -> Confirm
               formAnim(currentForm, true, "register");
            }
            else {
               formAnim(currentForm, false, "register", failedConstraint)
            }
         }

         else if (currentForm.name === "login") {
            if (pseudoValidation(formData[0].value)) {
               const data = {
                  id: formData[0].value
               };
               const loginLog = new Log("loginAttempt", data);
   
               // Info: Send to DB -> Test -> Connect / Display
               formAnim(currentForm, true, "login");
            }
            else {
               formAnim(currentForm, false, "login", "id");            
            }
         }
      })
   }
}
function registerValidation(data) {
   for (let i=0 ; i<data.length ; i++) {
      if (data[i].name === "id") {
         if(!pseudoValidation(data[i].value)) {
            return "id";
         }
      } 
      else if (data[i].name === "password") {
         if(!passwordValidation(data[i].value)) {
            return "pass";
         } 
      }
   }
   return "";
}

//=====================>> FORM ANIMS <<======================//

function formAnim(form, success, type, message="") {

   const childs = document.querySelectorAll(`form[name=${type}] > *`);
   const container = document.querySelector(`#${type}_container`);
   const img = document.querySelector(`#${type}_container > img`);

   const textP = document.createElement("p");
   const answers = {
      login: {
         success: "Welcome back !",
         idFail: "Your pseudo and/or password are incorrect :( !"
      },
      register: {
         success: "Welcome !",
         idFail: "This pseudo did not fit the requirements !",
         passFail: "The password did not fit the requirements !",
         mailFail: "The mail is not valid !",
      }
   };

   for (let child of childs) {
      child.style.display = "none";
   }
   
   textP.style.color = "white";
   textP.style.padding = "0px";
   form.style.transition = "1s background-color, 0.8s height, 0.8s width";
   container.style.cursor = "pointer";

   if (success) {
      form.style.backgroundColor = "var(--main-green)";
      form.style.height = "45px";
      form.style.width = "500px";   
      container.style.height = "45px";
      container.style.width = "500px";

      textP.textContent = answers[type].success;
      img.style.visibility = "visible";
   }
   else {
      form.style.backgroundColor = "var(--main-red)";
      form.style.height = "100px";   
      form.style.width = "500px";   
      container.style.height = "100px";
      container.style.width = "500px";

      textP.textContent = answers[type][`${message}Fail`];
   }
   container.addEventListener("click", () => {
      for (let child of childs) {
         form.style.backgroundColor = "";
         form.style.height = "";   
         form.style.width = "";   
         container.style.height = "";
         container.style.width = "";
         container.style.cursor = "";

         child.style.animation = "fadeIn 1.2s ease-in forwards";
         child.style.display = "";

         textP.style.display = "none";
         img.style.visibility = "hidden";
      }
      textP.remove();
   })
   form.appendChild(textP);
}