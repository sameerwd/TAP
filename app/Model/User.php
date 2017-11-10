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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['firstname', 'lastname','email', 'password','userType','os','device','pushkey'];

        
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password'];


    public function getEmailForPasswordReset() {
        
    }

    public function sendPasswordResetNotification($token)
    {

    }

    public function findUserByEmail($email)
    {
        return DB::table('users')->where('email',$email)->count();
    }

    public function updateUserPassword($password,$email)
    {
        $updateArray = array('password' => $password);
        return DB::table('users')->where('email',$email)->update($updateArray);
    }

    /* get registered user list*/
    private function getUsers()
    {
        return DB::table('users')->select('title','firstname','lastname','email')->get();
    }


}