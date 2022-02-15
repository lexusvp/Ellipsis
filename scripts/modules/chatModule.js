function chatModule() {
   displayChatWindow();
   displayChatMessages();
}

async function displayChatWindow() {
   const nav = document.querySelector("#main_menu") ?? null;
   if (nav === null) return;
   
   const chatButton = document.querySelector("#chat_button");
   const chatContext = document.querySelector("#chat_container");
   const chat = document.querySelector("form[name=chat]");
   let clicked = false;
   
   const adminTabs = document.querySelector("#chat_tabs") ?? null;

   chatButton.addEventListener("click", () => {
      if(!clicked) {
         if (adminTabs !== null) {
            chat.style.display = "none";
            adminTabs.style.display = "flex";
         }

         chatContext.style.visibility = "visible";
         clicked = true;
      } else {
         if (adminTabs !== null) {
            adminTabs.style.display = "none";
         }

         chatContext.style.visibility = "hidden";
         clicked = false;
      }
   }) 

   const backButton = document.querySelector("#chat_back");
   backButton.addEventListener("click", () => {
      adminTabs.style.display = "flex";
      chat.style.display = "none";
   });

   const avatar = document.querySelector("#avatar");
   avatar.addEventListener("mouseover", () => {
      avatar.style.color = "black"
      console.log("test");
   });
}

//== TODO: To improve
async function displayChatMessages() {
   const adminTabs = document.querySelector("#chat_tabs") ?? null;
   const messageHistory = await queryControler("readMessage") ?? null;
   
   if (messageHistory === null) return;
   
   if (adminTabs === null) {
      const headerName = document.querySelector("form[name=chat] #chat_header");
      headerName.textContent = "Admin - Vazn";

      displayMessages(messageHistory["Admin"]);
   }  else {
      for (let user in messageHistory) {
         let userElement = document.createElement("span");
         userElement.textContent = user;
         userElement.style.fontSize = "0.9rem";
         userElement.style.color = "var(--main-white)";
         adminTabs.appendChild(userElement);
   
         userElement.addEventListener("click", () => {
            const chat = document.querySelector("form[name=chat]");
            const headerName = document.querySelector("form[name=chat] #chat_header");
            chat.style.display = "flex";
            adminTabs.style.display = "none";
            headerName.textContent = user;

            displayMessages(messageHistory[user]);
         })
      }
   }
}

function displayMessages(data) {
   const chatDisplay = document.querySelector("form[name=chat] > div");
   chatDisplay.innerHTML = "";

   for (let message of data) {
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