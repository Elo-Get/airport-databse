<?php 

namespace App\Model\Enum;

enum TypeDocVoyageEnum: string
{
    case CNI = 'CNI';
    case PASSEPORT = 'PASSEPORT';

    public function getLabel(): string
    {
        return match ($this) {
            self::CNI => 'Carte Nationale d\'Identité',
            self::PASSEPORT => 'Passeport',
        };
    }
}