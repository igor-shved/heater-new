<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\api\ArrayBeginData;

class ArrayBeginDataController extends Controller
{
    public function getArrayBeginData()
    {
        return ArrayBeginData::getArrayBeginData();
    }
}
