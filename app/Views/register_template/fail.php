<div class="min-vh-100 container">
    <div class="col-4 offset-4">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <section class='text-center'>
                <h1>
                    Error<br>
                </h1>
                <?php if ($error === 1062) {
                    echo 'There is account with same email or username. Please try again.<br>';
                } else {
                    echo 'Unknown Error. Try again later<br>';
                }
                ?>
                <div class="mt-4">
                    <a class="mr-2" href="<?php echo base_url(); ?>register"> Try Again </a>
                    <a class="ml-2" href="<?php echo base_url(); ?>register/login"> Back to Login Page </a>
                </div>
            </section>
            </h2>
        </div>

    </div>
</div>