function passwordValidation(str) {
   const validationRegex = /^(?!.* )(?=.*[a-z])(?=.*[A-Z])(?=.*[?!@#$&|~°+*/%=])(?=.*[0-9]).{8}/
   return (validationRegex.test(str));
}

function pseudoValidation(str) {
   const validationRegex = /^[a-zA-Z]{4,10}[0-9]{0,3}$/;
   return (validationRegex.test(str));
}

