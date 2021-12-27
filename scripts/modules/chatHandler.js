(function chatHandler() {
   displayChatWindow();
   displayChatContacts();
})();

function displayChatWindow() {
   const chatButton = document.querySelector("#chat_button");
   const chatWindow = document.querySelector("#chat_container");
   let clicked = false;
   
   chatButton.addEventListener("click", () => {
      if(!clicked) {
         chatWindow.style.visibility = "visible";
         clicked = true;
         return true;
      } else {
         chatWindow.style.visibility = "hidden";
         clicked = false;
         return false;
      }
   })
}
function displayChatContacts() {
   const contactButton = document.querySelector("#chat_container > aside > button");
   const contactList = document.querySelector("#chat_container > aside > ul");
   let clicked = false;
   
   contactButton.addEventListener("click", (e) => {
      if(!clicked) {
         contactList.style.display = "block";
         clicked = true;
      }  else {
         contactList.style.display = "none";
         clicked = false;
      }
   });   
}
function displayChatMessages(messageList) {
   const chatDisplay = document.querySelector("form[name=chat] > div");

   for (elements of messageList) {
      const currentP = document.createElement("p");
      currentP.style.padding = "8px";
      currentP.style.marginBottom = "6px";
      currentP.style.inlineSize = "70%";
      currentP.style.overflowWrap = "break-word";
      currentP.style.borderRadius = "0 1.125rem 0 1.125rem"; // User messages
      // currentP.style.borderRadius = "1.125rem 1.125rem 1.125rem 0"; // Admin messages
      currentP.style.alignSelf = "flex-end"; // Right messages
      currentP.style.boxShadow = "0rem 1rem 1rem rgba(0, 0, 0, 0.1)"; // Right messages

      currentP.style.backgroundColor = "var(--main-black)";
      currentP.style.color = "var(--main-white)";
      currentP.style.fontSize = "0.8rem";

      currentP.textContent = elements[1];
      chatDisplay.appendChild(currentP);
   }
}