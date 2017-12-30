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

class PostController extends Controller
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
            if(count($getPosts) > 0)    
            	return response()->json(['message' => 'Posts', 'data'=> $getPosts,'status' => 200]);
            else
            	return response()->json(['message' => 'No Posts Found', 'status' => 1012]);
        }
        catch(\Exception $e)
        {
            return response($e,400);
        }
	}


	public function submitPost(Request $request)
	{
		$data = json_encode($request->input());

        $decodeData = json_decode($data);
        $postObj = new Post();

        $userid = $decodeData->userid;
        $post = $decodeData->post;
        $type = $decodeData->usertype;
        $userFile = $decodeData->userFile;
		
		// post =1 for text, =2 text and image
		$insertArray = array('post' => $post, 'type' => $type, 'userid' => $userid, 'status' => 1);
		$getSubmitPost = $postObj->insertSubmitPost($insertArray);
		
		try{	

			$sendPost = $postObj->sendPostNotfication($userid);

			if($type==2){
				$target_dir = "/pictures/";
			
			$newfilename = public_path().$target_dir.$getSubmitPost.'.jpg';

			if (isset($_FILES["userfile"]["tmp_name"]) && move_uploaded_file($_FILES["userfile"]["tmp_name"], $newfilename)) {
				return response()->json(['message' => 'Post Submitted', 'status' => 200]);
			} else {
				file_put_contents($newfilename, base64_decode($userFile));
				 return response()->json(['message' => 'Post Submitted', 'status' => 200]);
				}
			}
			else
				return response()->json(['message' => 'Post Submitted', 'status' => 200]);	

		}catch(\Exception $e){

			return response($e,400);
		}

	}
	
}