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
<div class="min-vh-100 container">
    <div class="h-100 col-4 offset-4">
        <div id='fourDigits'>
            <h2 class="text-center mt-5">Enter code</h2>
            <div class="form-group text-center">
                Please enter 4-digit code below
            </div>
            <div class="form-group">
                <input id='codeInput' type="text" pattern="\d*" class="form-control" minlength='4' maxlength='4'
                    placeholder="4-digit code" required="required" name="code">
            </div>
            <div>
                <div id="wrongCode" class='alert alert-danger d-none'> Wrong Code </div>
                <div class="form-group">
                    <button onclick="verifyCode()" class="btn btn-primary btn-block">Proceed</button>
                </div>
            </div>
        </div>
        <div id='resetPassword' class='d-none'>
            <?php echo form_open(base_url() . 'forgot_password/check_email/reset'); ?>
            <h2 class="text-center mt-5 mb-2">Enter your new password</h2>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Email Address" maxlength='40' readonly
                    value="<?php echo $email ?>" name="email">
            </div>
            <div>
                <div class="form-group d-flex justify-content-between">
                    User Type:
                    <section>
                        <input type="radio" id="student" name="usertype" value="student" <?php if($usertype === "student"){echo 'checked readonly';}?>>
                        <label for="student">Student</label>
                    </section>
                    <section>
                        <input type="radio" id="instructor" name="usertype" value="instructor" <?php if($usertype === "instructor"){echo 'checked readonly';}?>>
                        <label for="instructor">Instructor</label>
                    </section>
                </div>
                <div class="form-group d-flex">
                    <input type="password" class="form-control" id="newPassword" maxlength='20'
                        placeholder="New Password" name="newpassword">
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
                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                </div>
                <?php echo form_close(); ?>
            </div>

        </div>
    </div>

    <script>

        const toggleNewPassword = document
            .querySelector('#toggleNewPassword');

        const toggleConfirmNewPassword = document
            .querySelector('#toggleConfirmNewPassword');

        const newpassword = document.querySelector('#newPassword');
        const confirmnewpassword = document.querySelector('#confirmNewPassword');

        const fourDigitsCode = <?php echo $code; ?>

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

        function verifyCode() {
            const fourDigits = document.getElementById("fourDigits");
            const fourDigitsInput = document.getElementById('codeInput').value;
            const resetPassword = document.getElementById("resetPassword");
            const wrongCode = document.getElementById("wrongCode");
            if (fourDigitsCode == fourDigitsInput) {
                resetPassword.classList.remove("d-none");
                fourDigits.classList.add("d-none");
            } else {
                wrongCode.classList.remove("d-none");

            }
        }
    </script>

    <!-- Reference:
- Toggle Password visibility: https://www.geeksforgeeks.org/how-to-toggle-password-visibility-in-forms-using-bootstrap-icons/

-->