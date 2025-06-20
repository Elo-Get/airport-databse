<?php 

namespace App\Model\Enum;

enum TypeRepasEnum: string {
    case PETITDEJEUNER = 'PETIT_DEJEUNER';
    case DEJEUNER = 'DEJEUNER';
    case DINER = 'DINER';

    public function getLabel(): string
    {
        return match ($this) {
            self::PETITDEJEUNER => 'Petit déjeuner',
            self::DEJEUNER => 'Déjeuner',
            self::DINER => 'Dîner',
        };
    }
        
}