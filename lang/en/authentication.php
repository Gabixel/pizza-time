<?php

return [
	'response_code' => [
		'failed_db_connection' => 'Unable to do the request, try again later!',
		
		// Register
		'max_users' => 'The max users number has been reached! (there\'s a test account. name: \'test\', pass: \'test\')',
		'empty_string' => 'You didn\'t fill every field!',
		'existing_mail' => 'Existing mail!',
		'invalid_mail' => 'Invalid mail!',
		'existing_username' => 'Existing username!',
		'minor' => 'You must be at least 18 years old!',
		'success_register' => 'Successfully logged in!',

		// Login
		'wrong_password' => 'Wrong username/password!',
		'wrong_username' => 'Wrong username/password!',

		// Logout
		'success_logout' => 'Successfully logged out!',

		// Update password
		'test_account' => 'This is a test account, you can\' change its password!',
		'wrong_old_password' => 'Current password is wrong!',
		'empty_password_field' => 'You have to enter both the current and the new password!',
		'identical_password' => 'The new password is the same as the current one!',
		'success_change_password' => 'Successfully changed password!',
	],

	'fields' => [
		'login' => [
			'title' => 'Login',
			'username' => 'Username',
			'password' => 'Password',
			'submit' => 'Login',
			'swap' => 'Register instead',
		],

		'register' => [
			'title' => 'Register',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'username' => 'Username',
			'email' => 'Email',
			'password' => 'Password',
			'birth_date' => 'Birth Date',
			'submit' => 'Register',
			'swap' => 'Login instead',
		],

		'update_password' => [
			'old_password' => 'Current Password',
			'new_password' => 'New Password',
			'submit' => 'Send',
		],
	],
];
