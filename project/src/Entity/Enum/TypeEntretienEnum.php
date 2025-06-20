<?php 

namespace App\Model\Enum;

enum TypeEntretienEnum: string
{
    case REPARATION = 'REPARATION';
    case PEINTURE = 'PEINTURE';
    case MAINTENANCE = 'MAINTENANCE';
    case NETTOYAGE = 'NETTOYAGE';
    case AUTRE = 'AUTRE';

    public function getLabel(): string
    {
        return match ($this) {
            self::REPARATION => 'Réparation',
            self::PEINTURE => 'Peinture',
            self::MAINTENANCE => 'Maintenance',
            self::NETTOYAGE => 'Nettoyage',
            self::AUTRE => 'Autre',
        };
    }

}