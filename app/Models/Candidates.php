<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Tags\HasTags;

class Candidates extends Model
{
    use HasFactory;
    use HasTags;
    protected $guarded = [];
    protected $table = 'candidate';
    protected $with = ['status'];
    public function getCandidatesByStatusId(int $statusId)
    {
        return $this->where('status_id', $statusId)->get();
    }

    public function statusChangeTimeline()
    {
        return $this->hasMany(StatusChange::class, 'candidate_id', 'id')->with('status');
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public function tags(): MorphToMany
    {
        return $this
            ->morphToMany(self::getTagClassName(), 'taggable', 'taggables', null, 'tag_id')
            ->orderBy('order_column');
    }
}
