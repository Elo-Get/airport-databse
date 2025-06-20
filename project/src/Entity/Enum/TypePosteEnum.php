<?php 

namespace App\Model\Enum;

enum TypePosteEnum: string {
    case PILOTE = 'PILOTE';
    case COPILOTE = 'COPILOTE';
    case CHEFDECABINE = 'CHEFDECABINE';
    case HOTE = 'HOTE';
    case HOTESSE = 'HOTESSE';
    case AUTRE = 'AUTRE';

    public function getLabel(): string
    {
        return match ($this) {
            self::PILOTE => 'Pilote',
            self::COPILOTE => 'Copilote',
            self::CHEFDECABINE => 'Chef de cabine',
            self::HOTE => 'Hôte',
            self::HOTESSE => 'Hôtesse',
            self::AUTRE => 'Autre',
        };
    }
}