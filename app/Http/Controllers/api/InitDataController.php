<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\api\InitData;

class InitDataController extends Controller
{
    public function getArrayInitData()
    {
        return InitData::getArrayInitData();
    }
}
