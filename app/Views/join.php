<div class="min-vh-100 container">
	<div class="col-4 offset-4 mt-5">
		<h2 class="text-center">Join Course</h2>
		<div class="form-group mt-4">
			<input id="search" type="text" class="form-control" placeholder="Search Course ID"
				onkeyup='filterCourse(this.value)' name="searchcourse">
		</div>
	</div>
	<div id="result">
	</div>
</div>

<script>
	function filterCourse(val) {
		var xhttp;
		if (val.length == 0) {
			document.getElementById("search").innerHTML = '';
			document.getElementById("result").innerHTML = "";
			return;
		}
		xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if(this.readyState == 4 && this.status==200){
				var res = JSON.parse(this.responseText);
				var course_html_code = "<div id='courseContainer' class='mt-4 d-flex flex-wrap justify-content-center'>";
				for(course_info of res){
					course_html_code += '<div class="card ml-1 mt-1 mr-1" style="width: 18rem;"> <div class="card-body"> <h5 class="card-title">';
					course_html_code += course_info["course_name"];
					course_html_code += '</h5> <h6 class="card-subtitle mb-2 text-muted">';
					course_html_code += course_info['course_code'];
					course_html_code += '</h6> <a href="/wahoo/dashboard/join?course='+course_info["course_id"]+'" class="btn btn-primary">Join</a> </div></div>';
					
				}
				course_html_code += '</div>';
				document.getElementById('result').innerHTML = course_html_code;
				
			}
		};
		xhttp.open("GET",'/wahoo/dashboard/join/search?course='+val.toUpperCase(),true);
		xhttp.send();
	}
</script>