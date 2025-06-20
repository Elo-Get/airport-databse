<?php 

namespace App\Model\Enum;

enum TypeVolEnum: string
{
    case COURT = 'COURT';
    case MOYEN = 'MOYEN';
    case LONG = 'LONG';

    public function getLabel(): string
    {
        return match ($this) {
            self::COURT => 'Vol court',
            self::MOYEN => 'Vol moyen',
            self::LONG => 'Vol long',
        };
    }

}