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
<div class=" mt-3 container min-vh-100">
    <div class="col-4 offset-4">
        <?php echo form_open(base_url() . 'register/check_register'); ?>
        <h2 class="text-center">Register</h2>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Username" maxlength='20' required="required"
                name="username">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Full Name" maxlength='30' required="required"
                name="name">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Email Address" maxlength='40' required="required"
                name="email">
        </div>
        <div class="form-group d-flex">
            <input type="password" class="form-control" id="password" maxlength='20' placeholder="Password"
                required="required" name="password">
            <i class="bi bi-eye-slash align-item-center" id="togglePassword"></i>
        </div>
        <div class="form-group d-flex">
            <input type="password" class="form-control togglePassword" id="confirmpassword"
                placeholder="Confirm Password" maxlength='20' required="required" name="confirmpassword">
            <i class="bi bi-eye-slash align-item-center" id="toggleConfirmPassword"></i>
        </div>
        
        <div class="form-group d-flex justify-content-between">
            Create account as:
            <section>
                <input type="radio" id="student" name="usertype" value="student" checked>
                <label for="student">Student</label>
            </section>
            <section>
                <input type="radio" id="instructor" name="usertype" value="instructor">
                <label for="instructor">Instructor</label>
            </section>
        </div>
        <?php echo $error; ?>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Create Account</button>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<script>
    const togglePassword = document
        .querySelector('#togglePassword');

    const toggleConfirmPassword = document
        .querySelector('#toggleConfirmPassword');

    const password = document.querySelector('#password');
    const confirmpassword = document.querySelector('#confirmpassword');

    togglePassword.addEventListener('click', () => {

        // Toggle the type attribute using
        // getAttribute() method
        const type = password
            .getAttribute('type') === 'password' ?
            'text' : 'password';

        password.setAttribute('type', type);

    });

    toggleConfirmPassword.addEventListener('click', () => {

        // Toggle the type attribute using
        // getAttribute() method
        const type = confirmpassword
            .getAttribute('type') === 'password' ?
            'text' : 'password';

        confirmpassword.setAttribute('type', type);

    });
</script>

<!-- Reference:
- Toggle Password visibility: https://www.geeksforgeeks.org/how-to-toggle-password-visibility-in-forms-using-bootstrap-icons/
- Email verification: https://www.sourcecodester.com/tutorials/php/12087/codeigniter-signup-email-verification.html
-->