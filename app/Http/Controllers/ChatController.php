<?php

// FileName                     : ChatController.php                 
// Author               : Sameer Deshpande                    
// Date of Creation     : 26/09/2017                        
// Description          : Course Controller                   
//                          
// Last Modified By         :                        
// Last Modified On     :                       
// Modifications Done       :                   
//                          
// +--------------------------------------------------------------------------------------------------+//                       

namespace App\Http\Controllers;

use App\Model\Chats;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use DB;
use Illuminate\Http\Request;

class ChatController extends Controller
{

    
    /*
    |--------------------------------------------------------------------------
    | Chat Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the management of chats and threads as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    public function index()
    {
        
    }


    public function getChatsList(Request $request)
    {
        //data = {"userid":"3", "postid":"3"}
        
        $data = json_encode($request->input());

        $decodeData = json_decode($data);
        $chatObj = new Chats();

        $page_num = $decodeData->page_num * 10;
        $postid = $decodeData->postid;

        try{
            $getChats = $chatObj->getChatsByPost($postid);    
            return response($getChats,200);
        }
        catch(\Exception $e)
        {
            return response("Bad Request. Please try again",400);
        }
    }


    public function getThreads(Request $request)
    {

        $data = json_encode($request->input());

        $decodeData = json_decode($data);
        $chatObj = new Chats();

        $userid = $decodeData->user_id;
//  $sql = "SELECT * FROM thread where sender =".$userid." or receiver = ".$userid." order by updatedttm desc";

        try{
            $getThreads = $chatObj->getUserThreads($userid);

            $friend = 0;
            if(count($getThreads) > 0)
            {
                for($i = 0; $i < count($getThreads); $i++)
                {
                    if($getThreads[$i]->sender == $userid){
                        $friend = $getThreads[$i]->receiver;
                    }
                    else{
                        $friend = $getThreads[$i]->sender;
                    }
                    $getThreads[$i]->friend = $friend;
                }
            }

            return response($getThreads,200);
        }
        catch(\Exception $e)
        {
            return response($e,400);
        }

    }

    public function getUserThreads(Request $request)
    {
        $data = json_encode($request->input());

        $decodeData = json_decode($data);
        $chatObj = new Chats();

        $userid = $decodeData->user_id;
        $friendid = $decodeData->friendid;
//  $sql = "SELECT * FROM thread where sender =".$userid." or receiver = ".$userid." order by updatedttm desc";

        try{
            $getThreads = $chatObj->getUserFriendThreads($userid,$friendid);

            $friend = 0;
            for($i = 0; $i < count($getThreads); $i++)
            {
                if($getThreads->sender == $userid){
                    $friend = $getThreads->receiver;
                }
                else{
                    $friend = $getThreads->sender;
                }
                $getThreads->friend = $friend;
            }

            return response($getThreads,200);
        }
        catch(\Exception $e)
        {
            return response("Bad Request. Please try again",400);
        }
    }


    public function saveMessage(Request $request)
    {

        $data = json_encode($request->input());

        $decodeData = json_decode($data);
        $chatObj = new Chats();


        $message = $decodeData->message;
        $friend = $decodeData->friend;
        $userid = $decodeData->user_id;
        
        $threadid = 0;
    
        //get the threadId to update if it already exists
        $getThreadId = $chatObj->getThreadId($friend,$userid);
    
        if(count($getThreadId) > 0 && $getThreadId[0]->threadid)
        {
            $threadid = $getThreadId[0]->threadid;
            
            $sqlUpdateArray = array("message" => $message); 
            $sqlUpdate = DB::table('thread')->where('threadid',$threadid)->update($sqlUpdateArray);

        }
        else{

            $sqlInsertArray = array("message" => $message, "sender" => $userid, "receiver" => $friend);
            $threadid = DB::table('thread')->insertGetId($sqlInsertArray);
        }
        
            $sqlInsertMsgArr = array("threadid" => $threadid, "msg" => $message, "sender" => $userid);
            $messageid = DB::table('message')->insertGetId($sqlInsertMsgArr);

        if (isset($messageid)){
            $permission = 1;
            $device = '';
            $sql = "SELECT pushkey, permissionAccepted, device FROM users where userid=".$friend;
            $getUserDetails = DB::select($sql);

            if (count($getUserDetails) > 0){
                    $deviceToken = $getUserDetails[0]->pushkey;
                    $permission = $getUserDetails[0]->permissionAccepted;
                    $device = $getUserDetails[0]->device;
                }
            }

            $sql = "SELECT concat(firstname,' ', lastname) as name FROM users where userid =".$userid;
            $getPushMsgUserName = DB::select($sql);

            if ($getPushMsgUserName){
                    $message = "New message from ".$getPushMsgUserName[0]->name;
            }
            if($permission==1){
                if($device=='ios'){
                    //sendSinglePushMessage($deviceToken,$message,'message',$threadid);
                }
                else{
                    //sendSingleAndroidPushMessage($deviceToken,$message,'message',$threadid,$userid);
                }
            }
    }

     public function getComments(Request $request)
    {
        $data = json_encode($request->input());

        $decodeData = json_decode($data);
        $chatObj = new Chats();

        $postid = $decodeData->postid;

        try{
            $getComments = $chatObj->getComments($postid);    
            return response($getComments,200);
        }
        catch(\Exception $e)
        {
            return response("Bad Request. Please try again",400);
        }

    }

    public function getThreadMessage(Request $request)
    {

        $data = json_encode($request->input());

        $decodeData = json_decode($data);
        $chatObj = new Chats();

        $threadid = $decodeData->threadid;
        $messageid = $decodeData->messageid;
    
    
        if(!isset($messageid)){
            $messageid = 0;
        }
    
        try{
            $getThreadMessage = $chatObj->getThreadMessage($threadid,$messageid);    
            return response($getThreadMessage,200);
        }
        catch(\Exception $e)
        {
            return response($e,400);
        }
        
    }
}
