<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index()
    {
        $data['error'] = "";
        if (session()->get('username')) {
            return redirect()->to(base_url('dashboard'));
        }

        if (isset($_COOKIE['username']) && isset($_COOKIE['password']) && isset($_COOKIE['usertype']) && isset($_COOKIE['id'])) {
            //if cookie exists

            return redirect()->to(base_url('dashboard'));

        } else {
            //if cookie does not exist
            echo view('template/header');
            echo view('login', $data);
            echo view('template/footer');
        }
    }

    public function check_login()
    {
        if (session()->get('username')) {
            return redirect()->to(base_url('dashboard'));
        }
        //initialise the variables and user database
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $usertype = $this->request->getPost('usertype');
        $model = model('App\Models\User_model');
        $if_remember = $this->request->getPost('remember');
        $get_id = $model->login($username, $password, $usertype);


        if (!$usertype) {
            //if user did not select a role
            $data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Please select a role </div> ";
            echo view('template/header');
            echo view('login', $data);
            echo view('template/footer');
        } else if ($get_id) {
            //verification status
            $get_verify = $model->verifyStatus($get_id, $usertype)['verify'];

            //set session
            $session = session();
            $session->set('id', $get_id);
            $session->set('username', $username);
            $session->set('password', $password);
            $session->set('usertype', $usertype);
            $session->set('verify', $get_verify);

            //set cookies
            if ($if_remember) {
                setcookie('id', $get_id, time() + 86400 * 30, "/");
                setcookie('username', $username, time() + 86400 * 30, "/");
                setcookie('password', $password, time() + 86400 * 30, "/");
                setcookie('usertype', $usertype, time() + 86400 * 30, "/");
                setcookie('verify', $get_verify, time() + 86400 * 30, "/");
            }

            // //set variable to pass
            // $user_info['username'] = $username;
            // $user_info['usertype'] = $usertype;

            // //display main page
            // echo view("template/header");
            // echo view("dashboard", $user_info);
            // echo view("template/footer");

            return redirect()->to(base_url('dashboard'));
            // print_r($get_verify);
        } else {
            //if login data is wrong
            $data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Incorrect login info </div> ";
            echo view('template/header');
            echo view('login', $data);
            echo view('template/footer');
        }
    }

    public function logout()
    {
        //destroy session
        $session = session();
        $session->destroy();

        //destroy cookie and return to login page
        setcookie('id', '', time() - 3600, '/');
        setcookie('username', '', time() - 3600, '/');
        setcookie('password', '', time() - 3600, '/');
        setcookie('usertype', '', time() - 3600, '/');
        setcookie('verify', '', time() - 3600, '/');
        return redirect()->to(base_url('login'));
    }

}