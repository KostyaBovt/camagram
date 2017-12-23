
<div class="register-container">
	<?php
		if (Message::exists('confirm_success')) {
			echo '<div class="register-success">';
			echo Message::get('confirm_success');
			echo '</div>';
		}

		if (Message::exists('login_failed')) {
			echo '<div class="login-failed">';
			echo Message::get('login_failed');
			echo '</div>';
		}


	?>
	<div class="register-header">
		<h1>Log in</h1>
	</div>
	<table>
		<form method="POST" action="<?php echo ROOT_PATH; ?>user/login">
			<tr>
				<td>Login</td>
				<td><input type="text" name="login" id="login"></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type="password" name="password" id="password"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="submit" id="submit" value="Login"></td>
			</tr>
		</form>
			<tr>
				<td></td>
				<td><a href="<?php echo ROOT_PATH; ?>user/forgot"><button>Forgot password?</button></a></td>
			</tr>
	</table>	
</div>
