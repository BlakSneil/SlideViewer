$(document).ready(function() {
	$('#member_color').change();
});

$('#member_color').change(function() {
	$(this).removeClass();

	$(this).addClass('form-control background-' + $(this).find(':selected').text());
});