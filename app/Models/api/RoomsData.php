<?php

namespace App\Models\api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use mysql_xdevapi\CollectionRemove;


class RoomsData extends Model
{
    use HasFactory;

    function countVal($val)
    {
        $retVal = 0;
        if (!is_null($val)) {
            $retVal = 1;
            if (is_countable($val)) {
                $retVal = count($val);
            }
            return $retVal;
        }
    }

    private function getArrNames(): \Illuminate\Support\Collection
    {
        /*$disk = Storage::disk('public');
          $arrNames = array();
          if ($disk->exists('heater/outputs/names')) {
              $arrNames = explode(';', $disk->get('heater/outputs/names'));
              dd($arrNames);
          }*/
        $filePath = './outputs/names';
        $collectNamesFile = collect([]);
        $countRooms = 16;
        if (File::exists($filePath)) {
            $arrNamesFile = explode(';', File::get($filePath), 18);
            $countRooms = $arrNamesFile[0];
            $collectNamesFile = collect($arrNamesFile);
        }

        return $collectNamesFile->filter(function ($item, $key) use ($countRooms) {
            return ($key > 0 and $key <= $countRooms + 1);
        })->all();
    }

    private function getUpdateSettings(): array
    {
        $filePath = './outputs/st';
        $st = '';
        if (File::exists($filePath)) {
            $st = File::get($filePath);
        }
        if (strlen($st) < 17) {
            $st = "00000000000000000:restore";
            File::put($filePath, $st, true);
        }
        $updateSettings = array();
        for ($i = 0; $i < 17; $i++)
            if ($st[$i] == 0)
                $updateSettings[$i] = 0;
            else
                $updateSettings[$i] = 1;

        return $updateSettings;
    }


    private function getLatestData(): array
    {
        $filePath = './datalog/latestdata.php';
        $latestData = array();
        if (File::exists($filePath)) {
            $latestData = explode(';', File::get($filePath));
        }
        return $latestData;
    }

    private function setState($latestData): int
    {
        $state = 0;
        if (isset($latestData[2]))
            $state = $latestData[2];
        return $state;
    }


    public function getArraySettings(): array
    {
        $currentMode = array();
        $rightNowTemp = array();
        $standByTemp = array();
        $scheduleIntervalsNum = array();
        $scheduleArrTime = array();
        $scheduleArrTemp = array();
        $scheduleArrIntervalMode = array();
        $updateSettings = array();
        $followAllHouse = array();

        $roomsTsensorsNames = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f'];
        $roomsTsensors = [0, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];
        $roomsPOutputs = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16];

        $roomsName = RoomsData::getArrNames();
        $latestData = RoomsData::getLatestData();
        $modeXStrPrev = $latestData[23];
        $state = RoomsData::setState($latestData);

        $updateSettings = RoomsData::getupdateSettings();
        $st = decbin(hexdec($latestData[24]));
        $len = strlen($st);
        for ($i = 0; $i < 16; $i++) {
            if ($i < $len)
                $followAllHouse[16 - $i] = $st[$i];
            else
                $followAllHouse[16 - $i] = 0;
        }
        $followAllHouse[0] = 1;

        for ($i = 0; $i < 17; $i++) {
            $filePath = './outputs/' . $i;
            $parts = explode(':', File::get($filePath));
            $p1 = explode(";", $parts[0]);
            $p2 = explode(";", $parts[1]);
            $currentMode[$i] = $p1[1];
            $rightNowTemp[$i] = hexdec($p1[2]) / 10.0;
            $roomsPOutputs[$i] = hexdec($p2[0]);
            $roomsTsensors[$i] = hexdec($p2[1]);
            $standByTemp[$i] = hexdec($p2[2]) / 10.0;
            $intervalsNum = hexdec($p2[3]);
            $scheduleIntervalsNum[$i] = $intervalsNum;
            if ($intervalsNum > 10)
                $intervalsNum = 10;

            $j = 4;

            for ($j = 0; $j < $intervalsNum; $j++) {
                $val = hexdec($p2[$j + 4]);

                $time = substr($val, 0, RoomsData::countVal($val) - 4);
                $scheduleArrTime[$i][$j] = $time;

                $temp = substr($val, -3, 3);
                $scheduleArrTemp[$i][$j] = $temp / 10.0;
            }

            $val = hexdec($p2[$j + 4]);
            $fstr = "%0$intervalsNum" . "d";
            $istr = sprintf($fstr, $val);

            for ($j = $intervalsNum; $j < 6; $j++)
                $istr .= "0";

            for ($j = 0; $j < 6; $j++) {
                $scheduleArrIntervalMode[$i][$j] = $istr[$j];
            }

        }
        $arrayRooms = array();
        foreach ($roomsName as $key => $item) {
            json
        }
        return [
            'currentMode' => $currentMode,
            'rightNowTemp' => $rightNowTemp,
            'standByTemp' => $standByTemp,
            'scheduleIntervalsNum' => $scheduleIntervalsNum,
            'roomsName' => $roomsName,
            'roomsTsensors' => $roomsTsensors,
            'roomsPOutputs' => $roomsPOutputs,
            'updateSettings' => $updateSettings,
            'followAllHouse' => $followAllHouse,
            'followAllHouse2' => $followAllHouse,
            'scheduleArrTime' => $scheduleArrTime,
            'scheduleArrTemp' => $scheduleArrTemp,
            'scheduleArrIntervalMode' => $scheduleArrIntervalMode,
            'roomsTsensorsNames' => $roomsTsensorsNames,

        ];
    }


}
