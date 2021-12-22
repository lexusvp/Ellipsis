function chatDisplay(messageList) {
   const chatDisplay = document.querySelector("form[name=chat] > div");

   for (elements of messageList) {
      const currentP = document.createElement("p");
      currentP.style.padding = "5px";
      currentP.style.marginBottom = "5px";
      currentP.style.inlineSize = "334px";
      currentP.style.overflowWrap = "break-word";

      currentP.style.backgroundColor = "var(--very-light-grey)";
      currentP.style.fontSize = "0.9rem";

      currentP.textContent = elements[1];
      chatDisplay.appendChild(currentP);
   }
}