//== TODO: Find a way to define current user in the backend

function formsHandler() {
   const forms = document.forms;

   for (let i=0 ; i<forms.length ; i++) {
      const currentForm = forms[i];

      currentForm.addEventListener("submit", function submitEvent(e) {
         e.preventDefault();
         const formData = document.querySelectorAll(`form[name=${currentForm.name}] input`)

         if (currentForm.name === "chat") {
            const messageHistory = [];

            if(formData[0].value !== "") {
               const message = document.querySelector("input[type=textarea]")
               messageHistory.push(["moi", message.value]);

               const messageLog = new Log("message", formData[0].value);
               //== Info: Send to DB -> Display
   
               console.log("submit ok")
               displayChatMessages(messageHistory);
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
               
               //== Info: Send to DB -> Confirm
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
   
               //== Info: Send to DB -> Test -> Connect / Display
               formAnim(currentForm, true, "login");
            }
            else {
               formAnim(currentForm, false, "login", "id");            
            }
         }
         else if (currentForm.name === "update") {
            const failedConstraint = registerValidation(formData);
            if (failedConstraint === "") {
               const data = {
                  id: formData[0].value,
                  email: formData[2].value
               };
               const updateLog = new Log("updateAttempt", data);
               
               //== Info: Send to DB -> Confirm
               formAnim(currentForm, true, "update");
            }
            else {
               formAnim(currentForm, false, "update", failedConstraint)
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

//== Note: Possbile refactoring / improvements possible
function formAnim(form, success, type, message="") {

   const childs = document.querySelectorAll(`form[name=${type}] *`);
   const img = document.querySelector(`form[name=${type}] img`);
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
      },
      update: {
         success: "Update successful !",
         idFail: "This pseudo did not fit the requirements !",
         passFail: "The new password did not fit the requirements !",
         mailFail: "The new mail is not valid !",
      }
   };

   for (let child of childs) {
      if (child.tagName == "IMG" && type !== "update") continue;
      child.style.display = "none";
   }
   
   textP.style.color = "var(--main-white)";
   textP.style.fontSize = "1.6rem";
   form.style.transition = "1s background-color, 0.8s height, 0.8s width";
   form.style.cursor = "pointer";

   if (success) {
      form.style.backgroundColor = "var(--hard-green)";
      form.style.height = "65px";
      if (window.innerWidth > 650) form.style.width = "500px";   
      else form.style.width = "400px";   


      textP.textContent = answers[type].success;
      img.style.visibility = "visible";
      img.style.animation = "wiggle 0.2s linear infinite alternate";
   }
   else {
      form.style.backgroundColor = "var(--main-red)";
      form.style.height = "100px";
      if (window.innerWidth > 650) form.style.width = "500px";   
      else form.style.width = "400px";   

      textP.textContent = answers[type][`${message}Fail`];
   }
   form.addEventListener("click", () => {
      for (let child of childs) {
         form.style.backgroundColor = "";
         form.style.height = "";   
         form.style.width = "";   
         form.style.cursor = "";

         child.style.animation = "fadeIn 1.5s ease-in forwards";
         child.style.display = "";

         textP.style.display = "block";
         if (type !== "update") img.style.visibility = "hidden";
      }
      textP.remove();
   })
   form.appendChild(textP);
}