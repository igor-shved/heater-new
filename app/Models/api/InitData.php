<?php

namespace App\Models\api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InitData extends Model
{
    use HasFactory;

    public function getArrayInitData()
    {
        return [
            'roomsTsensorsNames' => ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f'],
            'roomsTsensors' => [0, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
            'roomsPOutputs' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
            'roomsModes' => [
                ['id' => 1, 'textMode' => 'ручной', 'img' => 'mode-hand.png', 'isSelect' => false],
                ['id' => 2, 'textMode' => 'по расписанию', 'img' => 'mode-schedule.png', 'isSelect' => false],
                ['id' => 3, 'textMode' => 'никого нет дома', 'img' => 'mode-standby.png', 'isSelect' => false],
                ['id' => 4, 'textMode' => 'включить', 'img' => 'mode-on.png', 'isSelect' => false],
                ['id' => 5, 'textMode' => 'выключить', 'img' => 'mode-off.png', 'isSelect' => false],
                //['id' => 7, 'textMode' => 'индивидуально', 'img' => 'individual.png', 'isSelect' => false],
            ],
            'homeModes' => [
                ['id' => 1, 'textMode' => 'ручной', 'img' => 'mode-hand.png', 'isSelect' => false],
                ['id' => 2, 'textMode' => 'по расписанию', 'img' => 'mode-schedule.png', 'isSelect' => false],
                ['id' => 3, 'textMode' => 'никого нет дома', 'img' => 'mode-standby.png', 'isSelect' => false],
                ['id' => 4, 'textMode' => 'включить', 'img' => 'mode-on.png', 'isSelect' => false],
                ['id' => 5, 'textMode' => 'выключить', 'img' => 'mode-off.png', 'isSelect' => false],
                ['id' => 7, 'textMode' => 'индивидуально', 'img' => 'individual.png', 'isSelect' => false],
            ],
        ];
    }
}
