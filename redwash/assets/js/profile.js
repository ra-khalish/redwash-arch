$("#form-profile").submit(function(e) {
	e.preventDefault();

	var me = $(this);

	// perform ajax
	$.ajax({
		url: me.attr("action"),
		type: "post",
		data: me.serialize(),
		dataType: "json",
		success: function(response) {
			if (response.success == true) {
				// if success we would show message
				// and also remove the error class
				$("#alert").append(response.message);
				window.location = response.view;
				// $(".form-group")
				// 	.removeClass("is-invalid")
				// 	.removeClass("is-valid");
				// $(".text-danger").remove();

				// reset the form
				me[0].reset();

				// close the message after seconds
				// $(".alert-success")
				// 	.delay(500)
				// 	.show(10, function() {
				// 		$(this)
				// 			.delay(3000)
				// 			.hide(10, function() {
				// 				$(this).remove();
				// 			});
				// 	});
			} else {
				$.each(response.messages, function(key, value) {
					var element = $("#" + key);

					element
						.closest("input.form-control")
						.removeClass("is-invalid")
						.addClass(value.length > 0 ? "is-invalid" : "is-valid");
					element
						.closest("div.form-group")
						.find(".text-danger")
						.remove();

					element.after(value);
				});
			}
		}
	});
});

$("#form-chpass").submit(function(e) {
	e.preventDefault();
	var me = $(this);
	// perform ajax
	$.ajax({
		url: me.attr("action"),
		type: "post",
		data: me.serialize(),
		dataType: "json",
		success: function(response) {
			if (response.success == true) {
				// if success we would show message
				// and also remove the error class
				$("#alert").append(response.message);
				window.location = response.view;

				// reset the form
				me[0].reset();
			} else if (response.error == true) {
				$("#alert").append(response.message);
				window.location = response.view;

				// reset the form
				me[0].reset();
			} else {
				$.each(response.messages, function(key, value) {
					var element = $("#" + key);

					element
						.closest("input.form-control")
						.removeClass("is-invalid")
						.addClass(value.length > 0 ? "is-invalid" : "is-valid");
					element
						.closest("div.form-group")
						.find(".text-danger")
						.remove();

					element.after(value);
				});
			}
		}
	});
});
