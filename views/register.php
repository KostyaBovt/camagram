<div class="register-container">
	<?php 
		if (Message::exists('register_errors')) {
			$register_errors = Message::get('register_errors');
			echo '<div class="register-errors">';
			
			foreach ($register_errors as $register_error) {
				echo '<div class="register-error">';
				echo $register_error;
				echo '</div>';	
			}
			
			echo '</div>';
		}

		if (Message::exists('register_success')) {
			echo '<div class="register-success">';
			echo Message::get('register_success');
			echo '</div>';
		}
	?>
	
	<div class="register-header">
		<h1>Registration</h1>
	</div>
	<table>
		<form method="POST" action="<?php echo ROOT_PATH; ?>user/register">
			<tr>
				<td>Login</td>
				<td><input type="text" name="login" id="login"></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type="password" name="password" id="password"></td>
			</tr>
			<tr>
				<td>Repeat Password</td>
				<td><input type="password" name="repeat_password" id="repeat_password"></td>
			</tr>
			<tr>
				<td>Name</td>
				<td><input type="text" name="name" id="name"></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><input type="text" name="email" id="email"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="submit" id="submit" value="Register"></td>
			</tr>
		</form>
	</table>	
</div>
