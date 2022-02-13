function chatModule() {
   displayChatWindow();

   const userData = localStorage.getItem("userData") ?? null;
   if (userData !== null) {
      displayChatContacts();
   }
}

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
async function displayChatContacts() {
   const admin = await queryControler("authorize");

   const adminZone = document.querySelector("#chat_container > aside");
   const contactButton = document.querySelector("#chat_container > aside > button");
   const contactList = document.querySelector("#chat_container > aside > ul");
   let clicked = false;
   
   if (admin) {
      contactButton.addEventListener("click", (e) => {
         if(!clicked) {
            contactList.style.display = "block";
            clicked = true;
         }  else {
            contactList.style.display = "none";
            clicked = false;
         }
      });      
   } else {
      adminZone.remove();
   }
}

async function displayChatMessages() {
   const chatDisplay = document.querySelector("form[name=chat] > div");
   const admin = await queryControler("authorize");
   const messageHistory = await queryControler("readMessage");

   chatDisplay.innerHTML = "";
   for (elements of messageHistory) {
      const currentP = document.createElement("p");

      // if admin ==>> Change la direction des message ==>> Envoyé devient reçu et inversement }
      const messageSent = elements.direction_message === "1";
      const messageReceived = elements.direction_message === "0";

      if (messageSent) {                      // Style du message envoyé
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
      } else if (messageReceived) {           // Style du message reçu
         currentP.style.padding = "8px";
         currentP.style.marginBottom = "6px";
         currentP.style.inlineSize = "70%";
         currentP.style.overflowWrap = "break-word";
         currentP.style.borderRadius = "0 1.125rem 0 1.125rem"; // User messages
         // currentP.style.borderRadius = "1.125rem 1.125rem 1.125rem 0"; // Admin messages
         currentP.style.alignSelf = "flex-start"; // Left messages ??
         currentP.style.boxShadow = "0rem 1rem 1rem rgba(0, 0, 0, 0.1)"; // Right messages
   
         currentP.style.backgroundColor = "var(--light-grey)";
         currentP.style.color = "var(--main-white)";
         currentP.style.fontSize = "0.8rem";
      }

      currentP.textContent = elements.content_message;
      chatDisplay.appendChild(currentP);
   }
}
