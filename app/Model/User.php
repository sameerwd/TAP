<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use App\Model\Audit;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


use DB;
use Illuminate\Support\Facades\Session;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {
    use Authenticatable;

    //
    protected $table = 'users';
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['firstname', 'lastname','email', 'password','userType','os','device','pushkey'];

    
    public function findUserByEmail($email)
    {
        return DB::table('users')->where('email',$email)->count();
    }

    public function updateUserPassword($password,$email)
    {
        $updateArray = array('password' => bcrypt($password));
        return DB::table('users')->where('email',$email)->update($updateArray);
    }

    /* get registered user list*/
    private function getUsers()
    {
        return DB::table('users')->select('title','firstname','lastname','email')->get();
    }

    /*check user email */
    public function getUserByEmail($email)
    {
        // This SQL statement selects an existing user by email
            $sql = "SELECT userid FROM users where email = '".$email."'";
            return DB::select($sql);
    }

    public function checkUser($email)
    {
        $sql = "SELECT userid, title, userType, lastname, firstname, email, imageStatus, lastlogindttm, 0 as forgotPassword, permissionAccepted FROM users where email ='".$email."' and status > 0";

        return DB::select($sql);
    }

    public function updateUserLog($pushkey,$device,$userid)
    {
        $sql = "update users set lastlogindttm = now(), pushkey = '".$pushkey."', device = '".$device."' where userid = ".$userid;
        return DB::select(DB::raw($sql));
    }

    public function getUserPost($userid)
    { 
        // This SQL statement selects ALL from the table 'Posts'
        $sql = "SELECT * FROM posts where userid =".$userid;

        return DB::select($sql);
    }


    private function getUserCourse($userid)
    {
        $sql = "SELECT * FROM user_course u where u.userid = ".$userid;

        return DB::select($sql);
    }

    private function sendConfirmationEmail($name,$email)
    {
    
     $subject = "Welcome to The Academic Point";
     
     $message = "<b>Dear ".$name."</b>";
     $message .= "<h1>\n Thank you for downloading The Academic Point.</h1><br><br>";
//   $message .= "This is a place where you can get access to informations of your university and can stay in contact with your friends and collegues";
     $message .= "We hope you enjoy the app and all the great features it has to offer <br><br>";
     $message .= "Sincerly,<br><br>";
     $message .= "The Academic Point Team";

     $header = "From: The Academic Point webmaster@theacademicpointonline.com \r\n";
//      $header = "Cc:afgh@somedomain.com \r\n";
     $header .= "MIME-Version: 1.0\r\n";
     $header .= "Content-type: text/html\r\n";
     
//   $header = "From:The Academic Point \r\n";
//   $header = "From: webmaster@theacademicpointonline.com' . "\r\n";
//   $header .= "MIME-Version: 1.0\r\n";
//   $header .= "Content-type: text/html\r\n";
//   $header .= "From: webmaster@example.com' . "\r\n";
     
     return $retval = mail ($email,$subject,$message,$header);
    }

    public function getEmailForPasswordReset() {
            
    }


    public function getUserForReset($email){
        $sql = "SELECT userid, email FROM users where email ='".$email."' and status > 0";

         return DB::select($sql);
    }

    public function updateResetPassword($userid,$password)
    {
        $sql = "update users set lastlogindttm = now(), password = '".bcrypt($password)."', forgotPassword = '' where userid = ".$userid;
        return DB::select(DB::raw($sql));
    }

    public function updateProfileImageStatus($userid)
    {
        return DB::table('users')->where('userid',$userid)->update(['imageStatus' => 1]);
    }

    public function updateUserProfile($updateArray,$userid)
    {
        return DB::table('users')->where('userid',$userid)->update($updateArray);
    }

    public function sendPasswordResetNotification($token)
    {

    }

}