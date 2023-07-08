<?php

namespace App\Controllers;

use CodeIgniter\Email\Email;

class Post extends BaseController
{
    public function course_index()
    {
        if (!session()->get('id')) {
            return redirect()->to(base_url('login'));
        }
        $uri = new \CodeIgniter\HTTP\URI(current_url());
        $post_model = model('App\Models\Post_model');
        $course_model = model('App\Models\Course_model');

        $userId = session()->get('id');

        $course_id = $uri->getSegment(5);
        $data['course_id'] = $course_id;

        $inst_model = $post_model->getPostInstructor($course_id);
        $stu_model = $post_model->getPostStudent($course_id);
        $trend_model = $post_model->getTrendingPost($course_id);

        $trend_html = '<div class="mt-1 d-flex flex-wrap justify-content-center">';
        $inst_html = '<div class="mt-1 d-flex flex-wrap justify-content-center">';
        $stu_html = '<div class="mt-1 d-flex flex-wrap justify-content-center">';


        //Trending Posts
        if ($trend_model) {
            foreach ($trend_model as $trend_post) {
                $check_like = $post_model->checkLike($userId, $trend_post['post_id']);
                $post = $post_model->getPostInfo($trend_post['post_id']);
                if ($post['instructor_id']) {
                    $author = $post_model->getAuthor($post['post_id'], "instructor");
                    $userType = "Instructor";
                } else {
                    $author = $post_model->getAuthor($post['post_id'], "student");
                    $userType = "Student";
                }
                $totallen = strlen($post['content']);

                $trend_html .= '<div class="card ml-1 mt-1 mr-1 ';
                if ($userType === 'Instructor') {
                    $trend_html .= 'border-primary text-primary';
                } else {
                    $trend_html .= 'border-success text-success';
                }
                $trend_html .= '" style="width: 20rem;"> <div class="card-body"> <h5 class="card-title d-flex justify-content-between">';
                $trend_html .= $post['title'];
                $trend_html .= '</h5>';
                $trend_html .= '<a href="' . base_url() . "dashboard/course/" . $course_id . "/like/" . $post['post_id'] . '" class="mb-3 btn btn-sm ';
                if (session()->get('usertype') === 'instructor') {
                    $trend_html .= 'disabled ';
                }
                if ($userType === 'Instructor') {
                    if (!$check_like || session()->get('usertype') === 'instructor') {
                        $trend_html .= 'btn-outline-primary">Like ';
                    } else {
                        $trend_html .= 'btn-primary">Liked ';
                    }

                } else {
                    if (!$check_like || session()->get('usertype') === 'instructor') {
                        $trend_html .= 'btn-outline-success">Like ';
                    } else {
                        $trend_html .= 'btn-success">Liked ';
                    }

                }
                $trend_html .= $post_model->countLike($post['post_id']); //like count
                $trend_html .= '</a> <div class="card-subtitle mb-2 text-muted">';
                if ($totallen > 40) {
                    $trend_html .= substr($post['content'], 0, 39) . '...';
                } else {
                    $trend_html .= $post['content'];
                }
                $trend_html .= '</div> <a href="' . base_url() . "dashboard/course/" . $course_id . "/reply/" . $post['post_id'] . '" class=" ';
                if ($userType === 'Instructor') {
                    $trend_html .= 'text-primary';
                } else {
                    $trend_html .= 'text-success';
                }
                $trend_html .= '">See more</a> </div> <ul class="list-group list-group-flush"> <li class="list-group-item" style="font-size: 2vh;">Author: ';
                $trend_html .= $author;
                $trend_html .= '</li> <li class="list-group-item" style="font-size: 2vh;">';
                $trend_html .= 'Posted on: ';
                $trend_html .= $post['date_posted'] . ' ' . $post['time_posted'] . '</li></ul></div>';

            }
        }


        //Instructor Posts
        if ($inst_model) {
            foreach ($inst_model as $post) {
                $author = $post_model->getAuthor($post['post_id'], "instructor");
                $totallen = strlen($post['content']);
                $check_like = $post_model->checkLike($userId, $post['post_id']);

                $inst_html .= '<div class="card ml-1 mt-1 mr-1 border-primary text-primary" style="width: 30rem;"> <div class="card-body"> <h5 class="card-title d-flex justify-content-between">';
                $inst_html .= $post['title'];
                if (session()->get('usertype') === 'student') {
                    $inst_html .= '<a href="' . base_url() . "dashboard/course/" . $course_id . "/like/" . $post['post_id'] . '" class="btn btn';

                    if (!$check_like) {
                        $inst_html .= '-outline-primary btn-sm">Like ';
                    } else {
                        $inst_html .= '-primary btn-sm">Liked ';
                    }

                    $inst_html .= $post_model->countLike($post['post_id']); //like count
                    $inst_html .= '</a>';
                } else {
                    $inst_html .= '<div class="btn btn-outline-primary btn-sm disabled">Like ';
                    $inst_html .= $post_model->countLike($post['post_id']); //like count
                    $inst_html .= '</div>';
                }

                $inst_html .= '</h5> <div class="card-subtitle mb-2 text-muted">';
                if ($totallen > 60) {
                    $inst_html .= substr($post['content'], 0, 59) . '...';
                } else {
                    $inst_html .= $post['content'];
                }
                $inst_html .= '</div> <a href="' . base_url() . "dashboard/course/" . $course_id . '/reply/' . $post['post_id'] . '" class="text-primary">See more</a> </div> <ul class="list-group list-group-flush"> <li class="list-group-item" style="font-size: 2vh;">Author: ';
                $inst_html .= $author;
                $inst_html .= '</li> <li class="list-group-item" style="font-size: 2vh;">';
                $inst_html .= 'Posted on: ';
                $inst_html .= $post['date_posted'] . ' ' . $post['time_posted'] . '</li></ul></div>';

            }
        }

        //Student Posts
        if ($stu_model) {
            foreach ($stu_model as $post) {
                $author = $post_model->getAuthor($post['post_id'], "student");
                $totallen = strlen($post['content']);
                $check_like = $post_model->checkLike($userId, $post['post_id']);
                $stu_html .= '<div class="card ml-1 mt-1 mr-1 border-success text-success" style="width: 30rem;"> <div class="card-body"> <h5 class="card-title d-flex justify-content-between">';
                $stu_html .= $post['title'];
                if (session()->get('usertype') === 'student') {
                    $stu_html .= '<a href="' . base_url() . "dashboard/course/" . $course_id . "/like/" . $post['post_id'] . '" class="btn btn';

                    if (!$check_like) {
                        $stu_html .= '-outline-success btn-sm">Like ';
                    } else {
                        $stu_html .= '-success btn-sm">Liked ';
                    }

                    $stu_html .= $post_model->countLike($post['post_id']); //like count
                    $stu_html .= '</a>';
                } else {
                    $stu_html .= '<div class="btn btn-outline-success btn-sm disabled">Like ';
                    $stu_html .= $post_model->countLike($post['post_id']); //like count
                    $stu_html .= '</div>';
                }

                $stu_html .= '</h5> <div class="card-subtitle mb-2 text-muted">';
                if ($totallen > 60) {
                    $stu_html .= substr($post['content'], 0, 59) . '...';
                } else {
                    $stu_html .= $post['content'];
                }
                $stu_html .= '</div> <a href="' . base_url() . "dashboard/course/" . $course_id . '/reply/' . $post['post_id'] . '" class="text-success">See more</a> </div> <ul class="list-group list-group-flush"> <li class="list-group-item" style="font-size: 2vh;">Author: ';
                $stu_html .= $author;
                $stu_html .= '</li> <li class="list-group-item" style="font-size: 2vh;">';
                $stu_html .= 'Posted on: ';
                $stu_html .= $post['date_posted'] . ' ' . $post['time_posted'] . '</li></ul></div>';
            }
        }


        $trend_html .= '</div>';
        $inst_html .= '</div>';
        $stu_html .= '</div>';

        $data['inst_model'] = $inst_model;
        $data['stu_model'] = $stu_model;
        $data['trend_model'] = $trend_model;
        $data['inst_posts'] = $inst_html;
        $data['stu_posts'] = $stu_html;
        $data['trend_posts'] = $trend_html;
        $data['course_info'] = $course_model->courseInfo($course_id);

        echo view('template/header');
        echo view('post', $data);
        echo view('template/footer');
    }

    public function create_post()
    {
        if (!session()->get('id')) {
            return redirect()->to(base_url('login'));
        }


        $uri = new \CodeIgniter\HTTP\URI(current_url());

        $data['course_id'] = $uri->getSegment(5);
        $data['error'] = '';

        echo view('template/header');
        echo view('create_post', $data);
        echo view('template/footer');
    }

    public function submit()
    {
        $uri = new \CodeIgniter\HTTP\URI(current_url());

        $post_model = model('App\Models\Post_model');
        $course_model = model('App\Models\Course_model');

        $userid = session()->get('id');
        $usertype = session()->get('usertype');
        $title = $this->request->getPost('title');
        $content = $this->request->getPost('content');


        $rules = [
            'picfile' => 'ext_in[picfile,jpg,gif,png]',
        ];




        $data['course_id'] = $uri->getSegment(5);

        if ($this->validate($rules)) {
            $picfile = $this->request->getFile('picfile');
            if (!strlen($picfile) > 0) {
                $picfile = null;
            }
            $post_model->addPost($data['course_id'], $userid, $usertype, $title, $content, $picfile);
            
           

            if(session()->get('usertype')==='instructor'){
                $course_info = $course_model->courseInfo($data['course_id']);
                $email = $post_model->getEmail($data['course_id']);
                foreach ($email as $receipient) {
                    $to = $receipient;
                    $subject = 'New threads in ' . $course_info['course_code'];
                    $message = "
                    <html>
                            <head>
                                <title>Post Notification</title>
                            </head>
                            <body>
                                <h2>WAHOO!!! Your instructor just posted an announcement.</h2>
                                <h3>Title: " . $title . "</h3>
                                <p>Content: " . $content . "</p>
                                <h4><a href='". base_url()."/login'>Click here to open the website</a></h4>
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
                    $email->send(FALSE);
                }
            }
            


            return redirect()->to(base_url('dashboard/course/' . $data['course_id']));
        } else {
            $data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Submit Failed </div> ";
            echo view('template/header');
            echo view('create_post', $data);
            echo view('template/footer');
        }

    }

    public function like_post()
    {
        $uri = new \CodeIgniter\HTTP\URI(current_url());

        $post_model = model('App\Models\Post_model');
        $course_id = $uri->getSegment(5);
        $post_id = $uri->getSegment(7);
        $id = session()->get('id');
        if ($post_model->likePost($id, $post_id)) {

            return redirect()->to(base_url('dashboard/course/' . $course_id));
        }

    }

    public function remove_like_bookmark()
    {
        $uri = new \CodeIgniter\HTTP\URI(current_url());

        $post_model = model('App\Models\Post_model');
        $totalSegment = $uri->getTotalSegments();
        $post_id = $uri->getSegment($totalSegment);
        $id = session()->get('id');
        if ($post_model->likePost($id, $post_id)) {

            return redirect()->to(base_url('dashboard/liked-posts'));
        }
    }
}