<?php 

namespace App\Model\Enum;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'TypeVolEnum',
    type: 'string',
    enum: ['COURT', 'MOYEN', 'LONG'],
    description: 'Type de vol (court, moyen ou long)'
)]
enum TypeVolEnum: string
{
    case COURT = 'COURT';
    case MOYEN = 'MOYEN';
    case LONG = 'LONG';

    public function getLabel(): string
    {
        return match ($this) {
            self::COURT => 'Vol court',
            self::MOYEN => 'Vol moyen',
            self::LONG => 'Vol long',
        };
    }

}