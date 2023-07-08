<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\RawSql;

class Reply_model extends Model
{
    public function getAllReply($post_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('Reply');
        $builder->where('endorse', 0)
            ->where('post_id', $post_id)
            ->orderBy('date_replied DESC, time_replied DESC');
        $query = $builder->get();
        $all_row_data = $query->getResultArray();

        return $all_row_data;

    }

    public function getEndorsedReply($post_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('Reply');
        $builder->where('endorse', 1)
            ->where('post_id', $post_id)
            ->orderBy('date_replied DESC, time_replied DESC');
        $query = $builder->get();
        $all_row_data = $query->getResultArray();

        return $all_row_data;
    }

    public function getAuthor($replyid, $usertype)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('Reply');
        if ($usertype === 'instructor') {
            $builder->select('Instructor.instructor_name')
                ->join('Instructor', 'Reply.instructor_id = Instructor.instructor_id')
                ->where('Reply.reply_id', $replyid);


        } else if ($usertype === 'student') {
            $builder->select('Student.student_name')
                ->join('Student', 'Reply.student_id = Student.student_id')
                ->where('Reply.reply_id', $replyid);
        }
        $query = $builder->get();
        $username = $query->getRowArray()[$usertype . '_name'];
        return $username;


    }

    public function addReply($post_id, $user_id, $usertype, $content)
    {
        $db = \Config\Database::connect();
        date_default_timezone_set("Australia/Brisbane");
        $currentDate = date("Y-m-d");
        $currentTime = date("H:i:s");
        $builder = $db->table('Reply');

        if ($usertype === 'instructor') {
            $info = [
                'content' => $content,
                'time_replied' => $currentTime,
                'date_replied' => $currentDate,
                'endorse' => 0,
                'instructor_id' => $user_id,
                'post_id' => $post_id
            ];
        } else {
            $info = [
                'content' => $content,
                'time_replied' => $currentTime,
                'date_replied' => $currentDate,
                'endorse' => 0,
                'student_id' => $user_id,
                'post_id' => $post_id
            ];
        }

        if ($builder->insert($info)) {
            return true;
        } else {
            return false;
        }
    }

    public function endorseChange($id,$status){
        $db = \Config\Database::connect();
        $builder = $db->table('Reply');
        if($status === 'unendorse'){
            $data = [
                'endorse' => 0,
            ];
        }
        else{
            $data = [
                'endorse' => 1,
            ];
        }
        $builder->where('reply_id', $id);
        $builder->update($data);
        return true;
    }
}