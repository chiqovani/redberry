<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidates extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'candidate';
    protected $with = ['status'];
    public function getCandidatesByStatusId(int $statusId)
    {
        return $this->where('status_id', $statusId)->get();
    }

    public function statusChangeTimeline()
    {
        return $this->hasMany(StatusChange::class, 'candidate_id', 'id');
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }
}
