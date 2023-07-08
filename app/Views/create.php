<div class="min-vh-100 container">
	<div class="col-4 offset-4 mt-5">
		<?php echo form_open(base_url() . 'dashboard/create/create_status'); ?>
		<h2 class="text-center">Create Course</h2>
		<div class="form-group">
			<input type="text" class="form-control" placeholder="Course Code" maxlength="8" required="required" name="coursecode">
		</div>
        <div class="form-group">
			<input type="text" class="form-control" placeholder="Course Name" maxlength='100' required="required" name="coursename">
		</div>
		<div class="form-group">
			<?php echo $error; ?>
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary btn-block">Create</button>
        </div>
		<?php echo form_close(); ?>
	</div>
</div>