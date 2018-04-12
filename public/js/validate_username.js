var username = document.getElementById("username");
var pContainer = document.getElementById("ajax-error");

function ajaxSearch() {
	var xhr = new XMLHttpRequest();
	xhr.open("POST", "http://localhost/FMS/public/admins/ajax_search.php", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	// console.log(xhr);
	xhr.onreadystatechange = function() {
		if(xhr.readyState == 4 && xhr.status == 200) {

			var response = xhr.responseText;
			if(response == "false") {
				username.style.backgroundColor = '#ff6666';
				pContainer.style = "border: solid red 1px;background: white;color: red;font-weight: bold;padding:5px;";
				pContainer.innerHTML = "Korisnicko ime je zauzeto";
			} else if(username.value === '') {
				username.style.backgroundColor = '';
				pContainer.style = "";
				pContainer.innerHTML = "";
			} else {
				username.style.backgroundColor = '#00e600';
				pContainer.style = "";
				pContainer.innerHTML = "";

			}
		}
	}
	// console.log(username.value);
	xhr.send("username=" + username.value);
}

$("input").focus(function() {
	$(this).css("backgroundColor", "lightblue").focusout(function() {
		$(this).css("backgroundColor", "");
	});
});