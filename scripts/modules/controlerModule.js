async function queryControler(type, data = null, sec = "") {
   let url = `../../1%20-%20Ellipsis/php/controler.php?type=${type}`;
   if (sec !== "") url += `&target=${sec}`;

   const response = await fetch
      (
         url, {
         method: 'POST',
         body: data
      });

   const answer = await response.json() ?? null;                       // Récupére le JSON retourné   
   return answer;
} 