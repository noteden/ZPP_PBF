<?php

namespace App\Enums;

enum ReportStatus: string
{
    case Pending  = 'oczekujące';
    case Reviewed = 'rozpatrzone';

    public function label(): string
    {
        return match($this) {
            self::Pending  => 'Oczekujące',
            self::Reviewed => 'Rozpatrzone',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Pending  => 'yellow',
            self::Reviewed => 'green',
        };
    }
}
