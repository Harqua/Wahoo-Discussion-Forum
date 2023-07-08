<div class="min-vh-100 container">
    <div class="col-4 offset-4">
        <?php echo form_open(base_url() . 'forgot_password/check_email'); ?>
        <h2 class="text-center mt-5">Account Recovery</h2>
        <div class="form-group text-center">
            Please enter your email address below
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Enter your Email Address" required="required" name="email">
        </div>
        <div class="form-group d-flex justify-content-between">
			Email Recovery for:
			<section>
				<input type="radio" id="student" name="usertype" value="student">
				<label for="student">Student</label>
			</section>
			<section>
				<input type="radio" id="instructor" name="usertype" value="instructor">
				<label for="instructor">Instructor</label>
			</section>
		</div>
        <?php echo $error; ?>
        <?php echo $success; ?>
        <div class="form-group">
			<button type="submit" class="btn btn-primary btn-block">Submit</button>
		</div>
        <?php echo form_close(); ?>
    </div>
</div>