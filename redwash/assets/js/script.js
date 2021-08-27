// $("#bologna-list a").on("click", function(e) {
// 	e.preventDefault();
// 	$(this).tab("show");
// });

function caltotal() {
	var cost = 0;
	var sel = document.getElementById("typemotor");
	$("#typemotor option:selected").each(function () {
		cost = parseInt($(this).val());
		type = sel.options[sel.selectedIndex].text;
		console.log(type);
		console.log(cost);
	});
	$("input[name=tot_cost]").val(cost);
	$("input[name=motor_type]").val(type);
}

$().ready(function () {
	$("#typemotor").change(function () {
		caltotal();
	});
});

$("#myTab a").on("click", function (e) {
	e.preventDefault();
	$(this).tab("show");
});
