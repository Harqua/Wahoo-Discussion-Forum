<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\RawSql;

class Course_model extends Model
{
    public function create($coursecode, $coursename, $instructorid)
    {
        $db = \Config\Database::connect();
        date_default_timezone_set("Australia/Brisbane");
        $currentDate = date("Y-m-d");
        $currentTime = date("H:i:s");
        $uppercoursecode = strtoupper($coursecode);
        $info = [
            'course_code' => $uppercoursecode,
            'course_name' => $coursename,
            'date_created' => $currentDate,
            'time_created' => $currentTime,
            'instructor_id' => $instructorid
        ];
        $builder = $db->table('Course');

        try {
            $builder->insert($info);
            return null;
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            return $e->getCode();
        }

        // return false;
    }


    public function getAllCourse($studentid)
    {
        $db = \Config\Database::connect();
        $sql= "course_id NOT IN (SELECT course_id FROM StudentCourse WHERE student_id=".$studentid.");";
        $builder = $db->table('Course');
        $builder->where(new RawSql($sql));
        $query = $builder->get();
        $all_row_data = $query->getResultArray();

        if ($all_row_data) {
            return $all_row_data;
        }
    }

    public function joinCourse($studentid,$courseid)
    {
        $db = \Config\Database::connect();
        $currentDate = date("Y-m-d");
        $data = [
            'date_joined' => $currentDate,
            'student_id' => $studentid,
            'course_id' => $courseid
        ];
        $builder = $db->table('StudentCourse');
        $builder->insert($data);
        return true;
        
    }


    public function getCourseData($id, $usertype)
    {
        $db = \Config\Database::connect();
        // if ($usertype === 'student') {
        //     $builder = $db->table('Student');
        //     $builder->where('student_id',$id);
        // } 

        if ($usertype === 'instructor') {
            $builder = $db->table('Course');
            $builder->where('instructor_id', $id);
            $query = $builder->get();
            $user_row_data = $query->getResultArray();

            if ($user_row_data) {
                return $user_row_data;
            }


        } else if ($usertype === 'student') {
            $builder = $db->table('StudentCourse');
            $builder->select('Course.course_id, Course.course_code, Course.course_name, Instructor.instructor_name, StudentCourse.date_joined')
                ->join('Course', 'Course.course_id = StudentCourse.course_id')
                ->join('Instructor', 'Course.instructor_id = Instructor.instructor_id')
                ->where('student_id', $id);
            $query = $builder->get();
            $user_row_data = $query->getResultArray();

            if ($user_row_data) {
                return $user_row_data;
            }
        }
    }

    public function courseInfo($course_id){
        $db = \Config\Database::connect();
        $builder = $db->table('Course');
        $builder->where("course_id",$course_id);
        return $builder->get()->getRowArray();
    }

}