function open_modal() 
{
	let modal = document.getElementById("modal_window");
	modal.style.display = "block";

	window.onclick = function (event) 
	{
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}
}

function close_modal() 
{
	let modal = document.getElementById("modal_window");
	modal.style.display = "none";
	
}


function open_modal2() 
{
	let modal = document.getElementById("modal_window2");
	modal.style.display = "block";

	window.onclick = function (event) 
	{
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}
}

function close_modal2() 
{
	let modal = document.getElementById("modal_window2");
	modal.style.display = "none";
	
}


