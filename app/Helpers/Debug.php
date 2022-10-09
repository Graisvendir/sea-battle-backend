<?php

namespace App\Helpers;

use App\Models\Game;

class Debug {

    /**
     * Дамп матрицы через echo в читабельном виде
     *
     * @param array $matrix
     */
    public static function dumpMatrix(array $matrix) {
        echo "\n\nMatrix\n";

        for ($i = 0; $i < Game::FIELD_MAX_VERTICAL_LENGTH + 2; $i++) {
            for ($j = 0; $j < Game::FIELD_MAX_HORIZONTAL_LENGTH + 2; $j++) {
                $val = $matrix[$i][$j] ?? 0;

                echo $val . '  ';
            }

            echo "\n";
        }
    }
}
