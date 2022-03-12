<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $table = 'statuses';

    public static function getStatuses() {
        $results = Status::all();
        $statuses = [];
        foreach($results as $result) {
            $statuses[$result->id] = $result->name;
        }
        return $statuses;
    }
}
