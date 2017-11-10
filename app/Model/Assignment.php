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


class Assignment extends Model {

	
	public function createAssignment($data)
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

	public function getAssignmentByMonth($month,$year,$userid)
	{
		$sql = "SELECT a.assignmentid, u.course, a.courseid, a.description, DATE_FORMAT(duedate, '%Y-%m-%d %H:%i') AS duedate, a.title, u.userid FROM user_course u, assignment a where u.ucid = a.courseid and duedate > CURDATE() and MONTH(duedate) = ".$month." and YEAR(duedate) = ".$year." and u.userid = ".$userid." order by duedate asc";

		return DB::select($sql);
	}

	public function deleteAssignment($asid)
	{
		return DB::table('assignment')->where('assignmentid',$asid)->delete();
	}


}
