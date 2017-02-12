var tableIndex = 0;

function addRow(t) {
	var table = $("body").find(t);
	var numRows = table.find('tr').length;
	var row = table.find('tr').last();
	var clone = row.clone();

	var inputs = clone.find('input');
	inputs.val('');
	inputs.each(function() {
		//console.log($(this));
		$(this).attr('name', $(this).attr('name').slice(0,-1)+numRows);
	});
	var tds = clone.find('td');
	tds.each(function() {
		if ($(this).attr('id') !== undefined) {
			//console.log($(this));
			$(this).attr('id', $(this).attr('id').slice(0,-1)+numRows);
		}
	});
	var col = clone.find('td').first().html(numRows);
	table.find('tr').last().after(clone);
}

function addAvailOptions() {
	var url = "./includes/functions/get_blocks.php";
	$.post(url, function(output, status) {
		var blocks = JSON.parse(output);
		console.log(blocks);
		console.log(blocks[0].BLOCK_NAME);
		console.log(blocks[0].BLOCK_DATE);
		for (var i = 0; i < blocks.length; i++) {
			$("#item-block-name"+(i+1)).html(blocks[i].BLOCK_NAME);
			var f_time = moment(blocks[i].BLOCK_TIME, 'HH:mm:ss').format('h:mm A');
			var d = new Date(blocks[i].BLOCK_DATE.toString() + " " + f_time)
			console.log(blocks[i].BLOCK_TIME.toString());
			console.log(d);
			$("#item-block-date"+(i+1)).html((d.getMonth()+1) + "/" + (d.getDate()) + "/" + d.getFullYear());
			$("#item-block-time"+(i+1)).html(f_time);
			if (i < blocks.length-1) {
				addRow($("#survey-table"));
			}
		}
	});
}

function addAvailEvents() {
	var url = "./includes/functions/get_events.php";
	console.log("in add availEvents");
	$.post(url, function(output, status) {
		var events = JSON.parse(output);
		console.log(events);
		for (var i = 0; i < events.length; i++) {
			$("#manage-table-event-" + i).html(events[i].EVENT_NAME);
			$("#manage-table-responses-" + i).html(events[i].NUM_ROWS);
			if (i < events.length-1) {
				var clone = $("#manage-table").find('tr').last().clone();
				var tds = clone.find('td');
				tds.each(function() {
					if ($(this).attr('id') !== undefined) {
						$(this).attr('id', $(this).attr('id').slice(0,-1)+(i+1));
					}
				});
				$("#manage-table").find('tr').last().after(clone);
			}
		}
	});
}

function cycleTable(shift) {
	var tables = $("body").find("table");
	if (tableIndex + shift < 0) {
		return;
	}
	else if ((tableIndex + shift) < tables.length) {
		tableIndex += shift;
		for (var i = 0; i < tables.length; i++) {
			tables[i].style.display = "none";
		}
		tables[tableIndex].style.display = "";
	}
	else {
		// get last table
		var table = $(tables[tableIndex]);
		var clone = table.clone();
		var cloneRows = clone.find('tr.block-data');
		// number of rows per table * number of tables
		var numRows = cloneRows.length * tables.length;
		
		tableIndex += shift;
		
		cloneRows.each(function(r, row) {
			var inputs = $(row).find('input, select');
			inputs.val('');
			var newIndex = numRows + r + 1;
			inputs.each(function(index, input) {
				$(this).attr('name', $(this).attr('name').slice(0,-1) + newIndex);
				$(this).attr('id', $(this).attr('id').slice(0,-1) + newIndex);
				//$(this).attr('placeholder', $(this).attr('placeholder').slice(0,-1) + newIndex);
			});
			var selects = $(row).find('select');
			selects.each(function(index, select) {
				var options = $(select).find('option');
				options.each(function(index) {
					$(this).attr('selected','selected');
				});
			});
		});
		var tds = clone.find('td');
		tds.each(function(index) {
			if ($(this).attr('id') !== undefined) {
				$(this).attr('id', $(this).attr('id').slice(0,-1) + (numRows + index + 1));
			}
		});
		$("body").find('table').last().after(clone);
		var rows = clone.find('tr.block-data');
		for (var i = 0; i < rows.length; i++) {
			$(rows[i]).find('td').first().html(numRows + i + 1);
		}
		for (var i = 0; i < tables.length; i++) {
			tables[i].style.display = "none";
		}
	}
}

function updateBlockName(element) {
	var newName = element.value;
	//console.log("NN: "+newName);
	element.parentElement.parentElement.setAttribute('name', newName);
	//addAvailOptions();
}

function openOverlay(btn) {
	$(".overlay").attr("hidden", false);
	$(".overlay").css("display", "block");
	$("body").css("overflow", "hidden");
	var eventRow = $(btn).parent().attr('id').slice(-1);
	var url = "./includes/functions/get_items.php";
	data = {'eventRow': eventRow};
	$.post(url, data, function(output, status) {
		var rows = JSON.parse(output);
		var numRows = rows.length;
		$("#manage-response-name-0").html(rows[0]["ITEM_NAME"]);
		for (var i = 1; i < numRows; i++) {
			addRow($("#manage-response-table"));
			$("#manage-response-name-"+i).html(rows[i]["ITEM_NAME"]);
		}
	})
}

function closeOverlay() {
	$(".overlay").attr("hidden", true);
	$(".overlay").css("display", "none");
	$("body").attr("overflow", false);
	$("#manage-response-table").empty();
	var firstLine = '<tr id="manage-response-row-0"><td>1</td><td id="manage-response-name-0">Name</td><td id="manage-response-delete-0"><button type="button" onclick="deleteItem()">delete</button></td></tr>';
	$("#manage-response-table").append(firstLine);
}

function openEventPage(link) {
	var eventRow = $(link).parent().attr('id').slice(-1);
	document.location.href = "admin.php?row="+eventRow;
}

function populateEventPage() {
	var eventRow = location.search.substring(1).split("=")[1];
	//var eventRow = $(link).parent().attr('id').slice(-1);
	//document.location.href = "admin.php?row="+eventRow;
	console.log("EventROW: "+ eventRow);
	var url = "./includes/functions/edit_event.php";
	data = {'editRow': eventRow};
	$.post(url, data, function(output, status) {
		console.log(output);
		var blocks = JSON.parse(output);
		console.log(blocks);
		for (var i = 0; i < blocks.length; i++) {
			if (typeof blocks[i] != 'object') {
				break;
			}
			if (i!=0 && i%5==0) {
				cycleTable(1);
			}
			var date = blocks[i]["BLOCK_DATE"].split("-");
			$("#block-year"+(i+1)).val(date[0]);
			$("#block-month"+(i+1)).val(date[1]);
			$("#block-day"+(i+1)).val(date[2]);
			
			var time = blocks[i]["BLOCK_TIME"].split(":");
			$("#block-hour"+(i+1)).val(time[0]);
			$("#block-minute"+(i+1)).val(time[1]);
			
			$("#block-name"+(i+1)).val(blocks[i]["BLOCK_NAME"]);
			$("#block-slots"+(i+1)).val(blocks[i]["BLOCK_NUM_SLOTS"]);
		}
		$(".event-title").html(blocks[blocks.length-1]);
	});
}

function deleteEvent(link) {
	var eventRow = $(link).parent().attr('id').slice(-1);
	var eventName = $("#manage-table-event-"+eventRow).html();
	if (confirm("Delete "+eventName+"?")) {
		var url = "./includes/functions/delete_event.php";
		data = {'eventRow': eventRow};
		$.post(url, data, function(output, status) {
		});
		window.location.reload();
	}
}

function deleteItem(btn) {
	var itemRow = $(btn).parent().attr('id').slice(-1);
	var itemName = $("#manage-response-name-"+itemRow).html();
	if (confirm("Delete "+itemName+"?")) {
		var url = "./includes/functions/delete_item.php";
		data = {'itemRow': itemRow};
		$.post(url, data, function(output, status) {
		});
		window.location.reload();
	}
}

function runScheduler(btn) {
	var eventRow = $(btn).parent().attr('id').slice(-1);
	var url = "./includes/functions/make_schedule.php";
	data = {'eventRow': eventRow};
	//$.post(url, data, function(output, status) {
		//$("#report").html(output);
	//});
	window.location="./includes/functions/make_schedule.php?row="+eventRow;
}