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


class Student extends Model {

	
	public function createStudent($data)
	{
		$insertArray = array('title' => $data['title'], 'description' => $data['description'], 'duedate' => $data['duedate'], 'userid' => $data['userid'], 'courseid' => $data['courseid']);

		return DB::table('assignment')->insertGetId($insertArray);
	}

	public function getAssignmentList($userType,$courseid,$userid)
	{

		if($userType == 2){ //instructor
        	if($courseid < 1){
            
            	$sql = "SELECT a.assignmentid, u.course, a.courseid, a.description, DATE_FORMAT(duedate, '%Y-%m-%d %H:%i') AS duedate, a.title, u.userid FROM user_course u, assignment a where u.ucid = a.courseid and u.userid = ".$userid." order by duedate asc";
        	}
        	else{
            	$sql = "SELECT a.assignmentid, u.course, a.courseid, a.description, DATE_FORMAT(duedate, '%Y-%m-%d %H:%i') AS duedate, a.title, u.userid FROM user_course u, assignment a where u.ucid = a.courseid and a.courseid = ".$courseid." and u.userid = ".$userid." order by duedate asc";
        	}
    	}
    	else{ //student
        $sql = "select a.assignmentid, u.course, a.courseid, a.description, DATE_FORMAT(duedate, '%Y-%m-%d %H:%i') AS duedate, a.title, u.userid from assignment a, user_course u where u.ucid = a.courseid and courseid in (SELECT ucid FROM student_course where userid = ".$userid." and duedate >= CURDATE()) order by duedate asc";
    	}

    	return DB::select($sql);	

	}

	public function getStudentCourse($userid)
	{
		$sql = "SELECT s.scid, uc.ucid, uc.course, uc.userid, uc.expirydate, u.firstname, lastname FROM student_course s, user_course uc, users u where uc.ucid = s.ucid and u.userid = uc.userid and s.userid = ".$userid." and uc.expirydate >= CURDATE()";

		return DB::select($sql);
	}

	public function getUserCourseIds($userid)
	{
		$sql = "SELECT ucid FROM user_course where userid = ".$userid;
		return DB::select($sql);
	}

	public function getUserCourse($courseid)
	{
		$sql = "SELECT ucid FROM user_course where ucid =".$courseid;
		return DB::select($sql);
	}

	public function getStudents($userid,$arrUserCourse)
	{
		$sql = "SELECT users.userid, firstname, lastname, email, course, user_course.ucid FROM user_course, student_course, users where users.userid!=".$userid." and users.userid= student_course.userid and user_course.ucid = student_course.ucid and user_course.ucid in (".implode(',',$arrUserCourse).") order by course";

		return DB::select($sql);
	}

	public function deleteStudentCourse($scid)
	{
		return DB::table('student_course')->where('scid',$scid)->delete();
	}

	public function createStudentCourse($userid,$courseid)	
	{
		$sql = "insert into student_course(userid, ucid) values(".$userid.",".$courseid.")";
		return DB::select(DB::raw($sql));
	}

	private function getSchools($school)
	{
		if($school > 0) {
    		$sql = "SELECT * FROM school where school_name like '%".$school."%' order by school_name ";
		}else{
    		$sql = "SELECT * FROM school order by school_name";
		}
		return DB::select($sql);
	}

}