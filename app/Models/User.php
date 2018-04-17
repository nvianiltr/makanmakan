<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $table = 'users';
    protected $fillable = ['firstName','lastName','username', 'email', 'password', 'isVerified'];
    protected $guarded = [];
    protected $hidden = ['password','remember_token'];    
    public $timestamps = false;

    public function savedArticles()
    {
    	return $this->hasMany('App\Models\SavedArticle');
    }

    public function savedRecipes()
    {
    	return $this->hasMany('App\Models\SavedRecipe');
    }

    public function articles()
    {
    	return $this->hasMany('App\Models\Article');
    }

    public function transactionHeaders()
    {
    	return $this->hasMany('App\Models\TransactionHeader');
    }

    public function reportedReviews()
    {
    	return $this->hasMany('App\Models\ReportedReview');
    }

    public function reviews()
    {
    	return $this->hasMany('App\Models\Review');
    }

    public function recipes()
    {
    	return $this->hasMany('App\Models\Recipe');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
