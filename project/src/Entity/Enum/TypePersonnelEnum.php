<?php 

namespace App\Model\Enum;

enum TypePersonnelEnum: string {
    case  PILOTE = 'PILOTE';
    case  COPILOTE = 'COPILOTE';
    case  HOTE = 'HOTE';
    case  HOTESSE = 'HOTESSE';  
    case  MECANICIEN = 'MECANICIEN';
    case  AUTRE = 'AUTRE';

    public function getLabel(): string
    {
        return match ($this) {
            self::PILOTE => 'Pilote',
            self::COPILOTE => 'Copilote',
            self::HOTE => 'Hôte',
            self::HOTESSE => 'Hôtesse',
            self::MECANICIEN => 'Mécanicien',
            self::AUTRE => 'Autre',
        };
    }
}