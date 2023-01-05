<?php
// If the file is called directly and not included
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
	header('Location: /');
}

class Forms
{
	public static function create_login($additionalClasses, $extra_type, $message, $translation)
	{
?><form action="/utente/login" method="POST" id="loginForm" autocomplete="on" spellcheck="false" class="loginForm <?php echo $additionalClasses; ?>">
			<?php if ($extra_type) {
				echo "<p class=\"$extra_type\">" . htmlentities($message) . "</p>\n";
			}
			?>
			<p><b><?php echo $translation['title']; ?></b></p>
			<label for="loginUsername"><?php echo $translation['username']; ?></label><input type="text" name="username" id="loginUsername" autocomplete="username email" autofocus required>
			<label for="loginPassword"><?php echo $translation['password']; ?></label><input type="password" name="password" id="loginPassword" autocomplete="current-password" required>
			<input type="hidden" name="login" value="login">
			<input type="submit" value="<?php echo $translation['submit']; ?>">
			<input type="button" value="<?php echo $translation['swap']; ?>" id="showRegisterForm" onclick="switchForms(loginForm, registerForm);">
		</form>
	<?php
	}

	public static function create_register($additionalClasses, $failed, $fail_message, $translation)
	{
	?><form action="/utente/login" method="POST" id="registerForm" autocomplete="on" spellcheck="false" class="registerForm <?php echo $additionalClasses; ?>">
			<?php if ($failed) {
				echo "<p class=\"error\">" . htmlentities($fail_message) . "</p>\n";
			}
			?>
			<p><b><?php echo $translation['title']; ?></b></p>
			<label for="registerFirstName"><?php echo $translation['first_name']; ?></label><input type="text" name="firstName" id="registerFirstName" maxlength="255" autocomplete="given-name" autofocus required>
			<label for="registerLastName"><?php echo $translation['last_name']; ?></label><input type="text" name="lastName" id="registerLastName" maxlength="255" autocomplete="family-name" required>
			<label for="registerUsername"><?php echo $translation['username']; ?></label><input type="text" name="username" id="registerUsername" maxlength="15" autocomplete="username email" required>
			<label for="registerMail"><?php echo $translation['email']; ?></label><input type="email" name="email" id="registerMail" autocomplete="email" maxlength="255" pattern="[^ ]+@[^ ]+\.[a-z]{2,3}" required>
			<label for="registerPassword"><?php echo $translation['password']; ?></label><input type="password" name="password" id="registerPassword" autocomplete="new-password" required>
			<label for="registerBirthDate"><?php echo $translation['birth_date']; ?></label><input type="date" name="birthday" id="registerBirthDate" autocomplete="bday" required>
			<input type="hidden" name="register" value="register">
			<input type="button" value="<?php echo $translation['submit']; ?>" id="registerSubmit" onclick="checkRegisterValidity(registerForm, registerMail, registerPassword, registerBirthDate);">
			<input type="button" value="<?php echo $translation['swap']; ?>" id="showLoginForm" onclick="switchForms(registerForm, loginForm);">
		</form>
	<?php
	}

	public static function create_password_change($failed, $fail_message, $translation)
	{
	?><form action="/utente/password" method="POST" autocomplete="on" spellcheck="false">
			<?php if ($failed) {
				echo "<p class=\"error\">$fail_message</p>\n";
			}
			?>
			<label for="oldPassword"><?php echo $translation['old_password']; ?></label><input type="password" name="password[]" id="oldPassword" autocomplete="current-password" required>
			<label for="newPassword"><?php echo $translation['new_password']; ?></label><input type="password" name="password[]" id="newPassword" autocomplete="new-password" required>
			<input type="submit" name="changePassword" value="<?php echo $translation['submit']; ?>">
		</form><?php
			}
		}
