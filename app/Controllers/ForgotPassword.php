<?php

namespace App\Controllers;

use CodeIgniter\Email\Email;

class ForgotPassword extends BaseController
{
    public function forgot_password()
    {
        $data['error'] = '';
        $data['success'] = '';
        echo view('template/header');
        echo view('forgot_password', $data);
        echo view('template/footer');
    }

    public function check_email()
    {

        $usertype = $this->request->getPost('usertype');
        $rules = [
            'email' => [
                "label" => "email",
                "rules" => 'required|valid_email'
            ],
            'usertype' => [
                "label" => "usertype",
                "rules" => 'required'
            ],

        ];


        if ($this->validate($rules)) {
            //check if rules are satisfied
            $model = model('App\Models\User_model');
            $email = $this->request->getVar('email', FILTER_SANITIZE_EMAIL);
            $check = $model->emailexist($email, $usertype);
            $data['code'] = rand(1000, 9999);
            if ($check) {
                $to = $email;
                $subject = 'Account Recovery';
                $message = "
                <html>
						<head>
							<title>Account Recovery Code</title>
						</head>
						<body>
							<h2>WAHOO!!! It seems that you forgot your password.</h2>
                            <p>Here's your 4-digit code:</p>
                            <h2>" . $data['code'] . "</h2>
							<p>Your Account:</p>
							<p>Email: " . $email . "</p>
							<p>User Type: " . $usertype . "</p>
						</body>
						</html>
                ";
                $email = new Email();

                $config = [
                    'protocol' => 'smtp',
                    'wordWrap' => true,
                    'SMTPHost' => 'mailhub.eait.uq.edu.au',
                    'SMTPPort' => 25,
                    'mailType' => 'html'
                ];
                $email->initialize($config);
                $email->setTo($to);
                $email->setFrom('wahoo@fish.com', 'Wahoo Discussion Team');
                $email->setSubject($subject);
                $email->setMessage($message);

                if ($email->send(FALSE)) {
                    // $data['error'] = '';
                    // $data['success'] = "<div class=\"alert alert-success\"> Email sent!! </div> ";
                    $data['error'] = "";
                    $data['success'] = "";
                    $data['email'] = $to;
                    $data['usertype'] = $usertype;
                    echo view('template/header');
                    echo view('forgot_password_code', $data);
                    echo view('template/footer');
                } else {
                    $data['error'] = $email->printDebugger();
                    $data['success'] = "";
                    echo view('template/header');
                    echo view('forgot_password', $data);
                    echo view('template/footer');

                    // "<div class=\"alert alert-danger\" role=\"alert\"> Email not sent. </div> ";
                }
            } else {
                $data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Email not found. </div> ";
                $data['success'] = "";
                echo view('template/header');
                echo view('forgot_password', $data);
                echo view('template/footer');
            }

        } else {
            $data['success'] = '';
            $data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Please enter all the details </div> ";
            echo view('template/header');
            echo view('forgot_password', $data);
            echo view('template/footer');
        }

    }
    public function reset_password()
    {
        $email = $this->request->getPost('email');
        $usertype = $this->request->getPost('usertype');
        $newPass = $this->request->getPost('newpassword');
        // $confNewPass = $this->request->getPost('confirmnewpassword');

        $rules = [

            'newpassword' => [
                "label" => "newpassword",
                "rules" => 'required|min_length[4]'
            ],
            'confirmnewpassword' => [
                "label" => "confirmnewpassword",
                "rules" => 'required|matches[newpassword]'
            ],
        ];
        if ($this->validate($rules)) {
            $model = model('App\Models\User_model');
            if ($model->accountReset($email, $newPass, $usertype)) {
                echo view('template/header');
                echo view('forgot_password_template/success');
                echo view('template/footer');
            }
        } else {

            echo view('template/header');
            echo view('forgot_password_template/fail');
            echo view('template/footer');
        }
    }
}