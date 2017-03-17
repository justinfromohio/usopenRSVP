
$(document).ready(function() {
	$("#rsvp-form button").click(function(e) {
		var validated = true;
		$("#rsvp-form input, #rsvp-form select").each(function() {
			if($(this).prop('required') != 'undefined' && $(this).val() === "")
				validated = false;
		});
		// HTML5 Functions
		if (typeof $("#rsvp-form")[0].checkValidity == 'function' && !$("#rsvp-form")[0].checkValidity()) { 
			// Let HTML5 do it's thing
		}
		else if(!validated) {
			alert("Please fill in all fields.");
			// stop propigation
			return false;
		}
		else {
			$.post("reservations.php",{
				day:$('#select-date').val(),
				first:$('#firstname').val(),
				last:$('#lastname').val(),
				company:$('#company').val(),
				email:$('#email').val()
			}).done(function() {
				$("#rsvp-form").submit();
			});
			// stop propigation
			return false;
		}
	});
});

var request = $.getJSON("reservations.php").done( function (data){limitOptions( data )});
function limitOptions( result )
{
	var count=0;
	for (var key in result){
		if (result.hasOwnProperty(key)) 
		{
			if(result[key]<=0)
			{
				count++;
				//$("#select-date option[value='"+key+"']").remove();
				$("#select-date option[value='"+key+"']").attr("disabled","disabled");
			}
		}
	}
	if(count>=7)
	{
		$("#select-date").prepend("<option value='' selected='selected'>Sorry, Reservation Are Full</option>");
		onSubmit = {};//disable reservation counting
	}
}
