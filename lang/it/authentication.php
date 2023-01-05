<?php

return [
	'response_code' => [
		'failed_db_connection' => 'Impossibile inoltrare la richiesta, riprova più tardi!',

		// Register
		'max_users' => 'È stato raggiunto il limite massimo di utenti! (esiste un account di prova però. nome: \'test\', pass: \'test\')',
		'empty_string' => 'Non hai riempito tutti i campi!',
		'existing_mail' => 'Mail esistente!',
		'invalid_mail' => 'Mail non valida!',
		'existing_username' => 'Username esistente!',
		'minor' => 'Devi avere almeno 18 anni!',
		'success_register' => 'Registrato con successo!',
		// TODO: password_not_strong

		// Login
		'wrong_password' => 'Username o password non corretti!',
		'wrong_username' => 'Username o password non corretti!',

		// Logout
		'success_logout' => 'Uscito con successo!',

		// Update password
		'test_account' => 'Questo account è di prova, non puoi modificargli la password!',
		'wrong_old_password' => 'La password attuale è errata!',
		'empty_password_field' => 'Bisogna inserire una password vecchia ed una nuova!',
		'identical_password' => 'La password nuova è identica a quella attuale!',
		'success_change_password' => 'La password è stata cambiata con successo!',
	],

	'fields' => [
		'login' => [
			'title' => 'Accedi',
			'username' => 'Nome Utente',
			'password' => 'Password',
			'submit' => 'Accedi',
			'swap' => 'Oppure Registrati',
		],

		'register' => [
			'title' => 'Registrati',
			'first_name' => 'Nome',
			'last_name' => 'Cognome',
			'username' => 'Nome Utente',
			'email' => 'Email',
			'password' => 'Password',
			'birth_date' => 'Data di Nascita',
			'submit' => 'Registrati',
			'swap' => 'Oppure Accedi',
		],

		'update_password' => [
			'old_password' => 'Password Attuale',
			'new_password' => 'Nuova Password',
			'submit' => 'Invia',
		],
	],
];
