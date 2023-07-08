<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function dashboard()
    {

        //Model
        $user_model = model('App\Models\User_model');
        $course_model = model('App\Models\Course_model');



        //Variables
        if (session()->get('id')) {
            $data['id'] = session()->get('id');
            $data['username'] = session()->get('username');
            $data['usertype'] = session()->get('usertype');
        } else if (isset($_COOKIE['id'])) {
            $session = session();
            $session->set('id', $_COOKIE['id']);
            $session->set('username', $_COOKIE['username']);
            $session->set('password', $_COOKIE['password']);
            $session->set('usertype', $_COOKIE['usertype']);
            $session->set('verify', $_COOKIE['verify']);
            $data['id'] = $_COOKIE['id'];
            $data['username'] = $_COOKIE['username'];
            $data['usertype'] = $_COOKIE['usertype'];
        } else {
            return redirect()->to(base_url('login'));
        }


        $user_data = $user_model->getUserData($data['id'], $data['usertype']);
        $course_data = $course_model->getCourseData($data['id'], $data['usertype']);

        session()->set('name', $user_data[$data['usertype'] . '_name']);
        session()->set('email', $user_data['email']);
        $verifyStatus = $user_model->verifyStatus($data['id'], $data['usertype']);
        session()->set('verify', $verifyStatus['verify']);

        $data['name'] = session()->get('name');
        $data['email'] = session()->get('email');
        $data['verify'] = session()->get('verify');
        /*
        Array index:
        [role_id], [role_username], [password], [role_name], [email]
        
        Example:
        print_r($user_data[$data['usertype'].'_username']);
        */

        // print_r($course_data);
        $data['courses'] = $course_data;

        //display main page
        echo view("template/header");
        echo view("dashboard", $data);
        echo view('template/footer');
    }

    public function create_course()
    {
        $data['error'] = "";
        echo view("template/header");
        echo view("create", $data);
        echo view('template/footer');
    }

    public function edit_profile()
    {
        if (!session()->get('id')) {
            return redirect()->to(base_url('login'));
        }
        $data['error'] = "";
        $data['success'] = "";
        $data['username'] = session()->get('username');
        $data['name'] = session()->get('name');
        $data['email'] = session()->get('email');
        $data['password'] = session()->get('password');

        echo view("template/header");
        echo view("edit_profile", $data);
        echo view('template/footer');
    }

    public function edit_check()
    {

        $user_model = model('App\Models\User_model');


        $userId = session()->get('id');
        $usertype = session()->get('usertype');
        $newName = $this->request->getPost('name');
        $newPass = $this->request->getPost('newpassword');
        $confNewPass = $this->request->getPost('confnewpassword');

        if ($newPass == '' && $confNewPass == '') {
            $rules = [
                'name' => [
                    "label" => "name",
                    "rules" => 'required|min_length[4]|max_length[30]|alpha_numeric_space'
                ]
            ];
        } else {
            $rules = [
                'name' => [
                    "label" => "name",
                    "rules" => 'required|min_length[4]|max_length[30]|alpha_numeric_space'
                ],
                'newpassword' => [
                    "label" => "newpassword",
                    "rules" => 'required|min_length[4]'
                ],
                'confirmnewpassword' => [
                    "label" => "confirmnewpassword",
                    "rules" => 'required|matches[newpassword]'
                ],
            ];
        }


        if ($this->validate($rules)) {

            $userUpdate = $user_model->profileUpdate($userId, $usertype, $newName, $newPass);

            if ($userUpdate) {
                $data['error'] = '';
                $data['success'] = "<div class=\"alert alert-success\"> Profile changed. </div> ";
                session()->set('name', $newName);
                if ($newPass !== '') {
                    session()->set('password', $newPass);
                }

            } else {
                $data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Try Again. </div>";
                $data['success'] = "";
            }

        } else {
            $data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Please fill out the correct details. </div>";
            $data['success'] = "";

        }

        $data['username'] = session()->get('username');
        $data['name'] = session()->get('name');
        $data['email'] = session()->get('email');
        $data['password'] = session()->get('password');

        echo view("template/header");
        echo view("edit_profile", $data);
        echo view('template/footer');


    }

    public function create_status()
    {
        $data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Please complete the details </div> ";
        $coursecode = $this->request->getPost('coursecode');
        $coursename = $this->request->getPost('coursename');
        $instructorid = session()->get('id');

        $rules = [
            'coursecode' => [
                "label" => "coursecode",
                "rules" => 'required|min_length[8]|max_length[8]|alpha_numeric'
            ],
            'coursename' => [
                "label" => "coursename",
                "rules" => 'required|min_length[4]|max_length[100]'
            ]
        ];
        if ($this->validate($rules)) {
            //check if rules are satisfied
            $course_model = model('App\Models\Course_model');
            $error = $course_model->create($coursecode, $coursename, $instructorid);
            if ($error) {
                echo view('template/header');
                echo view('create_template/fail', ['error' => $error]);
                echo view('template/footer');
            } else {
                return redirect()->to(base_url('dashboard'));
            }

        } else {
            //if rules are not satisfied
            echo view('template/header');
            echo view("create", $data);
            echo view('template/footer');
        }
    }

    public function join_course()
    {
        $data['error'] = "";

        // $course_model = model('App\Models\Course_model');
        // $all_course_data = $course_model->getAllCourse(session()->get('id'));
        // $data['allcourse'] = json_encode($all_course_data);

        if (isset($this->request->getGet()["course"])) {
            $course_id = $this->request->getGet()["course"];
            $student_course_mod = model('App\Models\Course_model');
            $join_course = $student_course_mod->joinCourse(session()->get('id'), $course_id);
            if ($join_course) {
                return redirect()->to(base_url('dashboard/course/' . $course_id));
            } else {
                $data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Join Course Fail </div> ";
                echo view("template/header");
                echo view("join", $data);
                echo view('template/footer');
            }


        } else {
            echo view("template/header");
            echo view("join", $data);
            echo view('template/footer');
        }
    }

    public function find_course()
    {

        $result = array();

        $course_model = model('App\Models\Course_model');
        $all_course_data = $course_model->getAllCourse(session()->get('id'));
        $data = $this->request->getGet()["course"];

        foreach ($all_course_data as $course) {
            $course_code = $course["course_code"];
            if (str_contains($course_code, $data)) {
                array_push($result, $course);
            }
        }

        header("Content-Type: application/json");
        echo json_encode($result);
    }

    public function like_list()
    {
        if (!session()->get('id')) {
            return redirect()->to(base_url('login'));
        }

        $post_model = model('App\Models\Post_model');
        $course_model = model('App\Models\Course_model');
        $id = session()->get('id');
        $like_data = $post_model->allLiked($id);

        $html = '';
        
        foreach ($like_data as $liked){
            $like_post = $post_model->getPostInfo($liked['post_id']);
            // print_r($like_post);
            $course_info = $course_model->courseInfo($like_post['course_id']);
            $totallen = strlen($like_post['content']);
            $html .= '<div class="card border-w mt-2 mb-2" style="width: 85vw;">';
            $html .= '<div class="card-body "> <div class="card-title h3">';
            $html .=  $like_post['title'];
            $html .= '</div> <div class="card-subtitle text-muted h5">';
            if ($totallen > 100) {
                $html .= substr($like_post['content'], 0, 99) . '...';
            } else {
                $html .= $like_post['content'];
            }
            $html .= '</div><div><a href="' . base_url() . "dashboard/course/" . $course_info['course_id'] . '/reply/' . $like_post['post_id'] . '" class="text-primary">See more</a></div>';
            $html .= '<a href="'.base_url().'dashboard/liked-posts/'.$like_post['post_id'].'" class="btn btn-danger mt-2">Remove</a> </div> <ul class="list-group list-group-flush"> <li class="list-group-item" style="font-size: 2vh;"> Course: ';
            $html .= $course_info['course_name'];
            $html .= '</li></ul></div>';
            
            
        }
        $data['html'] = $html;

        echo view("template/header");
        echo view("like",$data);
        echo view('template/footer');

    }
}