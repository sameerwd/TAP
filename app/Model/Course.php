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


	/*public function checkValidCourseId()
	{
		"SELECT ucid FROM user_course where ucid =".$course." and expirydate >= CURDATE()";
	}*/

	public function checkStudentCourse($courses,$user_id)
	{
		return DB::select("SELECT ucid FROM student_course where ucid = ".$courses." AND userid =".$user_id."");
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

	public function updateStudentCourse($ucid,$user_id)
	{
        $updateArray = array('ucid' => $ucid);
        return DB::table('student_course')->where('userid',$user_id)->update($updateArray);
	}

	public function resetStudentCourse($ucid)
	{
		return DB::table('student_course')->where('ucid',$ucid)->update(array("expirydate" => date("dd/MM/yy H:i:s")));
	}

	public function deleteStudentCourse($ucid,$user_id,$course)
	{
        return DB::table('student_course')->where('ucid',$ucid)->where('userid',$user_id)->delete();
	}

	public function checkInstructorCourse($course)
	{
		return DB::table('user_course')->where('course',$course)->pluck('ucid');
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
		return DB::table('student_course AS sc')->join('user_course AS uc','sc.ucid','=','uc.ucid')->join('users AS u','sc.userid','=','u.userid')->where('sc.userid',$user_id)->get();
	}

	public function getInstructorCourse($user_id)
	{
		return DB::table('user_course AS uc')->join('users AS u','uc.userid','=','u.userid')->where('u.userid',$user_id)->select('uc.*','u.firstName','u.lastName')->get();	
	}

	public function checkInstructorCourse1($course)
	{
		return DB::table('user_course')->where('course',$course)->count();
	}

	public function checkExistingStudentCourseId($course,$user_id)
	{
		return DB::select("SELECT * FROM student_course where ucid =".$course." and userid = ".$user_id."");
	}

}