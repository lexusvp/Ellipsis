//== TODO: IMPORTANT, Check that data is correctly sent to controleur.php
//== TODO: Implement session handling, message author link handling

//== NOTE: User feedback on failures / could be great too.

async function formHandler() {
   const forms = document.forms;

   for (let i=0 ; i<forms.length ; i++) {
      const currentForm = forms[i];

      currentForm.addEventListener("submit", (e) => {
         e.preventDefault();
         const formData = document.querySelectorAll(`form[name=${currentForm.name}] input`)

         if (currentForm.name === "chat") {

            if(formData[0].value !== "") {
               const formattedMessage = new FormData(currentForm);
               
               queryControler("createMessage", formattedMessage);
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
            //== NOTE : Valider seulement les champs remplis
            console.log(formData[0].name, formData[0].value);
            // if (formData[0].name === "login" && ) {
               
            // }


            // const failedConstraint = registerValidation(formData);
            // if (failedConstraint === "") {
            //    updateAttempt(form);
            // }
            // else {
            //    formAnim(currentForm, false, "update", failedConstraint)
            // }
         }
      })
   }
}

async function registerAttempt(form) {
   const formattedFormData = new FormData(form);
   const answer = await queryControler("registerUser", formattedFormData);
   console.log("answer : ", answer)

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

      setTimeout(() => location.reload(), 1000);
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

//=====================>> FORM ANIMS <<======================//

//== Note: Possbile refactoring / improvements possible
function formAnim(form, success, type, message="") {

   const childs = document.querySelectorAll(`form[name=${type}] *`);
   const img = document.querySelector(`form[name=${type}] img`);
   const textP = document.createElement("p");

   const answers = {
      login: {
         success: "Welcome back !",
         pseudoFail: "Your pseudo and/or password are incorrect :( !"
      },
      register: {
         success: "Welcome !",
         loginFail: "This pseudo did not fit the requirements !",
         passwordFail: "The password did not fit the requirements !",
         mailFail: "The mail is not valid !",
      },
      update: {
         success: "Update successful !",
         loginFail: "This pseudo did not fit the requirements !",
         passwordFail: "The new password did not fit the requirements !",
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