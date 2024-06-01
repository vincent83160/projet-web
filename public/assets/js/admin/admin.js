//permet d'afficher et de cacher le spinner selon l'action apssé par le paramètre
function toggleSpinner(action) {
	if (action == "show") {
		$("#spinner").show();
		$("body").css("opacity", "0.5");
	} else {
		$("#spinner").hide();
		$("body").css("opacity", "1");
		$("input, select, .btn").attr("disabled", false);
	}
}