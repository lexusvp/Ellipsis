async function queryControler(type, data = null, sec = "") {
   
   const response = await fetch
      (
         `../../1%20-%20Ellipsis/php/controler.php?type=${type}${sec}`, {
         method: 'POST',
         body: data
      });
   const answer = await response.json() ?? null;                       // Récupére le JSON retourné   

   return answer;
} 