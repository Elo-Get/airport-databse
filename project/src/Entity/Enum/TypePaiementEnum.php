<?php 

namespace App\Model\Enum;

enum TypePaiementEnum: string {
    case CB = 'CARTE_BANCAIRE';
    case CHEQUE = 'CHEQUE';
    case ESPECES = 'ESPECES';
    case VIREMENT = 'VIREMENT';

    public function getLabel(): string
    {
        return match ($this) {
            self::CB => 'Carte bancaire',
            self::CHEQUE => 'Chèque',
            self::ESPECES => 'Espèces',
            self::VIREMENT => 'Virement',
        };
    }
}