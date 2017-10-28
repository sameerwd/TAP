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


}
