<?php 

namespace App\Model\Enum;

enum TypeAvionEnum: string
{
    case A220 = 'A220';
    case A320 = 'A320';
    case A330 = 'A330';
    case A350 = 'A350';

    public function getLabel(): string
    {
        return match ($this) {
            self::A220 => 'Airbus A220',
            self::A320 => 'Airbus A320',
            self::A330 => 'Airbus A330',
            self::A350 => 'Airbus A350',
        };
    }
}