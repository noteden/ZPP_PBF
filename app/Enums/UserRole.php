<?php

namespace App\Enums;

enum UserRole: string
{
    case Player = 'gracz';
    case GameMaster = 'mg';
    case Admin = 'admin';

    public function label(): string
    {
        return match($this) {
            self::Player     => 'Gracz',
            self::GameMaster => 'Mistrz Gry',
            self::Admin      => 'Administrator',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Player     => 'blue',
            self::GameMaster => 'purple',
            self::Admin      => 'red',
        };
    }
}
