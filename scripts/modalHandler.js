function handleModals() {
	const userEventsButtons = document.querySelectorAll(".modal_buttons"); 
	const allModals = document.querySelectorAll(".modal");
	
	// Info: open all modals
	for (let i=0 ; i<userEventsButtons.length ; i++) {
		userEventsButtons[i].addEventListener("click", () => {
			allModals[i].style.display = "block";
		})
	}
	
	// Info: close all modals
	window.onclick = (e) => {					
		for (let modal of allModals) {
			if (e.target == modal)
			{
				modal.style.display = "none";
			}
		}
	}	
}

