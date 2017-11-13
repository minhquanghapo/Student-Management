<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property \Carbon\Carbon $created_at
 * @property int $id
 * @property \Carbon\Carbon $updated_at
 */
class Student extends Authenticatable
{
    protected $fillable = ['id' , 'name' , 'birthday' , 'address' , 'class', 'email', 'password'];

    public function classes()
    {
    	return $this->belongsToMany(Classes::class,'student_class','student_id','class_id')->withPivot('score');
    }

    protected $hidden = [
        'password', 'remember_token',
    ];
}

