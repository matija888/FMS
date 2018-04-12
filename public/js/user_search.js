var first_name = $("#first_name");
// var pContainer = $("ajax-error");

function ajaxSearch() {
	$.ajax({
		url: "admins/ajax_search.php",
		type: "POST",
		data: "first_name=" + first_name.val(),
		dataType: "json"
	}).done(successFn).fail(errorFn);
	
	function successFn(jsonResult) {
		html = "";
		admin_id = jsonResult.admin_id;
		admin_status = jsonResult.admin_status;

		var usersArray = jsonResult.user;
		
		// console.log(usersArray);
		
		if(usersArray !== 'undefined' || usersArray.length !== 0) {
			displayUser(usersArray);
		} else {
			$("article").html(html);
		}
	}

	function displayUser(usersArray) {
		
		for(var user in usersArray) {

			var user = usersArray[user];
			// console.log(user);
			html += "<div class=\"element\">";
			if(admin_status == 2 && admin_id !== user.id) {
				console.log(admin_id);
				console.log(user.id);
				html += "<a href=\"delete.php?admins-widget&id="+user.id+"\">";
				html += "<img id=\"delete\" src=\"images/delete.png\" alt=\"\"></a>";
			}

			
			if(admin_status == 2) {
				html += "<a href=\"edit.php?admins-widget&id="+user.id+"\">";
				html += "<img id=\"edit\" src=\"images/edit.png\" alt=\"\"></a>";
			}

			html += "<a href=\"show.php?admins-widget&id="+user.id+"\">";
			html += "<img id=\"user_info\" src=\"images/info.png\" alt=\"\"></a>";

			html += "";
			html += "<img src=\"images/admins/"+user.id+".jpg\" alt=\"\">";
			html += "<div id=\"tabela\"><table class=\"user\"><tr><td>Korisnicko ime:</td>";
			html += "<td>"+user.first_name+"</td>";
			html += "</tr><tr><td>Ime i prezime:</td>";
			html += "<td>"+user.last_name+"</td>";
			html += "</tr><tr><td>Pozicija:</td>";
			html += "<td>"+user.position_name+"</td>";
			html += "</tr><tr><td>Email:</td>";
			html += "<td>"+user.email+"</td>";
			html += "</tr><tr><td>Status:</td>";
			html += "<td>"+user.status+" / ";
			html += user.status == 1 ? "Admin" : "Superadmin"
			html += "</td></table></div></div>";
		}

		$("article").html(html);
	}

	function errorFn() {
		console.log("Ajax ne radi");
	}
}