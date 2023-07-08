<div class="min-vh-100 container">

    <div class="mt-3 text-center h2">
        <?php
        echo $course_info['course_name'];
        echo ' (' . $course_info['course_code'] . ')';
        ?>
    </div>


    <div class='mt-3 text-center'>
        <a class="btn btn-info"
            href="<?php echo base_url(); ?>dashboard/course/<?php echo $course_info['course_id']; ?>/create_post">New
            Post</a>
    </div>

    <div class='mt-3 text-center'>
        Show:
        <button id="trendButton" onclick="toggleTrending()"
            class="ml-1 mr-1 btn btn-outline-warning active">Trending</button>
        <button id="instButton" onclick="toggleInstructor()"
            class="ml-1 mr-1 btn btn-outline-primary active">Instructor</button>
        <button id="studButton" onclick="toggleStudent()"
            class="ml-1 mr-1 btn btn-outline-success active">Student</button>
    </div>

    <div id='trendPost' class='mt-4'>
        <div class="h4 text-center mt-2">
            Trending Posts:
        </div>
        <!-- <div class="mt-1 d-flex flex-wrap justify-content-center"> -->
        <?php
        if ($trend_model) {
            echo $trend_posts;

        } else {
            echo '<div class="mt-1 mb-5 d-flex flex-wrap justify-content-center">No trending post</div';
        }
        ?>
    </div>

    <div id='instPost' class='mt-4'>
        <div class="h4 text-center mt-2">
            Instructor Posts:
        </div>
        <!-- <div class="mt-1 d-flex flex-wrap justify-content-center"> -->
        <?php
        if ($inst_model) {
            echo $inst_posts;

        } else {
            echo '<div class="mt-1 mb-5 d-flex flex-wrap justify-content-center">No post by instructor</div';
        }
        ?>

    </div>

    <div id='studPost' class='mt-4 mb-4'>
        <div class="h4 text-center mt-2">
            Student Posts:
        </div>
        <!-- <div class="mt-1 mb-5 d-flex flex-wrap justify-content-center"> -->
            <?php

            if ($stu_model) {
                echo $stu_posts;

            } else {
                echo '<div class="mt-1 mb-5 d-flex flex-wrap justify-content-center">No post by students</div';
            }
            ?>
        </div>
    </div>
</div>
<script>
    function toggleTrending() {
        const trend = document.getElementById("trendPost");
        const button = document.getElementById("trendButton");
        if (trend.style.display === "none") {
            trend.style.display = "block";
            button.classList.add("active");

        } else {
            trend.style.display = "none";
            button.classList.remove("active");
        }
    }

    function toggleInstructor() {
        const inst = document.getElementById("instPost");
        const button = document.getElementById("instButton");
        if (inst.style.display === "none") {
            inst.style.display = "block";
            button.classList.add("active");
        } else {
            inst.style.display = "none";
            button.classList.remove("active");
        }
    }
    function toggleStudent() {
        const stud = document.getElementById("studPost");
        const button = document.getElementById("studButton");
        if (stud.style.display === "none") {
            stud.style.display = "block";
            button.classList.add("active");
        } else {
            stud.style.display = "none";
            button.classList.remove("active");
        }
    }

</script>