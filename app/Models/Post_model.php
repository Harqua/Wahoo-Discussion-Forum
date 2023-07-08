<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\RawSql;

class Post_model extends Model
{
    public function getPostInstructor($courseid)
    {
        $db = \Config\Database::connect();
        $sql = 'course_id =' . $courseid . '&& instructor_id is not null order by date_posted desc, time_posted desc;';
        $builder = $db->table('Post');
        $builder->where(new RawSql($sql));
        $query = $builder->get();
        $all_row_data = $query->getResultArray();

        if ($all_row_data) {
            return $all_row_data;
        }


    }

    public function getPostStudent($courseid)
    {
        $db = \Config\Database::connect();
        $sql = 'course_id =' . $courseid . '&& student_id is not null order by date_posted desc, time_posted desc;';
        $builder = $db->table('Post');
        $builder->where(new RawSql($sql));
        $query = $builder->get();
        $all_row_data = $query->getResultArray();

        if ($all_row_data) {
            return $all_row_data;
        }
    }

    public function getTrendingPost($courseid)
    {
        // select post_id
        // from StudentLike
        // where post_id in (select post_id from Post where course_id = 22)
        // group by post_id
        // order by count(*) DESC
        // limit 3;
        $db = \Config\Database::connect();
        $sql = 'post_id in (select post_id from Post where course_id =' . $courseid . ') group by post_id order by count(*) DESC limit 3;';
        $builder = $db->table('StudentLike');
        $builder->select('post_id');
        $builder->where(new RawSql($sql));
        $query = $builder->get();
        $all_row_data = $query->getResultArray();

        if ($all_row_data) {
            return $all_row_data;
        }
    }

    public function getAuthor($postid, $usertype)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('Post');
        if ($usertype === 'instructor') {
            $builder->select('Instructor.instructor_name')
                ->join('Instructor', 'Post.instructor_id = Instructor.instructor_id')
                ->where('Post.post_id', $postid);


        } else if ($usertype === 'student') {
            $builder->select('Student.student_name')
                ->join('Student', 'Post.student_id = Student.student_id')
                ->where('Post.post_id', $postid);
        }
        $query = $builder->get();
        $username = $query->getRowArray()[$usertype . '_name'];
        return $username;


    }


    public function addPost($courseid, $userid, $usertype, $title, $content, $picfile)
    {

        $db = \Config\Database::connect();
        date_default_timezone_set("Australia/Brisbane");
        $currentDate = date("Y-m-d");
        $currentTime = date("H:i:s");
        $builder = $db->table('Post');

        if ($picfile) {
            $picfile->move(WRITEPATH . 'uploads');
            $filename = $picfile->getName();
        } else {
            $filename = null;
        }


        if ($usertype === 'instructor') {
            $info = [
                'title' => $title,
                'content' => $content,
                'filename' => $filename,
                'time_posted' => $currentTime,
                'date_posted' => $currentDate,
                'instructor_id' => $userid,
                'course_id' => $courseid,
            ];
        } else {
            $info = [
                'title' => $title,
                'content' => $content,
                'filename' => $filename,
                'time_posted' => $currentTime,
                'date_posted' => $currentDate,
                'student_id' => $userid,
                'course_id' => $courseid
            ];
        }


        if ($builder->insert($info)) {

            return true;
        } else {
            return false;
        }
    }

    public function getEmail($course_id)
    {
        // select email
        // from Student
        // where student_id in (select student_id from StudentCourse where course_id = 22);
        $db = \Config\Database::connect();
        $sql = 'student_id in (select student_id from StudentCourse where course_id ='. $course_id .')';
        $builder = $db->table('Student');
        $builder->select('email');
        $builder->where(new RawSql($sql));
        $query = $builder->get();
        $email= $query->getResultArray();
        return $email;
    }

    public function getPostInfo($post_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('Post');
        $builder->where('post_id', $post_id);
        $query = $builder->get();
        $post_info = $query->getRowArray();
        return $post_info;
    }

    public function likePost($id, $post_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('StudentLike');

        $builder->where('student_id', $id);
        $builder->where('post_id', $post_id);
        $check = $builder->get()->getRowArray();
        if ($check) {
            $info = [
                'student_id' => $id,
                'post_id' => $post_id,
            ];
            if ($builder->delete($info)) {
                return true;
            } else {
                return false;
            }
        } else {
            $info = [
                'student_id' => $id,
                'post_id' => $post_id,
            ];

            if ($builder->insert($info)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function checkLike($id, $post_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('StudentLike');

        $builder->where('student_id', $id);
        $builder->where('post_id', $post_id);
        $check = $builder->get()->getRowArray();
        if ($check) {
            return true;
        } else {
            return false;
        }
    }

    public function countLike($post_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('StudentLike');
        $builder->selectCount('post_id');
        $builder->where('post_id', $post_id);
        $count = $builder->get()->getRowArray()['post_id'];
        return $count;
    }

    public function allLiked($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('StudentLike');
        $builder->select('post_id');
        $builder->where('student_id', $id);
        $query = $builder->get();
        $result = $query->getResultArray();
        return $result;
    }

}