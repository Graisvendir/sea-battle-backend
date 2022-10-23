<?php

namespace App\Rules\Ships;

use App\Helpers\Debug;
use App\Models\Ship;
use Illuminate\Contracts\Validation\Rule;

class ShipsIntersectsRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(
        protected array $matrixOfExistedShips,
    ) {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $ship = $value;

        // +1 чтобы не выйти за границы массива при заполнении соседни клеток корабля
        $x = ($ship['x'] ?? 0) + 1;
        $y = ($ship['y'] ?? 0) + 1;

        // чтобы заполнить клетки спереди и сзади от корабля
        $length = ($ship['length'] ?? 0) + 1;

        $orientation = $ship['orientation'] ?? '';

        if ($orientation === Ship::HORIZONTAL_ORIENTATION) {
            for ($i = $x - 1; $i < $x + $length; $i++) {
                $isStartOrEnd = $x - 1 === $i
                    || $x + $length - 1 === $i;

                $prev = $this->matrixOfExistedShips[$y - 1][$i] ?? 0;
                $cur  = $this->matrixOfExistedShips[$y]    [$i] ?? 0;
                $next = $this->matrixOfExistedShips[$y + 1][$i] ?? 0;

                $cur = $isStartOrEnd ? $cur - 1 : $cur;

                if ($prev > 1 || $cur > 0 || $next > 1) {
                    return false;
                }

                $this->matrixOfExistedShips[$y - 1][$i] = 1;
                $this->matrixOfExistedShips[$y]    [$i] = $isStartOrEnd ? 1 : 2;
                $this->matrixOfExistedShips[$y + 1][$i] = 1;
            }
        } elseif ($orientation === Ship::VERTICAL_ORIENTATION) {
            for ($i = $y - 1; $i < $y + $length; $i++) {
                $isStartOrEnd = $y - 1 === $i
                    || $y + $length - 1 === $i;

                $prev = $this->matrixOfExistedShips[$i][$x - 1] ?? 0;
                $cur  = $this->matrixOfExistedShips[$i][$x] ?? 0;
                $next = $this->matrixOfExistedShips[$i][$x + 1] ?? 0;

                $cur = $isStartOrEnd ? $cur - 1 : $cur;

                if ($prev > 1 || $cur > 0 || $next > 1) {
                    return false;
                }

                $this->matrixOfExistedShips[$i][$x - 1] = 1;
                $this->matrixOfExistedShips[$i][$x]     = $isStartOrEnd ? 1 : 2;
                $this->matrixOfExistedShips[$i][$x + 1] = 1;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Ships is intersects';
    }
}
