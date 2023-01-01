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

    private function getArrNames(): array
    {
        /*$disk = Storage::disk('public');
          $arrNames = [];
          if ($disk->exists('heater/outputs/names')) {
              $arrNames = explode(';', $disk->get('heater/outputs/names'));
              dd($arrNames);
          }*/
        $filePath = './outputs/names';
        $collectNamesFile = collect([]);
        $countRooms = 16;
        $arrNamesFile = [];
        if (File::exists($filePath)) {
            $arrNamesFile = explode(';', File::get($filePath), 18);
        }
        /*$collectNamesFile->filter(function ($item, $key) use ($countRooms) {
            return ($key > 0 and $key <= $countRooms + 1);
        })->all()*/
        return $arrNamesFile;
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
        $updateSettings = [];
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
        $latestData = [];
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

    private function getScheduleTemp($arrMode)
    {
        /*$curDateTimeZone = new \DateTimeZone("Europe/Kiev");
        $curDateTime = new \DateTime("now", $curDateTimeZone);
        $timeOffset = $curDateTimeZone->getOffset($curDateTime);
        $curDate = $curDateTime->getTimestamp() + $timeOffset;*/
        //date_default_timezone_set("Europe/Kiev");
        dump($arrMode);
        $scheduleArrTime = $arrMode['scheduleArrTime'];
        $scheduleIntervalsNum = $arrMode['scheduleIntervalsNum'];
        $scheduleArrIntervalMode = $arrMode['scheduleArrIntervalMode'];
        $curTime = time();
        $currentHours = intval(date('H', $curTime));
        $currentMinutes = intval(date('i', $curTime));
        $currentSeconds = intval(date('s', $curTime));
        //$scheduleArr = [];
        $scheduleArr = array_fill(0, 7, null);
        $lengthArrTime = RoomsData::countVal($scheduleArrTime);
        for ($i = 1; $i < 6; $i++) {
            $scheduleArr[$i] = intval($scheduleArrTime[$i - 1]);
            //dump($scheduleArr[$i]);
        }
        $scheduleArr[0] = 0;
        $scheduleArr[6] = 2360;
        $timeVal = $currentHours * 3600 + $currentMinutes * 60 + $currentSeconds;
        dump($scheduleArr);
        for ($i = 0; $i < $scheduleIntervalsNum; $i++) {
            // convert time to num of seconds from 00:00
            //if ($scheduleArr[$i] == null) continue;
            $timeValFromSchedule1 = floor($scheduleArr[$i] / 100) * 3600 + ($scheduleArr[$i] % 100) * 60;
            //dump($timeValFromSchedule1);
            $timeValFromSchedule2 = floor($scheduleArr[$i + 1] / 100) * 3600 + ($scheduleArr[$i + 1] % 100) * 60;
            if ($timeValFromSchedule1 >= $timeVal && $timeVal < $timeValFromSchedule2)
                //dd($timeValFromSchedule1, $timeVal, $timeValFromSchedule2, $i);
                //dd($timeValFromSchedule1);
                break;
        }
        $mode = $scheduleArrIntervalMode[$i - 1];
        switch ($mode) {
            case 0:
                $res = $scheduleArrTemp[$i - 1];
                $res += "&deg;c";
                return $res;
                break;
            case 1:
                return 'вкл';
                break;
            default:
                return 'выкл';
        }
    }

    private function getCurrentModeText($arrMode)
    {
        switch ($arrMode['currentMode']) {
            case 1:
                return $arrMode['rightNowTemp'];
                break;
            case 3:
                return $arrMode['standByTemp'];
                break;
            case 4:
                return 'вкл';
                break;
            case 5:
                return 'выкл';
                break;
            case 2:
                return RoomsData::getScheduleTemp($arrMode);
                break;
        }
    }

    public
    function getArraySettings(): array
    {
        $currentMode = [];
        $rightNowTemp = [];
        $standByTemp = [];
        $scheduleIntervalsNum = [];
        $scheduleArrTime = [];
        $scheduleArrTemp = [];
        $scheduleArrIntervalMode = [];
        $updateSettings = [];
        $followAllHouse = [];

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
        $arrayRooms = [];
        foreach ($roomsName as $key => $value) {
            if ($key === 0) continue;
            $index = $key - 1;
            $arrMode = [
                'currentMode' => $currentMode[$index],
                'rightNowTemp' => $rightNowTemp[$index],
                'standByTemp' => $standByTemp[$index],
                'scheduleArrTime' => $scheduleArrTime[$index],
                'scheduleIntervalsNum' => $scheduleIntervalsNum[$index],
                'scheduleArrIntervalMode' => $scheduleArrIntervalMode[$index],
            ];
            $arrayRooms[] = [
                'id' => $index,
                'currentMode' => $currentMode[$index],
                'currentModeText' => RoomsData::getCurrentModeText($arrMode),
                'rightNowTemp' => $rightNowTemp[$index],
                'standByTemp' => $standByTemp[$index],
                'scheduleIntervalsNum' => $scheduleIntervalsNum[$index],
                'roomsName' => $roomsName[$index],
                'roomsTsensors' => $roomsTsensors[$index],
                'roomsPOutputs' => $roomsPOutputs[$index],
                'updateSettings' => $updateSettings[$index],
                'followAllHouse' => $followAllHouse[$index],
                'scheduleArrTime' => $scheduleArrTime[$index],
                'scheduleArrTemp' => $scheduleArrTemp[$index],
                'scheduleArrIntervalMode' => $scheduleArrIntervalMode[$index],
                'roomsTsensorsNames' => $roomsTsensorsNames[$roomsTsensors[$index]],
            ];
        }
        return $arrayRooms;
    }


}
