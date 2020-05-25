<?php
namespace App\Models;
use Eloquent; // ******** This Line *********
use DB; 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

//use Roles;
class User extends Authenticatable {
    // use SoftDeletes;

    public $timestamps = false;
    
    protected $table = 'users';

    // protected $with = ['role', 'group'];

    // protected $fillable = array('name', 'email', 'password', 'role_id', 'group_id', 'status');
    protected $fillable = array('name', 'email', 'password', 'role', 'location', 'status');

    
    // protected $dates = ['deleted_at'];
    // protected $with = ['roles'];
    // protected $fillable = [
    //     'role_id', 
    //     'group_id', 
    //     'username',
    //     'name',
    //     'email',
    //     'password',
    //     'status'
    // ];
//    public function roles()
//     {
//         return $this->hasOne('App\Models\Roles','id','role_id');
//     }
//    public function hasRole($name)
//     {
//         foreach ($this->roles as $role) 
//         {
//             if ($role->name == $name) return true;
//         }

//         return false;
//     }

//   public function isAdmin() {
// 	 return $this->roles()->where('name', 'Admin')->exists();
// 	}
//   public function setRoleIdAttribute($value)
//     {
//     	if(empty($value))
//     	{
//     		$role_id = Roles::where('name','User')->get();
//     		 $this->attributes['role_id']  =  $role_id[0]->id;
//     	}
//     	else
//     		$this->attributes['role_id']  = $value;
        
//     }


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // /**
    //  * Get the role associated with the user.
    //  */
    // public function role()
    // {

    //     return $this->hasOne('App\Models\User\Role', 'id', 'role_id');
    // }

    // /**
    //  * Get the group associated with the user.
    //  */
    // public function group()
    // {

    //     return $this->hasOne('App\Models\User\Group', 'id', 'group_id');
    // }

    // public function isAdmin()
    // {

    //     return $this->role()->where('name', 'admin')->exists();
    // }

    // public function isAM()
    // {

    //     return $this->role()->where('name', 'am')->exists();
    // }

    // public function isPM()
    // {

    //     return $this->role()->where('name', 'pm')->exists();
    // }

    // public function isStakeholder()
    // {

    //     return $this->role()->where('name', 'stakeholder')->exists();
    // }

}
?>