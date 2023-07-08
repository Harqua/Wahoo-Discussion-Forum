<div class="min-vh-100 container">
    <div class="h-100 col-4 offset-4">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <section class='text-center'>
                <h1>
                    Error<br>
                </h1>
                <h2>
                    <?php if ($error === 1062) {
                        echo 'Duplicate Course. Please Try Again.';
                    } else {
                        echo 'Unknown Error. Try again later.';
                    }
                    ?>
                </h2>
                <a class="mx-4" href="<?php echo base_url(); ?>dashboard/create"> Try Again </a>
                <a class="mx-4" href="<?php echo base_url(); ?>dashboard"> Back to Main Page </a>
            </section>
            </h2>
        </div>
    </div>
</div>