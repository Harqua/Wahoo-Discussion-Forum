<?php

namespace App\Controllers;

use CodeIgniter\Email\Email;

class Register extends BaseController
{
    public function register()
    {
        if (session()->get('username')) {
            return redirect()->to(base_url('dashboard'));
        }
        //register page
        $data['error'] = "";
        echo view("template/header");
        echo view("register", $data);
        echo view("template/footer");
    }

    public function check_register()
    {
        $data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Please complete the details </div> ";
        $username = $this->request->getPost('username');
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        // $confirmpassword = $this->request->getPost('confirmpassword');
        $usertype = $this->request->getPost('usertype');

        $rules = [
            'username' => [
                "label" => "username",
                "rules" => 'required|min_length[4]|max_length[20]|alpha_numeric'
            ],
            'name' => [
                "label" => "name",
                "rules" => 'required|min_length[4]|max_length[30]|alpha_numeric_space'
            ],
            'email' => [
                "label" => "email",
                "rules" => 'required|valid_email'
            ],
            'password' => [
                "label" => "password",
                "rules" => 'required|min_length[4]'
            ],
            'confirmpassword' => [
                "label" => "confirmpassword",
                "rules" => 'required|matches[password]'
            ],
            'usertype' => [
                "label" => "usertype",
                "rules" => 'required'
            ],
        ];
        if ($this->validate($rules)) {
            //check if rules are satisfied
            $model = model('App\Models\User_model');
            $error = $model->register($username, $name, $email, $password, $usertype);
            if ($error) {
                echo view('template/header');
                echo view('register_template/fail', ['error' => $error]);
                echo view('template/footer');
            } else {
                //check email for verification
                $model = model('App\Models\User_model');
                $info = $model->getCode($email, $usertype);
                $id = $info[$usertype . "_id"];


                $to = $email;
                $subject = 'Account Verification';
                $message = "
                        <html>
						<head>
							<title>Verification Code</title>
						</head>
						<body>
							<h2>WAHOO!!! Thank you for Registering.</h2>
							<p>Your Account:</p>
                            <p>Full Name: " . $name . "</p>
							<p>Email: " . $email . "</p>
							<p>User Type: " . $usertype . "</p>
							<h4><a href='" . base_url() . "register/activate/" . $usertype . "/" . $id . "/" . $info['code'] . "'>Click here to activate</a></h4>
						</body>
						</html>
                ";
                $config = [
                    'protocol' => 'smtp',
                    'wordWrap' => true,
                    'SMTPHost' => 'mailhub.eait.uq.edu.au',
                    'SMTPPort' => 25,
                    'mailType' => 'html'


                ];
                $email = new Email();
                $email->initialize($config);
                $email->setTo($to);
                $email->setFrom('wahoo@fish.com', 'Wahoo Discussion Team');
                $email->setSubject($subject);
                $email->setMessage($message);

                if ($email->send(FALSE)) {
                    echo view('template/header');
                    echo view('register_template/success');
                    echo view('template/footer');
                }


            }

        } else {
            //if rules are not satisfied
            echo view('template/header');
            echo view("register", $data);
            echo view('template/footer');
        }
    }
    public function activate()
    {
        $uri = new \CodeIgniter\HTTP\URI(current_url());
        $model = model('App\Models\User_model');
        $id = $uri->getSegment(6);
        $usertype = $uri->getSegment(5);
        $code = $uri->getSegment(7);

        if ($model->activate($id, $usertype, $code)) {
            echo view('template/header');
            echo view('register_template/verified');
            echo view('template/footer');

        } else {
            echo view('template/header');
            echo view('register_template/verified_fail');
            echo view('template/footer');
        }

    }
}