//== Note: PW constraints: 8 chars / 1 letter min / 1 letter maj / 1 special

//== BUG : STUPID AF TO DO THIS HERE, PUT THIS ON THE SERVER !!!!!

function passwordValidation(str) {
   const validationRegex = /^(?!.* )(?=.*[a-z])(?=.*[A-Z])(?=.*[?!@#$&|~°+*/%=])(?=.*[0-9]).{8}/
   return (validationRegex.test(str));
}
//== Note: Pseudo constraints: starts with 4 letters / Any digits then / No specials
function pseudoValidation(str) {
   const validationRegex = /^[a-zA-Z]{4,10}[0-9]{0,3}$/; 
   return (validationRegex.test(str));
}

function registerValidation(data) {
   for (let i=0 ; i<data.length ; i++) {
      if (data[i].name === "pseudo") {
         if(!pseudoValidation(data[i].value)) {
            return "pseudo";
         }
      } 
      else if (data[i].name === "password") {
         if(!passwordValidation(data[i].value)) {
            return "password";
         } 
      }
   }
   return "";
}