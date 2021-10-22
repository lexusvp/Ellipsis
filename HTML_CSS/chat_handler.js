function open_chat() 
{
	let chat = document.getElementById("chat_container");
	chat.style.display = "block";

	window.onclick = function (event) 
	{
		if (event.target == chat) 
		{
			chat.style.opacity = "0";
		}
	}
}

function close_chat() 
{
	let chat = document.getElementById("chat_container");
	chat.style.display = "none";
}


