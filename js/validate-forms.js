$(function () {

	// Check for email when typing
	// $("#registerForm #registerMail").on("input", checkEmailValidity);

	// TODO: check for password strength when typing

});

// The submit button will check if everything's ok
function checkRegisterValidity(form, email, password, bday) {
	// If the form is visible (because of the switching animation)
	if ($(form).is(".visible")) {
		// Email pattern
		// const pattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

		if (!form.checkValidity()) {
			form.reportValidity();
			return;
		}

		form.submit();
	}
}