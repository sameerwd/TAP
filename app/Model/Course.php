<?php 
namespace App\Model;
use Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use App\Model\AuditAnswer;
use App\Model\Organization;
use App\Model\User;
use App\Model\TrackCar;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;


class Course extends Model {

	public function createCourse($data)
	{

		$insertArray = $array('course' => $data['course'], 'userid' => $data['userid'], 'expirydate' => $data['expiry']);
		return DB::table('course')->insertGetId($insertArray);
	}

	public function checkValidCourseId($course)
	{
		return DB::select("SELECT ucid FROM user_course where ucid = ".$course);
	}

	public function createStudentCourse($userid,$course)
	{
		$insertArray = $array('userid' => $userid, 'ucid' => $course);
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

}