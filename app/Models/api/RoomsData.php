<?php

namespace App\Models\api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


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
        }
        return $retVal;
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
        $arrNamesFile = [];
        if (File::exists($filePath)) {
            $arrNamesFile = explode(';', File::get($filePath), 18);
        }
        $collectNamesFile = collect($arrNamesFile);
        return $collectNamesFile->filter(function ($item, $key) {
            return $key > 0;
        })->mapWithKeys(function ($item, $key) {
            return [
                $key - 1 => $item
            ];
        })->all();
    }

    private function getSt()
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
        return $st;
    }

    private function getUpdateSettings($st): array
    {
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
        $scheduleArrTime = $arrMode['scheduleArrTime'];
        $scheduleIntervalsNum = $arrMode['scheduleIntervalsNum'];
        $scheduleArrIntervalMode = $arrMode['scheduleArrIntervalMode'];
        $scheduleArrTemp = $arrMode['scheduleArrTemp'];
        $curTime = time();
        $currentHours = intval(date('H', $curTime));
        $currentMinutes = intval(date('i', $curTime));
        $currentSeconds = intval(date('s', $curTime));
        $scheduleArr = array_fill(0, 7, null);
//        dump($arrMode['id']);
//        dump($scheduleArrTime);
        $scheduleArr[0] = 0;
        $scheduleArr[6] = 2360;
        $countScheduleArrTime = RoomsData::countVal($scheduleArrTime);
        for ($i = 1; $i < 6; $i++) {
            if ($scheduleIntervalsNum < $i) {
                break;
            }
            $scheduleArr[$i] = $scheduleArrTime[$i - 1];
        }
        $timeVal = $currentHours * 3600 + $currentMinutes * 60 + $currentSeconds;
        for ($i = 0; $i < $scheduleIntervalsNum; $i++) {
            // convert time to num of seconds from 00:00
            $timeValFromSchedule1 = floor($scheduleArr[$i] / 100) * 3600 + ($scheduleArr[$i] % 100) * 60;
            $timeValFromSchedule2 = floor($scheduleArr[$i + 1] / 100) * 3600 + ($scheduleArr[$i + 1] % 100) * 60;
            if ($timeValFromSchedule1 >= $timeVal && $timeVal < $timeValFromSchedule2)
                break;
        }
        //debughtml(['$scheduleArrIntervalMode' => $scheduleArrIntervalMode]);
        $mode = $scheduleArrIntervalMode[$i - 1];
        switch ($mode) {
            case 0:
                return strval($scheduleArrTemp[$i - 1]) . '℃';
            case 1:
                return 'вкл';
            default:
                return 'выкл';
        }
    }

    private function getCurrentModeText($arrMode)
    {
        switch ($arrMode['currentMode']) {
            case 1:
                return $arrMode['rightNowTemp'] . '℃';
            case 3:
                return $arrMode['standByTemp'] . '℃';
            case 4:
                return 'вкл';
            case 5:
                return 'выкл';
            case 2:
                return RoomsData::getScheduleTemp($arrMode);
            default:
                return '--℃';
        }
    }

    public function getArraySettings(): array
    {
        $currentMode = [];
        $rightNowTemp = [];
        $standByTemp = [];
        $scheduleIntervalsNum = [];
        $scheduleArrTime = [];
        $scheduleArrTemp = [];
        $scheduleArrIntervalMode = [];
        $updateSettings = [];

        $roomsTsensorsNames = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f'];
        $roomsTsensors = [0, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];
        $roomsPOutputs = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16];

        $roomsName = RoomsData::getArrNames();
        $latestData = RoomsData::getLatestData();
        $modeXStrPrev = $latestData[23];
        $state = RoomsData::setState($latestData);

        $st = RoomsData::getSt();
        //Todo изменение выходов
        $stateDebugStr = $st;
        $st = decbin(hexdec($ld[24]));
        $len = strlen($st);
        for ($i = 0; $i < 16; $i++) {
            if ($i < $len)
                $followAllHouse[16 - $i] = $st[$i];
            else
                $followAllHouse[16 - $i] = 0;
        }
        $followAllHouse[0] = 1;

        $updateSettings = RoomsData::getupdateSettings($st);

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
        //todo $thisServerUpdateTime - "outputs/date.x"
        // m.dirty - 'outputs/st' был выдан уже контроллеру в ответ
        // d.dirty - 'outputs/x', где x = 0..16 был выдан уже контроллеру в ответ
        // o.dirty - данные 'outputs/st' или 'outputs/x' устарели,
        // контроллер должен начать процедуру запроса данных с начала (refresh)
        // x.dirty = 000 (первый байт = o.dirty, воторой байт m.dirty, третий байт - d.dirty)
        $arrayRooms = [];
        foreach ($roomsName as $key => $value) {
            $index = $key;
            $arrMode = [
                'id' => $index,
                'currentMode' => $currentMode[$index],
                'rightNowTemp' => $rightNowTemp[$index],
                'standByTemp' => $standByTemp[$index],
                'scheduleArrTime' => $scheduleArrTime[$index],
                'scheduleIntervalsNum' => $scheduleIntervalsNum[$index],
                'scheduleArrIntervalMode' => $scheduleArrIntervalMode[$index],
                'scheduleArrTemp' => $scheduleArrTemp[$index],
            ];
            $arrayRooms[] = [
                'id' => $index,
                'roomsName' => $roomsName[$index],
                'currentMode' => $currentMode[$index],
                'currentModeText' => RoomsData::getCurrentModeText($arrMode),
                'rightNowTemp' => $rightNowTemp[$index],
                'standByTemp' => $standByTemp[$index],
                'scheduleIntervalsNum' => $scheduleIntervalsNum[$index],
                'roomsTsensors' => $roomsTsensors[$index],
                'roomsPOutputs' => $roomsPOutputs[$index],
                'updateSettings' => $updateSettings[$index],
                'followAllHouse' => $followAllHouse,
                'scheduleArrTime' => $scheduleArrTime[$index],
                'scheduleArrTemp' => $scheduleArrTemp[$index],
                'scheduleArrIntervalMode' => $scheduleArrIntervalMode[$index],
                'roomsTsensorsNames' => $roomsTsensorsNames[$roomsTsensors[$index]],
                'modeXStrPrev' => $modeXStrPrev,
                'state' => $state,
                'stateDebugStr' => $stateDebugStr,
            ];
        }
        return $arrayRooms;
    }


}
