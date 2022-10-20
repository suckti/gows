<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChallengeGroup extends Model
{
    protected $table = 'challenge_group';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public function challenge()
    {
        return $this->belongsTo(Challenge::class, 'challenge_id');
    }

    public function groupuser()
    {
        return $this->hasMany(GroupUser::class, 'group_id');
    }
}
