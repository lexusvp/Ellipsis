function chatModule() {
   displayChatWindow();
   // refreshMessages();
}

function refreshMessages() {
   fetchMessages();
   setInterval(fetchMessages, 2500);
}

async function displayChatWindow() {   
   const chatButton = document.querySelector("#chat_button");
   const chatContext = document.querySelector("#chat_container");
   const chat = document.querySelector("form[name=chat]");
   const adminTabs = document.querySelector("#chat_tabs");
   let clicked = false;
   
   chatButton.addEventListener("click", () => {
      if(!clicked) {
         if (adminRole) {
            chat.style.display = "none";
            adminTabs.style.display = "flex";
         }

         chatContext.style.visibility = "visible";
         clicked = true;
      } else {
         if (adminTabs) {
            adminTabs.style.display = "none";
         }

         chatContext.style.visibility = "hidden";
         clicked = false;
      }
   }) 

   const backButton = document.querySelector("#chat_back") ?? null;
   if (backButton !== null) {
      backButton.addEventListener("click", () => {
         adminTabs.style.display = "flex";
         chat.style.display = "none";
      });  
   }
}
async function fetchMessages(currentUser = null) {
   const adminTabs = document.querySelector("#chat_tabs") ?? null;
   const headerName = document.querySelector("form[name=chat] #chat_name");

   const messageHistory = await queryControler("messageControler", [`type=readMessage`]);
   if (messageHistory.success !== undefined) return;

   adminTabs.innerHTML = "";
   if (!adminRole) {
      headerName.textContent = "Admin - Vazn";
      if (messageHistory.length !== 0) displayMessages(messageHistory["Admin - Vazn"]);
   }  else if (currentUser !== null){
      displayMessages(messageHistory[currentUser]);
   }  else {

      const size = Object.keys(messageHistory).length;
      if (size === 0) {
         const element = await createTab(adminTabs, null, true);
         element.textContent = "Pas de conversation en cours";
      } else {
         for (let i=0 ; i<size ; i++) {
            const user = Object.keys(messageHistory)[i];
            const userElement = createTab(adminTabs, user);
      
            userElement.addEventListener("click", () => {
               const chat = document.querySelector("form[name=chat]");
               chat.style.display = "flex";
               adminTabs.style.display = "none";
               headerName.textContent = user;
      
               displayMessages(messageHistory[user]);
            });

            const currentUser = localStorage.getItem("target");
            if (currentUser !== null) displayMessages(messageHistory[currentUser]);
         }
      }  
   }
   conversationEvent();
}
async function conversationEvent() {
   const usersDiv = Array.from(document.querySelectorAll("#tab_div"))
   for (let i=0 ; i<usersDiv.length ; i++) {
      const closeButton = Array.from(document.querySelectorAll("#tab_div svg"));

      closeButton[i].addEventListener("click", async () => {
         const user = localStorage.getItem("target");
         const closed = await queryControler("adminControler", [
            `type=closeConversation`,
            `target=${user}`
         ]);

         if (closed.success) {
            usersDiv[i].style.zIndex = "0";
            usersDiv[i].style.animation = "slideRight 1.2s forwards";
            setTimeout(() => {
               usersDiv[i].remove();
            }, 400);
         } else {
            console.error("Server couldn't close the conversation !");
         }      
      });
   }
}

function createTab(container, user, empty = false) {
   let div = document.createElement("div");
   let userElement = document.createElement("span");
   const crossIcon = 
   `
      <svg viewBox="0 0 448 448" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
         <path d="M384,0C419.3,0 448,28.65 448,64L448,384C448,419.3 419.3,448 384,448L64,448C28.65,448 0,419.3 0,384L0,64C0,28.65 28.65,0 64,0L384,0ZM143,176.1L190.1,223.1L143,271C133.7,280.4 133.7,295.6 143,304.1C152.4,314.3 167.6,314.3 176.1,304.1L223.1,257.9L271,304.1C280.4,314.3 295.6,314.3 304.1,304.1C314.3,295.6 314.3,280.4 304.1,271L257.9,223.1L304.1,176.1C314.3,167.6 314.3,152.4 304.1,143C295.6,133.7 280.4,133.7 271,143L223.1,190.1L176.1,143C167.6,133.7 152.4,133.7 143,143C133.7,152.4 133.7,167.6 143,176.1Z" style="fill-rule:nonzero;"/>
      </svg>
   `;
   
   if (!empty) div.innerHTML += crossIcon;
   if (user !== null) userElement.textContent = user;

   div.appendChild(userElement);
   div.setAttribute("id", "tab_div");
   container.appendChild(div);         
   
   div.addEventListener("mouseenter", () => {
      localStorage.setItem("target", user);
   });

   return userElement;
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