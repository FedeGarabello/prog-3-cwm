<?php

class Validator
{
    /** @var array Los campos a validar. */
    protected $campos;

    /** @var array Las reglas a aplicar. */
    protected $reglas;

    /** @var array Los errores que ocurrieron. */
    protected $errores = [];

    /**
     * Validator constructor.
     * @param array $campos
     * @param array $reglas
     */
    public function __construct($campos, $reglas)
    {
        $this->campos = $campos;
        $this->reglas = $reglas;

        // Realizamos la validación.
        $this->validar();
    }

    /**
     * Realiza la validación.
     */
    protected function validar()
    {

        foreach($this->reglas as $nombreCampo => $reglasCampo) {
            $this->aplicarListaReglas($nombreCampo, $reglasCampo);
        }
    }

    /**
     * Aplica la $listaReglas sobre el valor del $campo.
     *
     * @param string $campo
     * @param array $listaReglas
     * @throws Exception
     */
    protected function aplicarListaReglas($campo, $listaReglas)
    {
        foreach($listaReglas as $regla) {

            $this->aplicarRegla($campo, $regla);
        }
    }

    /**
     * Aplica la $regla de validación al $campo.
     *
     * @param string $campo
     * @param string $regla
     * @throws Exception
     */
    protected function aplicarRegla($campo, $regla)
    {
        if(strpos($regla, ':') !== false) {

            [$nombreRegla, $parametroRegla] = explode(':', $regla);

            $nombreMetodo = '_' . $nombreRegla;

            if(!method_exists($this, $nombreMetodo)) {
                throw new Exception('No existe una validación llamada ' . $nombreRegla . '.');
            }

            $this->{$nombreMetodo}($campo, $parametroRegla);
        } else {
            $nombreMetodo = '_' . $regla;

            if(!method_exists($this, $nombreMetodo)) {
                throw new Exception('No existe una validación llamada ' . $regla . '.');
            }
            $this->{$nombreMetodo}($campo);
        }
    }

    /**
     * Agrega el $mensaje de error para el $campo.
     *
     * @param string $campo
     * @param string $mensaje
     */
    protected function registrarError($campo, $mensaje)
    {
        // Verificamos si existe ya una posición para el $campo, y sino la creamos.
        if(!isset($this->errores[$campo])) {
            $this->errores[$campo] = [];
        }

        // Pusheamos el mensaje.
        $this->errores[$campo][] = $mensaje;
    }

    /**
     * Retorna true si no hubo errores de validación.
     * false de lo contrario.
     *
     * @return bool
     */
    public function passes()
    {
        return empty($this->errores);
    }

    /**
     * Retorna el array de errores.
     *
     * @return array
     */
    public function getErrores()
    {
        return $this->errores;
    }

    /*
    * @param string $campo
    */
    protected function _required($campo)
    {
        // Realizamos la validación, y si falla, guardamos un mensaje de error.
        if(empty($this->campos[$campo])) {
            $this->registrarError($campo, 'El campo ' . $campo . ' debe completarse. ');
        }
    }

    /**
     * Valida que el valor del campo sea un número.
     *
     * @param string $campo
     */
    protected function _numeric($campo)
    {
        if(!is_numeric($this->campos[$campo])) {
            $this->registrarError($campo, 'El campo ' . $campo . ' debe ser un número. ');
        }
    }

    /**
     * Valida que el campo tenga al menos $cantidad caracteres.
     *
     * @param string $campo
     * @param int $cantidad
     */
    protected function _min($campo, $cantidad)
    {
        if(strlen($this->campos[$campo]) < $cantidad) {
            $this->registrarError($campo, 'El campo ' . $campo . ' debe tener al menos ' . $cantidad . ' caracteres.');
        }
    }
}
