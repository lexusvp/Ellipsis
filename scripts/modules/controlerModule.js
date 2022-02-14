async function queryControler(type, data = null) {

   const response = await fetch
      (
         `../../1%20-%20Ellipsis/php/controler.php?type=${type}`, {
         method: 'POST',
         body: data
      });

   const answer = await response.json() ?? null;                       // Récupére le JSON retourné   
   console.log("answer : ", answer);

   return answer;
} 