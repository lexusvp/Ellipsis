//== TODO: IMPORTANT, Check that data is correctly sent to queryHandler.php
//== TODO: Implement session handling, message author link handling

//== NOTE: User feedback on failures / could be great too.

function formsHandler() {
   const forms = document.forms;

   for (let i=0 ; i<forms.length ; i++) {
      const currentForm = forms[i];

      currentForm.addEventListener("submit", function submitEvent(e) {
         e.preventDefault();
         const formData = document.querySelectorAll(`form[name=${currentForm.name}] input`)

         if (currentForm.name === "chat") {

            if(formData[0].value !== "") {
               const message = document.querySelector("input[type=textarea]");
               const formattedMessage = ["PSEUDO-OF-USER", message];
               queryDatabase("createMessage", formattedMessage);

               const messageLog = new Log("message", formData[0].value);
               queryDatabase("createLog", messageLog);
   
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
               const formattedFormData = new FormData(currentForm);
               queryDatabase("createUser", formattedFormData);

               const registerLog = new Log("registerAttempt", data);
               queryDatabase("createLog", registerLog);

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
               const formattedFormData = new FormData(currentForm);
               queryDatabase("checkUser", formattedFormData);

               const loginLog = new Log("loginAttempt", data);
               queryDatabase("createLog", loginLog);

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
               const formattedFormData = new FormData(currentForm);
               queryDatabase("updateUser", formattedFormData);

               const updateLog = new Log("updateAttempt", data);
               queryDatabase("createLog", updateLog);

               formAnim(currentForm, true, "update");
            }
            else {
               formAnim(currentForm, false, "update", failedConstraint)
            }
         }
      })
   }
}

//=====================>> QUERY HANDLING <<======================//

async function queryDatabase(type, data) {
   const response = await fetch                    //== REMINDER: BOTH POST && GET
   (
      `../../back/queryModules.php?type=${type}`, {      
      method: 'POST',
      body: data
   });

   switch(type) {
      case "createUser":
         console.log("Query sent to DB");
         break;
      case "checkUser":
         console.log("Query sent to DB");
         break;
      case "updateUser":
         console.log("Query sent to DB");
         break;

      case "createMessage":
         console.log("Query sent to DB");
         break;
      case "createLog":
         console.log("Query sent to DB");
         break;
      default:
         console.log("What the f*** are you doing ?!");
         break;
   }
   return response;
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
      textP.style.animation = "fadeIn 1s ease-in forwards";
      img.style.visibility = "visible";
      img.style.animation = "wiggle 0.2s linear infinite alternate";
   }
   else {
      form.style.backgroundColor = "var(--main-red)";
      form.style.height = "100px";
      if (window.innerWidth > 650) form.style.width = "500px";   
      else form.style.width = "400px";   

      textP.style.animation = "fadeIn 1.3s linear forwards";
      textP.textContent = answers[type][`${message}Fail`];
   }
   form.addEventListener("click", () => {
      for (let child of childs) {
         form.style.backgroundColor = "";
         form.style.height = "";   
         form.style.width = "";   
         form.style.cursor = "";

         child.style.animation = "fadeIn 1.3s ease-in forwards";
         child.style.display = "";

         textP.style.display = "block";
         if (type !== "update") img.style.visibility = "hidden";
      }
      textP.remove();
   })
   form.appendChild(textP);
}