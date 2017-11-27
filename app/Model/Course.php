<?php 
namespace App\Model;
use Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use App\Model\User;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;


class Course extends Model {

	public function createCourse($course,$data)
	{
		$insertArray = array('course' => $course, 'userid' => $data->user_id, 'expirydate' => $data->expiry);
		return DB::table('user_course')->insertGetId($insertArray);
	}

	public function checkValidCourseId($course)
	{
		return DB::select("SELECT ucid FROM user_course where ucid = ".$course);
	}

	public function createStudentCourse($userid,$course)
	{
		$insertArray = array('userid' => $userid, 'ucid' => $course);
		return DB::table('student_course')->insertGetId($insertArray);
	}

	public function checkValidStudentCourseId($ucid,$userid)
	{
		return DB::select("SELECT * FROM student_course where ucid =".$ucid." and userid = ".$userid);
	}

	public function updateStudentCourse($ucid,$scid)
	{
        $updateArray = array('ucid' => $ucid);
        return DB::table('student_course')->where('scid',$scid)->update($updateArray);
	}

	public function resetStudentCourse($ucid)
	{
		return DB::table('student_course')->where('ucid',$ucid)->update(array("expirydate" => date("dd/MM/yy H:i:s")));
	}

	public function deleteStudentCourse($ucid)
	{
        return DB::table('student_course')->where('ucid',$ucid)->delete();
	}

	public function deleteInstructorCourse($ucid)
	{
		return DB::table('user_course')->where('ucid',$ucid)->delete();
	}

	public function updateInstructorCourse($course,$expiry,$userid,$ucid)
	{
		$sql = "update user_course set course = '".$course."', expirydate = '".$expiry."', userid = ".$userid." where ucid = ".$ucid;

		return DB::select(DB::raw($sql));
	}

	public function getStudentCourse($user_id,$ucid)
	{
		return DB::table('student_course AS sc')->join('user_course AS uc','sc.ucid','=','uc.ucid')->where('sc.userid',$user_id)->where('sc.ucid',$ucid)->get();
	}

	public function getInstructorCourse($user_id)
	{
		return DB::table('user_course')->where('userid',$user_id)->get();	
	}

}