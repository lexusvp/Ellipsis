function chatDisplay(messageList) {
   const chatDisplay = document.querySelector("form[name=chat] > div");

   for (elements of messageList) {
      const currentP = document.createElement("p");
      currentP.style.padding = "5px";
      currentP.style.fontSize = "1rem";

      currentP.textContent = elements[1];
      chatDisplay.appendChild(currentP);
   }
}