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

class UserController extends Controller
{

	//The index method
	public function index()
	{

	}


	/*
		Listing of the posts
	*/
	public function getPosts()
	{
		$data = $_POST["data"];

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
}