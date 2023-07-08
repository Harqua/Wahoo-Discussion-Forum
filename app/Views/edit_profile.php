<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<style>
    form i {
        margin-left: -4vh;
        margin-top: 2vh;
        cursor: pointer;
    }
</style>
<div class="container">
    <div class="h-100 col-4 offset-4 mt-3">
        <?php echo form_open(base_url() . 'dashboard/edit-profile/edit-check'); ?>
        <h2 class="text-center">Edit Profile</h2>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Username" maxlength='20' disabled
                value="<?php echo $username ?>" name="username">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Full Name" maxlength='30' required="required"
                value="<?php echo $name ?>" name="name">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Email Address" maxlength='40' disabled
                value="<?php echo $email ?>" name="email">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" id="currentPassword" maxlength='20'
                value="<?php echo $password ?>" placeholder="Current Password" disabled
                name="currentpassword">
        </div>
        <div class="form-group d-flex">
            <input type="password" class="form-control" id="newPassword" maxlength='20' placeholder="New Password"
                name="newpassword">
            <i class="bi bi-eye-slash align-item-center" id="toggleNewPassword"></i>
        </div>
        <div class="form-group d-flex">
            <input type="password" class="form-control togglePassword" id="confirmNewPassword"
                placeholder="Confirm New Password" maxlength='20' name="confirmnewpassword">
            <i class="bi bi-eye-slash align-item-center" id="toggleConfirmNewPassword"></i>
        </div>
    
        <?php echo $error; ?>
        <?php echo $success; ?>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Save</button>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<script>

    const toggleNewPassword = document
        .querySelector('#toggleNewPassword');

    const toggleConfirmNewPassword = document
        .querySelector('#toggleConfirmNewPassword');

    const newpassword = document.querySelector('#newPassword');
    const confirmnewpassword = document.querySelector('#confirmNewPassword');

    toggleNewPassword.addEventListener('click', () => {

        // Toggle the type attribute using
        // getAttribute() method
        const type = newpassword
            .getAttribute('type') === 'password' ?
            'text' : 'password';

        newpassword.setAttribute('type', type);

    });

    toggleConfirmNewPassword.addEventListener('click', () => {

        // Toggle the type attribute using
        // getAttribute() method
        const type = confirmnewpassword
            .getAttribute('type') === 'password' ?
            'text' : 'password';

        confirmnewpassword.setAttribute('type', type);

    });
</script>

<!-- Reference:
- Toggle Password visibility: https://www.geeksforgeeks.org/how-to-toggle-password-visibility-in-forms-using-bootstrap-icons/

-->