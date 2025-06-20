<?php 

namespace App\Model\Enum;

enum StatutVolEnum: string
{
    case ALHEURE = 'A_L_HEURE';
    case RETARDE = 'RETARDE';
    case ANNULE = 'ANNULE';
    case ENCOURS = 'EN_COURS';
    case TERMINE = 'TERMINE';

    public function getLabel(): string
    {
        return match ($this) {
            self::ALHEURE => 'À l\'heure',
            self::RETARDE => 'Retardé',
            self::ANNULE => 'Annulé',
            self::ENCOURS => 'En cours',
            self::TERMINE => 'Terminé',
        };
    }

}