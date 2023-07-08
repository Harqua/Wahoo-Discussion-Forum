<?php

namespace App\Models;

use CodeIgniter\Model;

class User_model extends Model
{
    public function login($username, $password, $usertype)
    {
        $role = $usertype;
        $db = \Config\Database::connect();

        $encrypt = hash('sha256', $password);

        if ($usertype === 'student') {
            $builder = $db->table('Student');
            $builder->where('student_username', $username);
            $builder->where('password', $encrypt);
        } else if ($usertype === 'instructor') {
            $builder = $db->table('Instructor');
            $builder->where('instructor_username', $username);
            $builder->where('password', $encrypt);
        }
        $query = $builder->get();
        $row = $query->getRowArray();
        if ($row) {
            return $row[$role . '_id'];
            // return true;
        } else {
            return false;
        }

    }
    public function register($username, $name, $email, $password, $usertype)
    {
        $db = \Config\Database::connect();

        $set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$code = substr(str_shuffle($set), 0, 12);
        $encrypt = hash('sha256', $password);

        if ($usertype === 'student') {
            $data = [
                'student_username' => $username,
                'password' => $encrypt,
                'student_name' => $name,
                'email' => $email,
                'code' => $code,
                'verify' => 0
            ];
            $builder = $db->table('Student');


        } else if ($usertype === 'instructor') {
            $data = [
                'instructor_username' => $username,
                'password' => $encrypt,
                'instructor_name' => $name,
                'email' => $email,
                'code' => $code,
                'verify' => 0
            ];
            $builder = $db->table('Instructor');

        }
        try {
            $builder->insert($data);
            return null;
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            return $e->getCode();
        }
    }

    public function verifyStatus($id,$usertype){
        $db = \Config\Database::connect();
        if ($usertype === 'student') {
            $builder = $db->table('Student');
            $builder->select('verify');
            $builder->where('student_id', $id);
        } else if ($usertype === 'instructor') {
            $builder = $db->table('Instructor');
            $builder->select('verify');
            $builder->where('instructor_id', $id);

        }
        $query = $builder->get();
        $verifyStatus = $query->getRowArray();
        return $verifyStatus;
    }

    public function getCode($email,$usertype){
        $db = \Config\Database::connect();
        if ($usertype === 'student') {
            $builder = $db->table('Student');
            $builder->select('student_id, code');
            $builder->where('email', $email);
        } else if ($usertype === 'instructor') {
            $builder = $db->table('Instructor');
            $builder->select('instructor_id, code');
            $builder->where('email', $email);

        }
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function activate($id,$usertype,$code){
        $db = \Config\Database::connect();

        $data = array(
            'code' => NULL,
            'verify' => 1
        );
        
        if ($usertype === 'student') {
            $builder = $db->table('Student');
            $builder->where('student_id', $id);

        } else if ($usertype === 'instructor') {
            $builder = $db->table('Instructor');
            $builder->where('instructor_id', $id);
        }
        else{
            return false;
        }
        $query = $builder->get()->getRowArray();
        if($query['code'] === $code){
            $builder->update($data);
            return true;
        }
        else{
            return false;
        }
    }

    public function emailexist($email, $usertype)
    {
        $db = \Config\Database::connect();
        if ($usertype === 'student') {
            $builder = $db->table('Student');
            $builder->where('email', $email);
        } else if ($usertype === 'instructor') {
            $builder = $db->table('Instructor');
            $builder->where('email', $email);

        }
        $query = $builder->get();
        if ($query->getRowArray()) {
            return true;
        }
        return false;
    }

    public function profileUpdate($userId, $usertype, $newName, $newPass)
    {

        $db = \Config\Database::connect();


        // check if there is new password
        if ($newPass == '') {
            
            $data = array(
                $usertype.'_name' => $newName
            );
        } else {
            $encrypt = hash('sha256', $newPass);
            $data = array(
                $usertype.'_name' => $newName,
                'password' => $encrypt
            );
        }

        //check student or instructor
        if ($usertype === 'student') {
            $builder = $db->table('Student');
            $builder->where('student_id', $userId);
            $builder->update($data);
            return true;
        } else if ($usertype === 'instructor') {
            $builder = $db->table('Instructor');
            $builder->where('instructor_id', $userId);
            $builder->update($data);
            return true;
        }
        else{
            return false;
        }
        
    }

    public function getUserData($id, $usertype)
    {
        $db = \Config\Database::connect();
        if ($usertype === 'student') {
            $builder = $db->table('Student');
            $builder->where('student_id', $id);
        } else if ($usertype === 'instructor') {
            $builder = $db->table('Instructor');
            $builder->where('instructor_id', $id);

        }
        $query = $builder->get();
        $user_row_data = $query->getRowArray();
        if ($user_row_data) {
            return $user_row_data;
        }
    }

    public function accountReset($email, $newPass, $usertype){
        $db = \Config\Database::connect();
        $encrypt = hash('sha256', $newPass);
        $data = array(
            'password' => $encrypt
        );
        if ($usertype === 'student' && $usertype !== 'instructor') {
            $builder = $db->table('Student');
            $builder->where('email', $email);
        } else if ($usertype === 'instructor' && $usertype != 'student') {
            $builder = $db->table('Instructor');
            $builder->where('email', $email);
        }
        $builder->update($data);
        return true;
        
    }
}