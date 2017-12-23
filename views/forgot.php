<div class="register-container" id="register-container-forgot">
	<?php 
		if (Message::exists('forgot_fail')) {			
			echo '<div class="register-error">';
			echo Message::get('forgot_fail');
			echo '</div>';	
		}

		if (Message::exists('forgot_success')) {
			echo '<div class="register-success">';
			echo Message::get('forgot_success');
			echo '</div>';
		}
	?>
	<div class="register-header">
		<h1>Reset password</h1>
	</div>
	<form method="POST" action="<?php echo ROOT_PATH; ?>user/forgot">
		<table>
			<tr>
				<td>Email</td>
				<td><input type="text" name="email" id="email"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="submit" id="submit" value="Reset password"></td>
			</tr>

		</table>
	</form>	
</div>
