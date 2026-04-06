<?php
// ─── Validator.php ────────────────────────────────────────────────────────────
// Clase con métodos estáticos para validar los datos del formulario.
// Se usa igual que en registroCNT.php del repo, pero centralizado en una clase.
// ─────────────────────────────────────────────────────────────────────────────

class Validator {

    // Valida que el nombre solo tenga letras y espacios
    public static function nombre($valor) {
        return isset($valor) &&
               preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", trim($valor));
    }

    // Valida formato de correo electrónico
    public static function email($valor) {
        return isset($valor) &&
               filter_var(trim($valor), FILTER_VALIDATE_EMAIL);
    }

    // Valida que la contraseña tenga al menos 6 caracteres
    public static function password($valor) {
        return isset($valor) && strlen(trim($valor)) >= 6;
    }

    // Valida que un campo de texto no esté vacío
    public static function texto($valor) {
        return isset($valor) && trim($valor) !== "";
    }

    // Valida que sea un número positivo
    public static function numero($valor) {
        return isset($valor) && is_numeric($valor) && $valor > 0;
    }

    // Valida que la talla sea una de las permitidas
    public static function talla($valor) {
        $tallasValidas = ['S', 'M', 'L', 'XL'];
        return isset($valor) && in_array($valor, $tallasValidas);
    }

    // Valida que la cantidad sea un entero positivo
    public static function cantidad($valor) {
        return isset($valor) &&
               preg_match("/^[0-9]+$/", $valor) &&
               (int)$valor >= 1;
    }
}
