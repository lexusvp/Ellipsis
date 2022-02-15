function chatModule() {
   displayChatWindow();
   displayChatMessages();

   displayChatContacts();
}

async function displayChatWindow() {
   const nav = document.querySelector("#main_menu") ?? null;
   if (nav === null) return;

   const chatButton = document.querySelector("#chat_button");
   const chatWindow = document.querySelector("#chat_container");
   let clicked = false;
   
   chatButton.addEventListener("click", () => {
      if(!clicked) {
         chatWindow.style.visibility = "visible";
         clicked = true;
      } else {
         chatWindow.style.visibility = "hidden";
         clicked = false;
      }
   }) 
}
async function displayChatContacts() {
   const adminTabs = document.querySelector("#chat_tabs") ?? null;
   if (adminTabs === null) return;

   const chat = document.querySelector("form[name=chat]");
   const contactButton = document.querySelector("#chat_tabs button");
   const contactList = document.querySelector("#chat_tabs ul");

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

async function displayChatMessages() {
   const chatDisplay = document.querySelector("form[name=chat] > div");
   const messageHistory = await queryControler("readMessage") ?? null;

   console.log("messageHistory : ", messageHistory);
   console.log(typeof messageHistory, messageHistory.length, Object.keys(messageHistory).length);
   if (messageHistory === null) return;

   chatDisplay.innerHTML = "";
   for (let user in messageHistory) {

      // Separer l'affichage des utilisateurs dans le cas d'un admin
      for (let message of messageHistory[`${user}`]) {
         console.log("message : ", message)

         const currentP = document.createElement("p");
         
         let messageSent = message.direction_message === "1";
         let messageReceived = message.direction_message === "0";
   
         if (messageSent) {                      // Style du message envoyé
            currentP.style.alignSelf = "flex-end";
            currentP.style.backgroundColor = "var(--main-black)";
         } else if (messageReceived) {           // Style du message reçu
            currentP.style.alignSelf = "flex-start";
            currentP.style.backgroundColor = "var(--hard-blue)";
         }
   
         currentP.style.padding = "8px";
         currentP.style.marginBottom = "6px";
         currentP.style.inlineSize = "70%";
         currentP.style.overflowWrap = "break-word";
         currentP.style.borderRadius = "0 1.125rem 0 1.125rem";
         currentP.style.boxShadow = "0rem 1rem 1rem rgba(0, 0, 0, 0.1)";
         currentP.style.color = "var(--main-white)";
         currentP.style.fontSize = "0.8rem";
   
         currentP.textContent = message.content_message;
         chatDisplay.appendChild(currentP);
      }
   }
}
