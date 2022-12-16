<?php

namespace App\Models\api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class RoomsData extends Model
{
    use HasFactory;

    public function getArraySettings()
    {
        $disk = Storage::disk('public');
        $arrNames = array();
        if ($disk->exists('heater/outputs/names')) {
            $arrNames = explode(';', $disk->get('heater/outputs/names'));
            dd($arrNames);
        }
        return $arrNames;
    }
}
