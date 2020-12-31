<?php

namespace App\Constant;

class Payment
{
    public const PROMISSORY_NOTE = 'Billet à Ordre';
    public const BANK_CARD = 'Carte bancaire';
    public const CHECK = 'Chèque';
    public const BILL_OF_EXCHANGE = 'Lettre de change';
    public const PAYPAL = 'Lettre de change';
    public const LEVY_BANK = 'Prélevemnt';
    public const TRANSFERT = 'Viremenent';
    public const PAYMENT = [
        'BOR' => self::PROMISSORY_NOTE,
        'BD' => self::BANK_CARD,
        'CHEQ' => self::CHECK,
        'LRC' => self::BILL_OF_EXCHANGE,
        'PAY' => self::PAYPAL,
        'PRE' => self::LEVY_BANK,
        'VIR' => self::TRANSFERT,
    ];
}
