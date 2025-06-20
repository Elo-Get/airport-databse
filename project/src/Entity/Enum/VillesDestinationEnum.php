<?php 

namespace App\Model\Enum;

enum VillesDestinationEnum: string
{
    case PARIS = 'PARIS';
    case MARSEILLE = 'MARSEILLE';
    case LYON = 'LYON';
    case BORDEAUX = 'BORDEAUX';
    case NICE = 'NICE';
    case TOULOUSE = 'TOULOUSE';
    case NANTES = 'NANTES';
    case STRASBOURG = 'STRASBOURG';
    case MONTPELLIER = 'MONTPELLIER';
    case BARCELONE = 'BARCELONE';
    case MADRID = 'MADRID';
    case LONDRES = 'LONDRES';
    case BERLIN = 'BERLIN';
    case NEW_YORK = 'NEW_YORK';
    case TOKYO = 'TOKYO';
    case DUBAI = 'DUBAI';
    case BEIJING = 'BEIJING';
    case SYDNEY = 'SYDNEY';
    case SAN_FRANCISCO = 'SAN_FRANCISCO';
    case LOS_ANGELES = 'LOS_ANGELES';
    case CHICAGO = 'CHICAGO';

    public function getLabel(): string
    {
        return match ($this) {
            self::PARIS => 'Paris',
            self::MARSEILLE => 'Marseille',
            self::LYON => 'Lyon',
            self::BORDEAUX => 'Bordeaux',
            self::NICE => 'Nice',
            self::TOULOUSE => 'Toulouse',
            self::NANTES => 'Nantes',
            self::STRASBOURG => 'Strasbourg',
            self::MONTPELLIER => 'Montpellier',
            self::BARCELONE => 'Barcelone',
            self::MADRID => 'Madrid',
            self::LONDRES => 'Londres',
            self::BERLIN => 'Berlin',
            self::NEW_YORK => 'New York',
            self::TOKYO => 'Tokyo',
            self::DUBAI => 'Dubaï',
            self::BEIJING => 'Pékin',
            self::SYDNEY => 'Sydney',
            self::SAN_FRANCISCO => 'San Francisco',
            self::LOS_ANGELES => 'Los Angeles',
            self::CHICAGO => 'Chicago',
        };
    }

}