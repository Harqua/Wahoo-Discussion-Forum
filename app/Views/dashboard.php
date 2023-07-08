<div class="container min-vh-100">
	<div class="mt-3 offset-4">
		Welcome
		<?php echo $name ?>, you are logged in as
		<?php echo $usertype ?>.

	</div>

	<div class="mt-3 text-center">
		<?php
		if (!$verify) {
			echo 'Your account has not been verified yet. Please verify through your email to add more courses.';
		}
		?>
	</div>

	<div id='courseContainer' class='mt-4 d-flex flex-wrap justify-content-center'>
		<?php
		if ($courses) {
			foreach ($courses as $components) {
				echo '<div class="card ml-1 mt-1 mr-1" style="width: 18rem;"> <div class="card-body"> <h5 class="card-title">';
				echo $components['course_name'];
				echo '</h5> <h6 class="card-subtitle mb-2 text-muted">';
				echo $components['course_code'];
				echo '</h6> <a href="' . base_url() . "dashboard/course/" . $components['course_id'] . '" class="btn btn-primary">Enter</a> </div> <ul class="list-group list-group-flush"> <li class="list-group-item" style="font-size: 2vh;">Created by: ';

				if ($usertype === 'instructor') {
					echo 'You';
				} else {
					echo $components['instructor_name'];

				}
				echo '</li> <li class="list-group-item" style="font-size: 2vh;">';

				if ($usertype === 'instructor') {
					echo 'Created on: ';
				} else {
					echo 'Joined on: ';
				}

				if ($usertype === 'instructor') {
					echo $components['date_created'] . ' ' . $components['time_created'] . '</li></ul></div>';
				} else {
					echo $components['date_joined'] . '</li></ul></div>';
				}
			}
		}
		?>

		<!-- <div class="card ml-1 mr-1" style="width: 18rem;">
				<div class="card-body">
					<h5 class="card-title">Course Name</h5>
					<h6 class="card-subtitle mb-2 text-muted">Course Code</h6>
					<a href="#" class="btn btn-primary">Enter</a>
				</div>
				<ul class="list-group list-group-flush">
					<li class="list-group-item" style="font-size: 2vh;">Created by: -->
		<?php
		// if ($usertype === 'student') {
		// 	echo 'Instructor';
		// } else {
		// 	echo 'You';
		// }
		?>
		<!-- </li>
					<li class="list-group-item" style="font-size: 2vh;">Created on: Date/Time</li>
				</ul>
			</div> -->
	</div>
	<?php if ($verify) { ?>
		<div id='addCourse' class='d-flex justify-content-center'>
			<div class="card mt-2" style="width: 18rem;">
				<div class="card-body text-center">
					<?php if (session()->get('usertype') == 'student') { ?>
						<a class="btn btn-primary" href="<?php echo base_url(); ?>dashboard/join">Join Course</a>
					<?php } else { ?>
						<a class="btn btn-primary" href="<?php echo base_url(); ?>dashboard/create">Create Course</a>
					<?php } ?>
				</div>
			</div>
		</div>
	<?php } ?>

</div>