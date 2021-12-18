function passwordValidation(str) {
   const validationRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[?!@#$&|~°+*/%=])(?=.*[0-9]).{8}/
   
   if (validationRegex.test(str)) {
      if(!str.includes(` `)) {
         return true;
      }
   }
   return false;
}
function pseudoValidation(str) {
   const validationRegex = /^[a-zA-Z]{4,10}[0-9]{0,3}$/;
   
   if (validationRegex.test(str)) {
      return true;
   }
   return false;
}
function mailValidation(str) {
   if (str.length > 0) {
      return true;
   }
   return false;
}

function messageValidation(str) {
   if (str.length > 0) {
      return true;
   }
   return false;
}



