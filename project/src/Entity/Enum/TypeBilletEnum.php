<?php 

namespace App\Model\Enum;

enum TypeBilletEnum: string {
    case ECO = 'ECO';
    case BUSINESS = 'BUSINESS';
    case FIRST = 'PREMIERE';
    case PREMIUM = 'PREMIUM';

    public function getLabel(): string
    {
        return match ($this) {
            self::ECO => 'Économique',
            self::BUSINESS => 'Affaires',
            self::FIRST => 'Première',
            self::PREMIUM => 'Premium',
        };
    }
}