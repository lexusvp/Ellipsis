async function queryControler(args, data = null) {
   let url = `http://localhost/1%20-%20Ellipsis/php/controler.php?`;
   
   //== REMINDER: Build URL
   for (let i = 0 ; i<args.length ; i++) {
      if (i === 0) {
         url += args[i];
      } else {
         url += "&" + args[i];
      }
   }  
   console.log("url : ", url);

   const response = await fetch
      (
      url, {
         method: 'POST',
         body: data
      });

   const answer = await response.json() ?? null;                         
   return answer;
} 