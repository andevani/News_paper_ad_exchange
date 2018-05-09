<link type="text/css" href="jquery-date/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="jquery-date/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="jquery-date/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript">

	$p = jQuery.noConflict();
	$p(function() {
		$p( "#txtbdate" ).datepicker({
			showOn: "button",
			buttonImage: "jquery-date/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "dd-mm-yy",
			showAnim: "slideDown"
		});
	});
</script>