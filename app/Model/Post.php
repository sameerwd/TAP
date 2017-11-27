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


class Chats extends Model {


	private function getPosts($userid)
	{	

		$userType = 1;

		if($userid)
		{
			$sql = "SELECT p.*,COALESCE((
		        SELECT COUNT( * ) FROM comments WHERE postid = p.postid 
		    ), 0 ) AS cnt, COALESCE(( 
		        SELECT CONCAT( firstname, ' ', lastname ) FROM users u WHERE u.userid = p.userid 
		   ), 'N/A' ) AS `name` FROM posts p JOIN comments c ON p.userid = ".$userid." and userType = ".$userType." group by p.postid order by postid desc";
		   
		}
		else{
			$sql = "SELECT p.*,COALESCE((
		        SELECT COUNT( * ) FROM comments WHERE postid = p.postid 
		    ), 0 ) AS cnt, COALESCE(( 
		        SELECT CONCAT( firstname, ' ', lastname ) FROM users u WHERE u.userid = p.userid 
		   ), 'N/A' ) AS `name` FROM posts p LEFT JOIN comments c ON p.postid = c.postid and userType = ".$userType." group by p.postid order by postid desc";
		}

		return DB::select($sql);

	}

}