<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<div class="min-vh-100 container">

    <div class='mt-3 text-center'>
        <a class="h4" href="<?php echo base_url(); ?>dashboard/course/<?php echo $course_id; ?>">Back</a>
    </div>


    <div class="d-flex justify-content-center">
        <div class="card border-w mt-3" style="width: 85vw;">
            <div class="card-body">
                <div class="card-subtitle mb-1 text-muted h6">
                    <?php echo $post_author; ?>
                </div>
                <div class="card-title h2">
                    <?php echo $post_info['title']; ?>
                </div>
                <div class="card-subtitle mb-1 text-muted h6">
                    <?php echo 'Posted on: ' . $post_info['date_posted'] . ' ' . $post_info['time_posted']; ?>
                </div>
                <p class="card-text mt-4">
                    <?php echo $post_info['content'] ?>
                </p>


                <?php
                if ($post_info['filename']) {
                    echo '<p><img style="max-width:50vh; max-height:50vh;" src="'.base_url().'/writable/uploads/' . $post_info['filename'] . '" alt="'.$post_info['filename'].'"></p>';
                }
                ?>

            </div>
        </div>
    </div>


    <div class='mt-3'>
        <div class='h4 ml-3'>
            Replies
        </div>
        <?php
        if (!($endorsed_reply || $unendorsed_reply)) {
            echo '<div class="ml-3"> No reply </div>';
        } else {
            if ($endorsed_reply) {
                echo $endorsed_html;
            }
            if ($unendorsed_reply) {
                echo $unendorsed_html;
            }
        }


        ?>
    </div>

    <div class="h4 mt-3 ml-3 mb-2">
        Your reply:
    </div>
    <div class="d-flex justify-content">
        <?php echo form_open(base_url() . 'dashboard/course/' . $course_id . '/reply/' . $post_info['post_id'] . '/submit-reply'); ?>
        <div class="form-group" style="width: 85vw">
            <textarea type="text" class="form-control" placeholder="Content" maxlength='500' required="required"
                name="content" rows="2"></textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block" style='width:10vw;'>Reply</button>
        </div>
        <?php echo form_close(); ?>
    </div>



</div>

<!-- <script>
    function tes(id, endorse){
        const replyId = document.getElementById(id);
        const replyEndorse = endorse;
        console.log(replyId,endorse);
    }
</script> -->