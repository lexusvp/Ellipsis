export { queryControler };

async function queryControler(controler, args, data = null) {
   const url = buildUrl(controler, args);
   let answer = null;
   
   try {
      const response = await fetch
      (
         url, {
            method: 'POST',
            body: data
      });  
      answer = await response.json();     
   } catch (e) {
      console.error(e);
      return null;
   }

   return answer;
} 

function buildUrl(controler, args) {
   let url = `http://localhost/1%20-%20Ellipsis/php/controlers/${controler}.php?`; 

   for (let key in args) {
      if (key === "type") {
         url += `${key}=${args[key]}`;
      } else if (key === "target[]") {
         for (let target of args[key]) {
            url += `&${key}=${target}`;
         }
      }  else {
         url +=  `&${key}=${args[key]}`;
      }   
   }
   return url;
}