<div class=" mt-3 container min-vh-100">
    <div class="d-flex justify-content-center text-center">
        <?php echo form_open_multipart(base_url() . 'dashboard/course/' . $course_id . '/create_post/submit'); ?>
        <a href="<?php echo base_url() . "dashboard/course/" . $course_id ?>" class="h4">Back</a>
        <h2 class="text-center mt-3">Create Post</h2>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Title" maxlength='100' required="required"
                name="title">
        </div>

        <div class="form-group" style="width: 50vw">
            <textarea type="text" class="form-control" placeholder="Content" maxlength='1000' required="required"
                name="content" rows="10"></textarea>
        </div>
        <div class='form-group'>
            <input type="file" name="picfile" size="20">
        </div>
        <?php echo $error ?>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Create Post</button>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>