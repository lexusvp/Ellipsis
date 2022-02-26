export { queryControler };

async function queryControler(controler, args, data = null) {
   const url = buildUrl(controler, args);
   let answer = null;
   console.log(url);   
   
   try {
      const response = await fetch
      (
         url, {
            method: 'POST',
            body: data
      });  
      answer = await response.json();     
      console.log("answer : ", answer)
   } catch (e) {
      console.error(e);
      return null;
   }

   return answer;
} 

function buildUrl(controler, args) {
   const array = Object.keys(args).map((key) => [(`${key}=${args[key]}`)]);
   let url = `http://localhost/1%20-%20Ellipsis/php/controlers/${controler}.php?`; 
   //== REMINDER: Build URL
   for (let i = 0 ; i<array.length ; i++) {
      if (i === 0) {
         url += array[i];
      } else {
         url += "&" + array[i];
      }
   }
   return url;
}