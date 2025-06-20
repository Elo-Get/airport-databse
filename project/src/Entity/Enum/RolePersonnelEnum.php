<?php 

namespace App\Model\Enum;

enum RolePersonnelEnum: string {
    case ACCUEIL = 'ACCUEIL';
    case SERVICE = 'SERVICE';
    case TECHNICIEN = 'TECHNICIEN';
    case AUTRE = 'AUTRE';

    public function getLabel(): string
    {
        return match ($this) {
            self::ACCUEIL => 'Accueil',
            self::SERVICE => 'Service',
            self::TECHNICIEN => 'Technicien',
            self::AUTRE => 'Autre',
        };
    }

}