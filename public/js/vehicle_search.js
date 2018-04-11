function ajaxSearch() {

	$.ajax({
		url: "json_vehicles.php",
		type: "POST",
		dataType: "json"
	}).done(successFn).fail(errorFn);

}
	
Date.prototype.addDays = function(days) {
	var date = new Date(this.valueOf());
	date.setDate(date.getDate() + days);
	return date;
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
	console.log(jsonResult);
	var html = "";
	for(var obj in jsonResult) {
		var vehicle = jsonResult[obj];
		var reg_plate = vehicle.reg_plate; 

		var regExp = new RegExp($("#reg_plate").val(), 'g');

		if(reg_plate.match(regExp)) {
			html += "<tr>";
			html += "<td>"+vehicle.id+"</td>";
			html += "<td>"+vehicle.reg_plate+"</td>";
			html += "<td>"+vehicle.make_name+"</td>";
			html += "<td>"+vehicle.model+"</td>";
			html += "<td>"+vehicle.engine+"</td>";
			html += "<td>"+vehicle.fuel_type+"</td>";
			html += "<td>"+vehicle.reg_date+"</td>";
			html += "<td>"+vehicle.prod_year+"</td>";
			html += "<td><a href=\"show.php?vehicle_widget&id="+vehicle.id+"\"><img src=\"../images/info.png\" alt=\"\"></a></td>";
			html += "<td><a href=\"edit.php?vehicle_widget&id="+vehicle.id+"\"><img src=\"../images/edit.png\" alt=\"\"></a></td>";
			html += "<td><a href=\"delete.php?vehicle_widget&id="+vehicle.id+"\"><img src=\"../images/delete.png\" alt=\"\"></a></td>";
			html += "</tr>";
		}

		$("table.vehicles tbody").html(html);
	}
	
}

function errorFn() {
	console.log("Ajax ne radi");
}