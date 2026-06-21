<?php

namespace App\Support;

class Plural
{
    /**
     * Polska odmiana przez liczbę.
     *
     * @example Plural::pl(5, 'wątek', 'wątki', 'wątków') => '5 wątków'? -> zwraca samą formę: 'wątków'
     */
    public static function pl(int $count, string $one, string $few, string $many): string
    {
        $n = abs($count);

        if ($n === 1) {
            return $one;
        }

        $mod10 = $n % 10;
        $mod100 = $n % 100;

        if ($mod10 >= 2 && $mod10 <= 4 && !($mod100 >= 12 && $mod100 <= 14)) {
            return $few;
        }

        return $many;
    }
}
