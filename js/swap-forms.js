function switchForms(form1, form2) {
	$(form1).toggleClass("visible");
	$(form2).toggleClass("visible");

	let inputsForm1 = $(form1).find("input");
	let inputsForm2 = $(form2).find("input");

	// Toggle inputs
	$(inputsForm1).each(function (index, elem) {
		setInputs(elem, true);
	});

	$(inputsForm2).each(function (index, elem) {
		setInputs(elem, false);
	});

	// Focus new element on transition start
	$(form2).on('transitionstart webkitTransitionStart oTransitionStart', function () {
		$(form2).find("input")[0].focus();
	});
}

function setInputs(elem, value) {
	$(elem).attr("disabled", value);
}