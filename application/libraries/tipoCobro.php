<?php

class TipoCobro {
    const DEBITO = 'debito';
    const TARJETA = 'tarjeta';

    public static function isValid($value) {
        return in_array(strtolower($value), [self::DEBITO, self::TARJETA], true);
    }
}
