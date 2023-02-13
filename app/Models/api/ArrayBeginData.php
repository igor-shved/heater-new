<?php

namespace App\Models\api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArrayBeginData extends Model
{
    use HasFactory;

    public function getArrayBeginData()
    {
        $arrayAllData = [
            'roomsTsensorsNames' => ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f'],
            'roomsTsensors' => [0, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
            'roomsPOutputs' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
            'roomsModes' => [
                1 => ['textMode'=> 'ручной', 'img'=>'mode-hand.png'],
                2 =>['textMode'=> 'по расписанию', 'img'=>'mode-schedule.png'],
                3 =>['textMode'=> 'никого нет дома', 'img'=>'mode-standby.png'],
                4 =>['textMode'=> 'включить', 'img'=>'mode-on.png'],
                5 =>['textMode'=> 'выключить', 'img'=>'mode-off.png'],
                7 =>['textMode'=> 'индивидуально', 'img'=>'individual.png']
            ],
        ];
    }
}
