<?php

namespace App\Enums;

enum PostTag: string
{
    case Normal    = 'normalny';
    case Spoiler   = 'spoiler';
    case Important = 'ważne';

    /** Reguła walidacji Laravel dopuszczająca wszystkie tagi. */
    public static function validationRule(): string
    {
        return 'in:'.implode(',', array_column(self::cases(), 'value'));
    }

    public function label(): string
    {
        return match($this) {
            self::Normal    => 'Normalny',
            self::Spoiler   => 'Spoiler',
            self::Important => 'Ważne',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Normal    => 'zinc',
            self::Spoiler   => 'yellow',
            self::Important => 'red',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::Normal    => 'minus',
            self::Spoiler   => 'eye-slash',
            self::Important => 'exclamation-triangle',
        };
    }
}
