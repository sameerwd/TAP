<?php

// FileName                     : PostController.php                 
// Author               : Sameer Deshpande                    
// Date of Creation     : 26/09/2017                        
// Description          : Post Controller                   
//                          
// Last Modified By         :                        
// Last Modified On     :                       
// Modifications Done       :                   
//                          
// +--------------------------------------------------------------------------------------------------+//                       

namespace App\Http\Controllers;

use App\Model\Post;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{

	//The index method
	public function index()
	{

	}


	/*
		Listing of the posts
	*/
	public function getPosts(Request $request)
	{
		$data = json_encode($request->input());

        $decodeData = json_decode($data);
        $postObj = new Post();

        $userid = $decodeData->userid;

        try{
            $getPosts = $postObj->getPosts($userid);    
            return response($getPosts,200);
        }
        catch(\Exception $e)
        {
            return response("Bad Request. Please try again",400);
        }
	}


	public function submitPost(Request $request)
	{
		$data = json_encode($request->input());

        $decodeData = json_decode($data);
        $postObj = new Post();

        $userid = $decodeData->userid;
        $post = $decodeData->post;
        $type = $decodeData->type;
		
		// post =1 for text, =2 text and image
		$insertArray = array('post' => $post, 'type' => $type, 'userid' => $userid, 'status' => 1);
		$getSubmitPost = $postObj->insertSubmitPost($insertArray);
		
		
		//$userid = $_POST['userid'];
		//$usertype = $_POST['usertype'];
		//include(sendPostNotification.php);
		$sendPost = $postObj->sendPostNotfication($userid);

	if($type==2){
		$target_dir = "pictures/";
		
		$newfilename = $target_dir.$postid . '.jpg';

		if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $newfilename)) {
			return response()->json(['message' => 'File Uploaded', 'status' => 200]);
		} else {
			file_put_contents($newfilename, base64_decode($_POST['userfile']));
			 return response()->json(['message' => 'Bad Request, Please try again', 'status' => 400]);
			}
		}
	}
	
	
}