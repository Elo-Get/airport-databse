<?php 

namespace App\Model\Enum;

enum PaysEnum: string
{
    case FRANCE = 'FRANCE';
    case ALLEMAGNE = 'ALLEMAGNE';
    case ITALIE = 'ITALIE';
    case ESPAGNE = 'ESPAGNE';
    case ROYAUME_UNI = 'ROYAUME_UNI';
    case BELGIQUE = 'BELGIQUE';
    case PAYS_BAS = 'PAYS_BAS';
    case CHINE = 'CHINE';
    case ETATS_UNIS = 'ETATS_UNIS';
    case CANADA = 'CANADA';
    case JAPON = 'JAPON';
    case INDE = 'INDE';
    case RUSSIE = 'RUSSIE';
    case SUISSE = 'SUISSE';
    case AUTRICHE = 'AUTRICHE';
    case PORTUGAL = 'PORTUGAL';
    case GRECE = 'GRECE';
    case TURQUIE = 'TURQUIE';
    case AUTRE = 'AUTRE';

    public function getLabel(): string
    {
        return match ($this) {
            self::FRANCE => 'France',
            self::ALLEMAGNE => 'Allemagne',
            self::ITALIE => 'Italie',
            self::ESPAGNE => 'Espagne',
            self::ROYAUME_UNI => 'Royaume-Uni',
            self::BELGIQUE => 'Belgique',
            self::PAYS_BAS => 'Pays-Bas',
            self::CHINE => 'Chine',
            self::ETATS_UNIS => 'États-Unis',
            self::CANADA => 'Canada',
            self::JAPON => 'Japon',
            self::INDE => 'Inde',
            self::RUSSIE => 'Russie',
            self::SUISSE => 'Suisse',
            self::AUTRICHE => 'Autriche',
            self::PORTUGAL => 'Portugal',
            self::GRECE => 'Grèce',
            self::TURQUIE => 'Turquie',
            self::AUTRE => 'Autre',
        };
    }
}

