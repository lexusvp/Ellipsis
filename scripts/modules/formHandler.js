function formsHandler() {
   const forms = document.forms;

   for (let i=0 ; i<forms.length ; i++) {
      forms[i].addEventListener("submit", (e) => {
         e.preventDefault();
         const current = forms[i];

         if (current.name === "chat") {
            const message = document.querySelector("#chat_container input[type='text']").value;
            // Info: Send to DB -> Display
         }
         else if (current.name === "register" && registerValidation(current)) {
            // Info: Send to DB -> Confirm
         }
         else if (current.name === "login" && loginValidation(current)) {
            // Info: Send to DB -> Test -> Connect / Display
         }
      })
   }
}
function registerValidation(form) {
   let count = [0, 0];
   for (node of form.childNodes) {
      switch (node.name) {
         case "id":
            count[0]++;
            if(pseudoValidation(node.value)) {
               count[1]++;
            } else {
               console.log("pseudo invalide");
            }
            break;
         case "password":
            count[0]++;
            if(passwordValidation(node.value)) {
               count[1]++;
            } else {
               console.log("mdp invalide");
            }
            break;
         case "email":
            count[0]++;
            if(mailValidation(node.value)) {
               count[1]++;
            } else {
               console.log("mail invalide");
            }
            break;
         default:
            break;
      }
   }  
   return (count[0] === count[1]);
}