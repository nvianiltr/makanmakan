<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
	protected $fillable = ['recipe_id','user_id','content','datePosted','isDeleted'];
	protected $guarded = [];
    public $timestamps = false;
    
	public function reportedReviews()
	{
		return $this->hasMany('App\Models\ReportedReview');
	}

	public function recipe()
	{
		return $this->belongsTo('App\Models\Recipe');
	}

	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}
}
