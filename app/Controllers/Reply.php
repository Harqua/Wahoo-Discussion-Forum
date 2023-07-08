<?php

namespace App\Controllers;

use CodeIgniter\Email\Email;

class Reply extends BaseController
{
    public function reply_index()
    {
        if (!session()->get('id')) {
            return redirect()->to(base_url('login'));
        }


        $uri = new \CodeIgniter\HTTP\URI(current_url());
        $post_model = model('App\Models\Post_model');
        $reply_model = model('App\Models\Reply_model');

        $post_id = $uri->getSegment(7);
        $course_id = $uri->getSegment(5);
        $post_info = $post_model->getPostInfo($post_id);

        if ($post_info['instructor_id']) {
            $post_author = $post_model->getAuthor($post_info['post_id'], "instructor");
            // $userType = "Instructor";
        } else {
            $post_author = $post_model->getAuthor($post_info['post_id'], "student");
            // $userType = "Student";
        }

        $unendorsed_reply = $reply_model->getAllReply($post_id);
        $endorsed_reply = $reply_model->getEndorsedReply($post_id);


        $endorsed_html = '';
        $unendorsed_html = '';

        //Endorsed
        foreach ($endorsed_reply as $reply) {
            if ($reply['instructor_id']) {
                $reply_author = $reply_model->getAuthor($reply['reply_id'], "instructor");
                $userType = "Instructor";
            } else {
                $reply_author = $reply_model->getAuthor($reply['reply_id'], "student");
                $userType = "Student";
            }
            $endorsed_html .= '<div class="card my-1 ';

            if ($userType === "Instructor") {
                $endorsed_html .= "border-primary";
            } else {
                $endorsed_html .= "border-success";
            }
            $endorsed_html .= '" id="' . $reply['reply_id'] . '" ';
            $endorsed_html .= 'style="width: 85vw;"> <div class="card-body"> <div class="card-subtitle mb-2 text-muted h6">';
            $endorsed_html .= $reply_author;
            if ($userType === "Instructor") {
                $endorsed_html .= ' (Instructor)';
            }
            $endorsed_html .= '<small> ';
            $endorsed_html .= $reply['date_replied'] . ' ' . $reply['time_replied'];
            $endorsed_html .= '</small><i class="bi bi-check"></i>';
            if (session()->get('usertype') === "instructor") {
                $endorsed_html .= '<a href="';
                $endorsed_html .= base_url() . 'dashboard/course/' . $course_id . '/reply/' . $post_id . '/unendorse/' . $reply['reply_id'];
                $endorsed_html .= '" class="ml-2 btn btn-outline-danger">Unendorse</a>';
            }
            $endorsed_html .= '</div> <div class="card-subtitle mb-1">';
            $endorsed_html .= $reply['content'];
            $endorsed_html .= '</div></div></div>';
        }

        //Unendorsed
        foreach ($unendorsed_reply as $reply) {
            if ($reply['instructor_id']) {
                $reply_author = $reply_model->getAuthor($reply['reply_id'], "instructor");
                $userType = "Instructor";
            } else {
                $reply_author = $reply_model->getAuthor($reply['reply_id'], "student");
                $userType = "Student";
            }
            $unendorsed_html .= '<div class="card my-1 ';

            if ($userType === "Instructor") {
                $unendorsed_html .= "border-primary";
            } else {
                $unendorsed_html .= "border-success";
            }
            $unendorsed_html .= '" id="' . $reply['reply_id'] . '" ';
            $unendorsed_html .= 'style="width: 85vw;"> <div class="card-body"> <div class="card-subtitle mb-2 text-muted h6">';
            $unendorsed_html .= $reply_author;
            if ($userType === "Instructor") {
                $unendorsed_html .= ' (Instructor)';
            }
            $unendorsed_html .= '<small> ';
            $unendorsed_html .= $reply['date_replied'] . ' ' . $reply['time_replied'];
            $unendorsed_html .= '</small>';
            if (session()->get('usertype') === "instructor") {
                // echo '<button class="ml-2 btn btn-outline-warning" onclick="';
                // echo current_url();
                // echo '/endorse">Endorse</button>';
                $unendorsed_html .= '<a href ="';
                $unendorsed_html .= base_url() . 'dashboard/course/' . $course_id . '/reply/' . $post_id . '/endorse/' . $reply['reply_id'];
                $unendorsed_html .= '" class="ml-2 btn btn-outline-warning">Endorse</a>';
            }
            $unendorsed_html .= '</div> <div class="card-subtitle mb-1">';
            $unendorsed_html .= $reply['content'];
            $unendorsed_html .= '</div></div></div>';

        }


        $data['post_id'] = $post_id;
        $data['post_author'] = $post_author;
        $data['post_info'] = $post_info;
        $data['course_id'] = $course_id;
        $data['unendorsed_html'] = $unendorsed_html;
        $data['endorsed_html'] = $endorsed_html;
        $data['unendorsed_reply'] = $unendorsed_reply;
        $data['endorsed_reply'] = $endorsed_reply;

        // print_r($data['unendorsed_reply']);

        echo view('template/header');
        echo view('reply', $data);
        echo view('template/footer');
    }

    public function submit_reply()
    {
        $uri = new \CodeIgniter\HTTP\URI(current_url());
        $reply_model = model('App\Models\Reply_model');
        $post_model = model('App\Models\Post_model');
        $user_model = model('App\Models\User_model');

        $course_id = $uri->getSegment(5);
        $post_id = $uri->getSegment(7);
        $user_id = session()->get('id');
        $usertype = session()->get('usertype');
        $content = $this->request->getPost('content');
        $submit = $reply_model->addReply($post_id, $user_id, $usertype, $content);

        if ($submit) {
            $post_info = $post_model->getPostInfo($post_id);
            if ($post_info['student_id']) {
                $author_id = $post_info['student_id'];
                $author_info = $user_model->getUserData($author_id, 'student');
                $replyer_info = $user_model->getUserData(session()->get('id'), session()->get('usertype'));
                $emailReply = $replyer_info['email'];
                $emailAuthor = $author_info['email'];
                if ($emailAuthor !== $emailReply) {
                    $replyer_name = $replyer_info[session()->get('usertype').'_name'];
                    $to = $emailAuthor;
                    $subject = 'New Reply';
                    $message = "
                        <html>
						<head>
							<title>New Reply</title>
						</head>
						<body>
							<h2>WAHOO!!! It seems that someone replied to your posts.</h2>
                            <p>Reply: ".$content."</p>
                            <p>By: ".$replyer_name."</p>
                            <h4><a href='" . base_url() . "/login'>Click here to open the website</a></h4>
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

            return redirect()->to(base_url('dashboard/course/' . $course_id . '/reply/' . $post_id));
        }
    }

    public function endorse_reply()
    {
        $uri = new \CodeIgniter\HTTP\URI(current_url());
        $reply_model = model('App\Models\Reply_model');
        $course_id = $uri->getSegment(5);
        $post_id = $uri->getSegment(7);
        $status = $uri->getSegment(8);
        $reply_id = $uri->getSegment(9);
        if ($reply_model->endorseChange($reply_id, $status)) {
            return redirect()->to(base_url('dashboard/course/' . $course_id . '/reply/' . $post_id));
        }
    }
}