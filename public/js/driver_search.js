function ajaxSearch() {

	$.ajax({
		url: "drivers/json_drivers.php",
		type: "POST",
		dataType: "json"
	}).done(successFn).fail(errorFn);

}

function formatDate(date) {
	var day = date.getDate();
	var month = date.getMonth() + 1;

	day = day.toString();
	month = month.toString();
	
	(day.length != 2) ? (day = "0" + day) : false;
	(month.length != 2) ? (month = "0" + month) : false;

	return day + '-' + month + '-' +  date.getFullYear();
}

function successFn(jsonResult) {
	
	var html = "";
	for(var obj in jsonResult) {
		var driver = jsonResult[obj];
		var first_name = driver.first_name.toLowerCase(); 
		//console.log(driver);
		var regExp = new RegExp('^' + $("#first_name").val().toLowerCase(), 'g');

		if(first_name.match(regExp)) {
			html += "<tr>";
			html += "<td>"+driver.id+"</td>";
			html += "<td>"+driver.first_name + " "+ driver.last_name +"</td>";
			html += "<td>"+driver.position_name+"</td>";
			html += "<td>"+driver.reg_plate+"</td>";
			html += "<td><a href=\"drivers/show.php?drivers-widget&id="+driver.id+"\"><img src=\"images/info.png\" alt=\"\"></a></td>";
			html += "<td><a href=\"drivers/edit.php?drivers-widget&id="+driver.id+"\"><img src=\"images/edit.png\" alt=\"\"></a></td>";
			html += "<td><a href=\"drivers/delete.php?drivers-widget&id="+driver.id+"\"><img src=\"images/delete.png\" alt=\"\"></a></td>";
			html += "</tr>";
		}

		$("table.user tbody").html(html);
	}
	
}

function errorFn() {
	console.log("Ajax ne radi");
}