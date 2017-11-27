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


class Chats extends Model{

		public function getChats($postid)
		{
			$sql = "SELECT c.*, u.firstname, u.lastname FROM comments c, users u where c.userid = u.userid and postid = ".$postid." order by commentid";

			return DB::select($sql);	
		}

		public function getComments()
		{
			$sql = "SELECT c.*, u.firstname, u.lastname FROM comments c, users u where c.userid = u.userid and postid = ".$postid." order by commentid";

			return DB::select($sql);
		}

		public function getUserThreads($userid)
		{
			$sql = "SELECT t.*,CONCAT(usend.firstname, ' ', usend.lastname) sender_name, CONCAT(urec.firstname, ' ', urec.lastname) receiver_name
            FROM thread t
            JOIN users usend on usend.userid = t.sender
            JOIN users urec on urec.userid = t.receiver
            where sender = ".$userid." or receiver = ".$userid."
            order by updatedttm desc";

            return DB::select($sql);
		}


		public function getUserFriendThreads($userid,$friendid)
		{
			$sql = "SELECT t.*,CONCAT(usend.firstname, ' ', usend.lastname) sender_name, CONCAT(urec.firstname, ' ', urec.lastname) receiver_name
			FROM thread t
			JOIN users usend on usend.userid = t.sender
			JOIN users urec on urec.userid = t.receiver
			where (sender = ".$userid." and receiver = ".$friendid.") or (sender = ".$friendid." and receiver = ".$userid.")";

			return DB::select($sql);
		}

		public function getThreadMessage($threadid,$messageid)
		{
			if($messageid>0){
        		$sql = "SELECT * FROM message where threadid =".$threadid." and msgid > ".$messageid." order by createdt asc";
    		}
    		else{
        		$sql = "SELECT * FROM message where threadid =".$threadid." order by createdt asc";
    		}

    		return DB::select($sql);

		}

		public function getThreadId($friend,$userid)
		{
			$sql = "SELECT threadid FROM thread where (sender =".$friend." and receiver = ".$userid.") or (sender =".$userid." and receiver = ".$friend.")";

			return DB::select($sql);
		}
}
