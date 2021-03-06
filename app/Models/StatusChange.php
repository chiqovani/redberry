<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusChange extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'status_change';

    public function status()
    {
        return $this->hasOne(Status::class,'id','status_id');
    }
}
