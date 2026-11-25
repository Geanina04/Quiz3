<?php

/**
 * Helpers propios de la aplicación.
 */

if (! function_exists('old_value')) {
    /**
     * Valor que el usuario había escrito en el formulario anterior, siempre como texto.
     *
     * old() devuelve un arreglo si alguien envía campos como "nombre[]=x"; imprimirlo
     * en un <input> provocaría un error, por eso aquí solo se aceptan textos.
     */
    function old_value(string $key, string $default = ''): string
    {
        $value = old($key, $default);

        return is_string($value) ? $value : $default;
    }
}
