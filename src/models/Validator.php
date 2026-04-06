<?php
class Validator {

    // VALIDA QUE EL NOMBRE SOLO TENGA LETRAS Y ESPACIOS
    public static function nombre($valor) {
        return isset($valor) &&
               preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", trim($valor));
    }

    // VALIDA FORMATO DE CORREO ELECTRONICO
    public static function email($valor) {
        return isset($valor) &&
               filter_var(trim($valor), FILTER_VALIDATE_EMAIL);
    }

    // VALIDA QUE LA CONTRASEÑA TENGA AL MENOS 6 CARACTERES
    public static function password($valor) {
        return isset($valor) && strlen(trim($valor)) >= 6;
    }

    // VALIDA QUE UN CAMPO DE TEXTO NO ESTE VACIO
    public static function texto($valor) {
        return isset($valor) && trim($valor) !== "";
    }

    // VALIDA QUE SEA UN NUMERO POSITIVO
    public static function numero($valor) {
        return isset($valor) && is_numeric($valor) && $valor > 0;
    }

    // VALIDA QUE LA TALLA SEA UNA DE LAS PERMITIDAS
    public static function talla($valor) {
        $tallasValidas = ['S', 'M', 'L', 'XL'];
        return isset($valor) && in_array($valor, $tallasValidas);
    }

    // VALIDA QUE LA CANTIDAD SEA UN ENTERO POSITIVO
    public static function cantidad($valor) {
        return isset($valor) &&
               preg_match("/^[0-9]+$/", $valor) &&
               (int)$valor >= 1;
    }
}
