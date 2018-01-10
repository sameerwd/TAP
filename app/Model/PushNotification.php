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


class PushNotification extends Model {


	public function setPushPermission($userid,$permission)
	{
		return DB::table('users')->where('userid',$userid)->update(array('permissionAccepted' => $permission));
	}


	public function sendPostNotfication($userid,$ucid)
	{
		$sql = "select userid, title, firstname, lastname, usertype from users where userid = ".$userid." and status = 1";
		$getUserForNotification = DB::select($sql);
		$user = "";
		if ($getUserForNotification > 0)
		{
				if($getUserForNotification[0]->usertype == 2){//send notification to all students
					$user = $getUserForNotification[0]->title . " " . $getUserForNotification[0]->firstname . " " . $getUserForNotification[0]->lastname;
					
					$sql = "SELECT distinct users.userid, firstname, lastname, userType, title, device, pushkey, permissionAccepted FROM student_course, users where users.userid!=".$userid." and users.userid= student_course.userid and ucid= ".$ucid." ORDER BY firstname";
					
					$getAllStudentsForNot = DB::select($sql);

					$arrUsersIOS = array();
					$arrUsersAndroid = array();
					$arrUsersPermissionsIOS = array();
					$arrUsersPermissionsAndroid = array();
					$permission = 1;
					
					if(count($getAllStudentsForNot) > 0)
					{
						foreach ($getAllStudentsForNot as $student) {
							$device = $student->device;
                            if($device=="ios"){
								$deviceToken = $student->pushkey;
								$permission = $student->permissionAccepted;
								array_push($arrUsersIOS,$deviceToken);
								array_push($arrUsersPermissionsIOS,$permission);
							}
							else if($device=="android"){
								$deviceToken = $student->pushkey;
								$permission = $student->permissionAccepted;
								if($permission==1){
									array_push($arrUsersAndroid,$deviceToken);
								}
							}
						}
					}
					if(count($arrUsersIOS)>0){
						$message = "New assignment added on TAP from ".$user;
						//echo $arrUsersIOS;
						//echo $arrUsersPermissionsIOS;
						sendPush($arrUsersIOS,$message,'assignment',$arrUsersPermissionsIOS);
					}
					else if(count($arrUsersAndroid)>0){
						$message = "New assignment added on TAP from ".$user;
						//echo $arrUsersIOS;
						//echo $arrUsersPermissionsIOS;
						
						sendPushAndroid($arrUsersAndroid, array('message' => $message));
					}
				}
		}	
	}
	

	private function saveDeviceKey($deviceid,$type,$siteid,$userid)
	{
		$sql = "insert into token(deviceid,os,siteid,userid) values(".$deviceid.",'".$type."',".$siteid.",".$userid.")";
		return DB::select(DB::raw($sql));
	}


	private function savePushKey($pushkey,$os,$device,$userid)
	{
		$sql = "update users set pushkey = ".$pushkey." and os = ".$os." and ".$device." where userid =".$userid;
		return DB::select(DB::raw($sql));
	}

	public function getDeviceKey($device)
	{
		return DB::table('users')->where('userid',$device)->pluck('pushkey');
	}	


	public function sendPush($users, $notification, $type, $permission)
    {
            $getDeviceKey = this->getDeviceKey($device);

            $optionBuilder = new OptionsBuilder();
            $optionBuilder->setTimeToLive(60*20);

            $notificationBuilder = new PayloadNotificationBuilder('Assignment');
            $notificationBuilder->setBody($notification)
                                ->setSound('default');

            $dataBuilder = new PayloadDataBuilder();
            $dataBuilder->addData(['a_data' => 'my_data']);

            $option = $optionBuilder->build();
            $notification = $notificationBuilder->build();
            $data = $dataBuilder->build();

            $token = "";

            $downstreamResponse = FCM::sendTo($getDeviceKey, $option, $notification, $data);

            $downstreamResponse->numberSuccess();
            $downstreamResponse->numberFailure();
            $downstreamResponse->numberModification();

            //return Array - you must remove all this tokens in your database
            $downstreamResponse->tokensToDelete();

            //return Array (key : oldToken, value : new token - you must change the token in your database )
            $downstreamResponse->tokensToModify();

            //return Array - you should try to resend the message to the tokens in the array
            $downstreamResponse->tokensToRetry();       
    }


    public function sendMultiplePush($users, $notification, $type, $permission)
    {
    		$getDeviceKey = array();
    		foreach($users as $user)
    		{
    			$getDeviceKey[] = this->getDeviceKey($user);	
    		}
    		

            $optionBuilder = new OptionsBuilder();
            $optionBuilder->setTimeToLive(60*20);

            $notificationBuilder = new PayloadNotificationBuilder('Assignment');
            $notificationBuilder->setBody($notification)
                                ->setSound('default');

            $dataBuilder = new PayloadDataBuilder();
            $dataBuilder->addData(['a_data' => 'my_data']);

            $option = $optionBuilder->build();
            $notification = $notificationBuilder->build();
            $data = $dataBuilder->build();

            $token = "";

    	$downstreamResponse = FCM::sendTo($getDeviceKey, $option, $notification, $data);

		$downstreamResponse->numberSuccess();
		$downstreamResponse->numberFailure();
		$downstreamResponse->numberModification();

		//return Array - you must remove all this tokens in your database
		$downstreamResponse->tokensToDelete();

		//return Array (key : oldToken, value : new token - you must change the token in your database )
		$downstreamResponse->tokensToModify();

		//return Array - you should try to resend the message to the tokens in the array
		$downstreamResponse->tokensToRetry();

		// return Array (key:token, value:errror) - in production you should remove from your database the tokens present in this array
		$downstreamResponse->tokensWithError();
    }
}