<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    protected $table = 'group_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public function challengegroup()
    {
        return $this->belongsTo(ChallengeGroup::class, 'group_id');
    }
}
