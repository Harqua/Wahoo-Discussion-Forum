<html>

<head>
    <title>Wahoo Discussion Forum</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
</head>


<body class='d-flex flex-column'>
    <script>
        // Show select image using file input.
        function readURL(input) {
            $('#default_img').show();
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#select')
                        .attr('src', e.target.result)
                        .width(300)
                        .height(200);

                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">


        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="<?php #echo base_url(); ?>login/check_login"> Home </a>
                </li>
            </ul>
            <ul class="navbar-nav my-lg-0"> -->
            <a class="navbar-brand" href="<?php echo base_url(); if(session()->get('username')){echo 'dashboard';} else{echo'login';};?>">Wahoo Discussion</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        </div>
        <!-- <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form> -->
        <?php if (session()->get('username')) { ?>
            <a class="mx-4" href="<?php echo base_url(); ?>dashboard"> Home </a>
            <?php if(session()->get('usertype')==='student'){?>
                <a class="mx-4" href="<?php echo base_url(); ?>dashboard/liked-posts"> Likes </a>
            <?php }?>
            <a class="mx-4" href="<?php echo base_url(); ?>dashboard/edit-profile"> Profile </a>
            <a class="mx-4" href="<?php echo base_url(); ?>login/logout"> Logout </a>
        <?php } else { ?>
            <a class="mx-4" href="<?php echo base_url(); ?>login"> Login </a>
        <?php } ?>
    </nav>
    <div class="container">