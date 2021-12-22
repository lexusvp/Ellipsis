const testList = [
   "HTML",
   "HTML",
   "CSS",
   "Blabla",
   "Untextehasardeux",
   "Bonjour !",
   "Bonjour !",
   "Haskell",
   "WASM",
   "ASM",
   "MOBO",
   "Fonctions",
   "Virtualbox",
   "Web",
   "Yolo",
   "SQL",
   "PHP",
   "MindFuck",
   "Whatever?",
   "What?",
];
const icon = document.querySelector("input[name='search'] + button");

//== TODO: Send resulting input to server -> DB
(function suggestionHandler() {
   const suggBox = document.querySelector(".autocomplete_box");
   const inputBox = document.querySelector("input[name='search']");

   inputBox.addEventListener("input", (key) => {      
      const suggestions = filterList(inputBox.value, testList);
      for (let li of suggestions) {
         li.addEventListener("click", () => {
            inputBox.value = li.textContent;
         });
         suggBox.appendChild(li);
      }
      if(inputBox.value === "") suggBox.innerHTML = "";
   });
})();

//== BUG: With input AC -> ASM still suggested ?
function filterList(input, list) {
   let arr = [];
   arr = list.filter((data) => {
      return data.toLowerCase().startsWith(input.toLowerCase());
   });
   arr = arr.map((data) => {
      let li = document.createElement("li");
      li.textContent = data;
      return li;
   });
   return arr;
}

