var today = new Date(
	new Date().getFullYear(),
	new Date().getMonth(),
	new Date().getDate()
);
$("#startDate").datepicker({
	uiLibrary: "bootstrap4",
	iconsLibrary: "fontawesome",
	format: "yyyy-mm-dd",
	maxDate: function() {
		return $("#endDate").val();
	}
});
$("#endDate").datepicker({
	uiLibrary: "bootstrap4",
	iconsLibrary: "fontawesome",
	format: "yyyy-mm-dd",
	minDate: function() {
		return $("#startDate").val();
	}
});
