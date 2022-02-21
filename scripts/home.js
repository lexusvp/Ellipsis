(async function home() {
	logoAnim();
	modalsHandler();
	
	const errors = await queryControler("getData", "errors");
	console.table("errors : ", errors);
})();


function modalsHandler() {
	const userEventsButtons = document.querySelectorAll(".modal_buttons"); 
	const allModals = document.querySelectorAll(".modal");
	
	//== Info: open any modal
	for (let i=0 ; i<userEventsButtons.length ; i++) {
		userEventsButtons[i].addEventListener("click", () => {
			allModals[i].style.visibility = "visible";
			allModals[i].style.opacity = "100";
		})
	}
	
	//== Info: close any modal
	window.addEventListener("mousedown", (e) => {					
		for (let modal of allModals) {
			if (e.target === modal) {
				modal.style.opacity = '0';
				modal.style.visibility = 'hidden';
			}
		}
	})
}
function logoAnim() {
   const path = document.querySelectorAll(".path");
   
   for (let p of path) {
      p.style.strokeDasharray = p.getTotalLength();
      p.style.strokeDashoffset = p.getTotalLength();
   }
   
   anime({
      targets: path,
      easing: "linear",
      strokeDashoffset: 0,
      duration: 1500,
   });
}