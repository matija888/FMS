$("document").ready(function() {
	document.querySelector("#days_5").addEventListener('change', function(event) {
		updateRegView("days_5", event.target.checked);
	});
	document.querySelector("#days_10").addEventListener('change', function(event) {
		updateRegView("days_10", event.target.checked);
	});
	document.querySelector("#days_30").addEventListener('change', function(event) {
		updateRegView("days_30", event.target.checked);
	});
	document.querySelector("#display_all").addEventListener('change', function(event) {
		updateRegView("display_all", event.target.checked);
	});

	
	
	function updateRegView(dayValue, visibility) {
		// console.log(dayValue);
		switch(dayValue) {
			case "days_5":
				period = 5;
				// console.log(period);
			break;
			case "days_10":
				period = 10;
				// console.log(period);
			break;
			case "days_30":
				period = 30;
				// console.log(period);
			break;
			case "display_all":
				period = 400;
				// console.log(period);
			break;
		}

		$.ajax({
			url: "json_vehicles.php",
			type: "GET",
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
		// console.log("ajax radi");
		var currentDate = new Date();
		var html = "";
		$("table.vehicles tbody tr").detach();

		for(var object in jsonResult) {
			var vehicle = jsonResult[object];
			
			var registration = new Date(vehicle.reg_date);
			var reg_expire = registration.addDays(365);
			//console.log(reg_expire);
			// console.log(currentDate.addDays(period));
			if(reg_expire < currentDate.addDays(period)) {
				if(reg_expire < currentDate) {
					html += "<tr style='background-color: red; color: white'>";
				} else if(reg_expire < currentDate.addDays(5)) { 
					html += "<tr style='background-color: #f09898; '>";
				} else {
					html += "<tr>";
				}
				html += "<td>"+formatDate(reg_expire)+"</td>";
				html += "<td>"+formatDate(registration)+"</td>";
				html += "<td>"+vehicle.id+"</td>";
				html += "<td>"+vehicle.reg_plate+"</td>";
				html += "<td>"+vehicle.make_name+"</td>";
				html += "<td>"+vehicle.model+"</td>";
				html += "<td>"+vehicle.engine+"</td>";
				html += "<td>"+vehicle.fuel_type+"</td>";
				html += "<td>"+vehicle.prod_year+"</td>";
				html += "<td><a href=\"show.php?vehicle_widget&id="+vehicle.id+"\"><img src=\"../images/info.png\" alt=\"\"></a></td>";
				html += "<td><a href=\"edit.php?vehicle_widget&id="+vehicle.id+"\"><img src=\"../images/edit.png\" alt=\"\"></a></td>";
				html += "<td><a href=\"delete.php?vehicle_widget&id="+vehicle.id+"\"><img src=\"../images/delete.png\" alt=\"\"></a></td>";
				html += "</tr>";
			}
			
		}
		$("table.vehicles tbody").html(html);
		
	}

	function errorFn() {
		alert("Ne radi");
	}

});