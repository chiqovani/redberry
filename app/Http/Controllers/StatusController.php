<?php

namespace App\Http\Controllers;

use App\Models\Status;

class StatusController extends Controller
{
    public function getStatuses() {
        return Status::all();
    }
}
