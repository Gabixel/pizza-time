<?php
// If the file is called directly and not included
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
	header('Location: /');
}

class UserPage
{

	public static function create_profile($user, $language)
	{
		$infos = $user->get_info();

		$age = '-';

		if (empty($infos)) {
			$infos['first_name'] = $infos['last_name'] = $infos['birth_date'] = $infos['email'] = $infos['username'] = '-';
		} else {
			// Age formatter, source: https://www.codexworld.com/how-to/calculate-age-from-date-of-birth-php
			$age = date_diff(date_create($infos['birth_date']), date_create(date('Y-m-d')));
			$age = $age->format('%y');

			// Birth date formatter
			$infos['birth_date'] = htmlentities(date("d/m/Y", strtotime($infos['birth_date'])));
		}

?>
		<div id="userProfile">
			<div id="profileTitle">
				<div class="titleBox">
					<i class="fas fa-user-circle"></i>
					<p><?php echo $language['title']; ?></p>
				</div>
				<form action="." method="POST">
					<button name="logOut" value="true" type="submit" class="logOut"><?php echo $language['log_out']; ?> <i class="fas fa-sign-out-alt"></i></button>
				</form>
			</div>
			<div id="profileBody">
				<div class="profileElementsRow row1">
					<div class="profileElement profileFirstName">
						<span class="elementTitle"><?php echo $language['first_name']; ?></span>
						<span class="elementBody"><?php echo $infos['first_name']; ?></span>
					</div>
					<div class="profileElement profileLastName">
						<span class="elementTitle"><?php echo $language['last_name']; ?></span>
						<span class="elementBody"><?php echo $infos['last_name']; ?></span>
					</div>
					<div class="profileElement profileBirthDate">
						<span class="elementTitle"><?php echo $language['birth_date']; ?></span>
						<span class="elementBody"><?php echo $infos['birth_date']; /* TODO: date format based on language */ ?></span>
					</div>
					<div class="profileElement profileAge">
						<span class="elementTitle"><?php echo $language['age']; ?></span>
						<span class="elementBody"><?php echo $age; ?></span>
					</div>
				</div>
				<div class="profileElementsRow row2">
					<div class="profileElement profileEmail">
						<span class="elementTitle"><?php echo $language['mail']; ?></span>
						<span class="elementBody"><?php echo htmlentities($infos['email']); ?></span>
					</div>
					<div class="profileElement profilePassword">
						<span class="elementTitle"><?php echo $language['password']; ?></span>
						<div class="elementBody">
							<a href="/utente/password" title="<?php echo $language['change_password']; ?>">
								<i class="fas fa-pen-square"></i><span class="password-text"><?php echo $language['change_password']; ?></span>
							</a>
						</div>
					</div>
					<div class="profileElement profileUsername">
						<span class="elementTitle"><?php echo $language['username']; ?></span>
						<span class="elementBody"><?php echo htmlentities($infos['username']); ?></span>
					</div>
				</div>
			</div>
		</div>
<?php
	}

	public static function create_order_history($user_id, $translations)
	{
	}
}
