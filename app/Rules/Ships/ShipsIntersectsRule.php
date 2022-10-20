<?php

namespace App\Rules\Ships;

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
        $ships = $value;

        foreach ($ships as $ship) {
            // +1 чтобы не выйти за границы массива при заполнении соседни клеток корабля
            $x = ($ship['x'] ?? 0) + 1;
            $y = ($ship['y'] ?? 0) + 1;

            // чтобы заполнить клетки спереди и сзади от корабля
            $length = ($ship['length'] ?? 0) + 1;

            $orientation = $ship['orientation'] ?? '';

            if ($orientation === Ship::HORIZONTAL_ORIENTATION) {
                for ($i = $x - 1; $i < $x + $length; $i++) {
                    if ($this->matrixOfExistedShips[$y - 1][$i] ?? 0) return false;
                    if ($this->matrixOfExistedShips[$y]    [$i] ?? 0) return false;
                    if ($this->matrixOfExistedShips[$y + 1][$i] ?? 0) return false;

                    $this->matrixOfExistedShips[$y - 1][$i] = 1;
                    $this->matrixOfExistedShips[$y]    [$i] = 1;
                    $this->matrixOfExistedShips[$y + 1][$i] = 1;
                }
            } elseif ($orientation === Ship::VERTICAL_ORIENTATION) {
                for ($i = $y - 1; $i < $y + $length; $i++) {
                    if ($this->matrixOfExistedShips[$i][$x - 1] ?? 0) return false;
                    if ($this->matrixOfExistedShips[$i][$x] ?? 0)     return false;
                    if ($this->matrixOfExistedShips[$i][$x + 1] ?? 0) return false;

                    $this->matrixOfExistedShips[$i][$x - 1] = 1;
                    $this->matrixOfExistedShips[$i][$x] = 1;
                    $this->matrixOfExistedShips[$i][$x + 1] = 1;
                }
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
