<?php 

namespace App\Model\Enum;

enum StatutEntretienEnum: string
{
    case FAIT = 'FAIT';
    case AFAIRE = 'A_FAIRE';

    public function getLabel(): string
    {
        return match ($this) {
            self::FAIT => 'Entretien effectué',
            self::AFAIRE => 'Entretien à faire',
        };
    }

}