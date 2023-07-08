<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
	integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<style>
	form i {
		margin-left: -4vh;
		margin-top: 2vh;
		cursor: pointer;
	}
</style>
<div class="container">
	<div class="h-100 col-4 offset-4 mt-5">
		<?php echo form_open(base_url() . 'login/check_login'); ?>
		<h2 class="text-center">Login</h2>
		<div class="form-group">
			<input type="text" class="form-control" placeholder="Username" required="required" name="username">
		</div>
		<div class="form-group d-flex">
			<input type="password" id='password' class="form-control" placeholder="Password" required="required"
				name="password">
			<i class="bi bi-eye-slash align-item-center" id="togglePassword"></i>
		</div>
		<div class="form-group d-flex justify-content-between">
			Log in as:
			<section>
				<input type="radio" id="student" name="usertype" value="student" checked>
				<label for="student">Student</label>
			</section>
			<section>
				<input type="radio" id="instructor" name="usertype" value="instructor">
				<label for="instructor">Instructor</label>
			</section>
		</div>
		<div class="clearfix">
			<label class="float-left form-check-label"><input type="checkbox" name="remember"> Remember me</label>
			<div class='float-right'><?php echo anchor(base_url() . 'forgot_password', 'Forgot Password?') ?></div>
		</div>
		<div class="mt-2 form-group">
			<?php echo $error; ?>
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary btn-block">Log in</button>
			<section class='text-center'>
				or<br>
				<?php echo anchor(base_url() . 'register', 'Register Now') ?>
			</section>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>

<script>
	const togglePassword = document
		.querySelector('#togglePassword');

	const password = document.querySelector('#password');

	togglePassword.addEventListener('click', () => {

		// Toggle the type attribute using
		// getAttribute() method
		const type = password
			.getAttribute('type') === 'password' ?
			'text' : 'password';

		password.setAttribute('type', type);
	});
</script>

<!-- Reference:
- Toggle Password visibility: https://www.geeksforgeeks.org/how-to-toggle-password-visibility-in-forms-using-bootstrap-icons/

-->