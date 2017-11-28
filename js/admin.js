window.onload = function(){

		var table = document.getElementById("openOrders");
		var tableClosed = document.getElementById("closedOrders");
		var closedOrders = document.getElementById("closed");
		var openOrders = document.getElementById("order");
		var message = document.getElementById("message");
		var messageButton = document.getElementById("messageButton");



		table.style.display = "none";
		tableClosed.style.display = "none";
		message.style.display = "none";

		closedOrders.addEventListener("click", hideShow);
		openOrders.addEventListener("click", hideShow);
		messageButton.addEventListener("click", hideShow);

		function hideShow(){
			if(this.id == "order"){
				if (table.style.display == "none" && message.style.display == "none"){
					table.style.display = "block";
				}
				else if (table.style.display == "none" && message.style.display != "none"){
					message.style.display = "none"
					table.style.display = "block";
				}
				else{
					table.style.display = "none";
				}
			}

			else if (this.id == "closed"){
				if (tableClosed.style.display == "none" && message.style.display == "none"){
					tableClosed.style.display = "block";
				}
				else if(tableClosed.style.display = "none" && message.style.display != "none"){
					message.style.display = "none"
					tableClosed.style.display = "block";
				}
				else{
					tableClosed.style.display = "none"
				}
			}

			else{
				if (message.style.display == "none" && tableClosed.style.display == "none" && table.style.display == "none"){
					message.style.display = "block";
				}
				else if(message.style.display == "none" && tableClosed.style.display != "none" || table.style.display != "none"){
					table.style.display = "none";
		tableClosed.style.display = "none";
		message.style.display = "block";
				}
				else{
					message.style.display = "none";
				}
			}
		}


		var url_string = window.location.href; //window.location.href
		var url = new URL(url_string);
		var lastOpen = url.searchParams.get("open");
		var lastClosed = url.searchParams.get("closed");
		var messageBlock = url.searchParams.get("block");
		
		if(messageBlock){
			message.style.display = "block";
		}

		
		if(lastClosed=="block"){
			tableClosed.style.display = "block";
		}
		if(lastOpen=="block"){
			table.style.display = "block";
		}



		$(".openOrder").click(function() {
    			var $item = $(this).closest("tr").find(".orderid").text();         // Retrieves the text within <td>
				window.location = "openorder.php?value=" + $item +"&closed=" + tableClosed.style.display + "&open=" + table.style.display;
			});


			$(".sendOrder").click(function() {
    			var $item = $(this).closest("tr").find(".orderid").text();         // Retrieves the text within <td>
				window.location = "sendorder.php?value=" + $item +"&closed=" + tableClosed.style.display + "&open=" + table.style.display;
			});
};