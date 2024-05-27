function toggleSpinner(action) {
	if (action == "show") {
		$("#spinner").show();
		$("body").css("opacity", "0.5");
	} else {
		$("#spinner").hide();
		$("body").css("opacity", "1");
		$("input, select, .btn").attr("disabled", false);
	}
    console.log("toggleSpinner: " + action);
}