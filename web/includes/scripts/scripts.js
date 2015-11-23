function addRow(table) {
	var numRows = table.find('tr').length;
	var row = table.find('tr').last();
	var clone = row.clone();

	var inputs = clone.find('input');
	inputs.val('');
	inputs.each(function() {
		$(this).attr('name', $(this).attr('name').slice(0,-1)+numRows);
	});
	table.find('tr').last().after(clone);
}

function addAvailOptions() {
	var blocks = $('#block-table').find('tr');
	$('#item-data select').each(function() {
		var option = $(this);
		option.empty();
		blocks.each(function() {
			//console.log($(this).attr("name"));
			option.append($('<option></option>')
				  .attr("value",$(this).attr("name"))
				  .text($(this).attr("name")));
		});
	});
}

function updateBlockName(element) {
	var newName = element.value;
	console.log("NN: "+newName);
	element.parentElement.parentElement.setAttribute('name', newName);
	addAvailOptions();
}

function runScheduler() {
	var url = "./includes/functions/make_schedule.php";
	data = {'buttonName': 'make-schedule'};
	$.post(url, data, function(output, status) {
		$("#report").html(output);
	});
}