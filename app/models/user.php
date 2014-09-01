<?php



use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

  protected $table = 'users';
  public static $uservalues = array('username', 'firstname', 'lastname', 'user_id', 'avatar');
  public $hidden = array('password');

  public static $rules = array(
             'username'=>'required|alpha_dash|unique:users|min:2',
             'firstname'=>'required|alpha|min:3',
             'lastname'=>'required|alpha|min:3',
             'email' => 'required|email|unique:users',
             'avatar' => 'image|max:1000|mimes:jpg,png',
             'password' => 'required|alpha_dash|confirmed'
  );

  public static function validate($data) {
    return Validator::make($data, static::$rules);
  }

  public function album()
  {
    return $this->hasMany('Album', 'album_id');
  }
  public function photo()
  {
    return $this->hasMany('Photo', 'photo_id');
  }
   public function friend()
  {
    return $this->hasMany('Friend', 'friend_id');
  }

   // *
   //   * Get the unique identifier for the user.
   //   *
   //   * @return mixed

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    // *
    //  * Get the password for the user.
    //  *
    //  * @return string

    public function getAuthPassword()
    {
        return $this->password;
    }

    // *
    //  * Get the e-mail address where password reminders are sent.
    //  *
    //  * @return string

    public function getReminderEmail()
    {
        return $this->email;
    }

    public function getRememberToken()
	{
	    return $this->remember_token;
	}

	public function setRememberToken($value)
	{
	    $this->remember_token = $value;
	}

	public function getRememberTokenName()
	{
	    return 'remember_token';
	}

  }
