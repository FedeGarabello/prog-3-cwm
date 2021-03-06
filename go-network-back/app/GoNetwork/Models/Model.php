<?php

namespace GoNetwork\Models;

use GoNetwork\DBConnection\DBConnection;
use GoNetwork\DBConnection\QueryException;
use GoNetwork\Utilities\Str;
use PDO;
use PDOException;

/**
 * Class Modelo
 * Base de los modelos tipo ActiveRecord del sistema.
 * Ofrece todas las acciones básicas de un ABM (traer todos, traer por PK, crear, editar, eliminar)
 * a través de unas propiedades configurables.
 *
 * @package DaVinci\Models
 */
class Model
{
    /** @var string La tabla con la que el Modelo se mapea. */
    protected $table = '';

    /** @var string El nombre del campo que es la PK. */
    protected $primaryKey = 'id';

    /** @var array La lista de atributos/campos de la tabla que se mapean con las propiedades del Modelo. */
    protected $attributes = [];

    /**
     * Asigna todos los valores de $data que referencien a atributos definidos en self::$attributes.
     *
     * @param array $data
     */
    public function cargarDatosDeArray(array $data)
    {
        foreach($this->attributes as $attribute) {

            if(isset($data[$attribute])) {

                $setter = 'set' . ucfirst(Str::snakeToCamel($attribute));
                if(method_exists($this, $setter)) {
                    $this->{$setter}($data[$attribute]);
                } else {
                    $this->{$attribute} = $data[$attribute];
                }
            }
        }
    }

    /**
     * Retorna todos los registros de la tabla.
     *
     * @return static[]
     */
    public function traerTodo(): array
    {
        $query = "SELECT * FROM " . $this->table;
        $db = DBConnection::getConnection();
        try {
            $stmt = $db->prepare($query);
            $stmt->execute();
        } catch(PDOException $e) {
            throw new QueryException($query, [], $stmt->errorInfo(), $e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        $stmt->setFetchMode(PDO::FETCH_CLASS, static::class);

        return $stmt->fetchAll();
    }

    /**
     * Retorna el registro asociado a la PK.
     *
     * @param mixed $id
     * @return static|null
     */
    public function traerPorPK($id)
    {

        $db = DBConnection::getConnection();
        $query = "SELECT * FROM " . $this->table . "
                WHERE " . $this->primaryKey . " = ?";
        try {
            $stmt = $db->prepare($query);
            $stmt->execute([$id]);
        } catch(PDOException $e) {
            throw new QueryException($query, [$id], $stmt->errorInfo(), $e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        return $stmt->fetchObject(static::class);
    }

    /**
     * Retorna el registro asociado a la PK.
     *
     * @param mixed $id
     * @return static|null
     */
    public function traerTodoPorPK($id)
    {

        $db = DBConnection::getConnection();
        $query = "SELECT * FROM " . $this->table . "
                WHERE " . $this->primaryKey . " = ?";
        try {
            $stmt = $db->prepare($query);
            $stmt->execute([$id]);
            $exit = [];
            while($row = $stmt->fetchObject(static::class)) {
                $exit[] = $row;
            }
        } catch(PDOException $e) {
            throw new QueryException($query, [$id], $stmt->errorInfo(), $e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        return $exit;
    }


    /**
     * @param array $data
     * @return bool
     */
    public function crear(array $data): bool
    {
        $db = DBConnection::getConnection();
        $columns    = $this->prepareInsertColumns($data);
        $holders    = $this->prepareInsertHolders($columns);
        $data       = $this->prepareInsertData($data, $columns);

        $query = "INSERT INTO " . $this->table . " (" . implode(',', $columns) . ")
                  VALUES (" . implode(',', $holders) . ")";

        try {
            $stmt = $db->prepare($query);
            $stmt->execute($data);
        } catch(PDOException $e) {
            throw new QueryException($query, $data, $stmt->errorInfo(), $e->getMessage(), $e->getCode(), $e->getPrevious());
        }
//            throw new
        return true;
    }

    /**
     * Retorna un array con los nombres de las columnas para el INSERT.
     * Las columnas se detectan a partir de las claves de los valores en $data que coinciden con
     * atributos de $attributes.
     *
     * @param array $data
     * @return array
     */
    protected function prepareInsertColumns(array $data)
    {
        $salida = [];
        foreach($data as $key => $value) {
            // Si existe la key de $data en los atributos, lo agregamos al INSERT.
            if(in_array($key, $this->attributes)) {
                $salida[] = $key;
            }
        }

        return $salida;
    }

    /**
     * Retorna un array con los holders.
     * Los holders van a ser los valores del array $columns con un ":" prefijado.
     *
     * @param array $columns
     * @return array
     */
    protected function prepareInsertHolders(array $columns): array
    {
        $salida = [];
        foreach($columns as $column) {
            $salida[] = ":" . $column;
        }
        return $salida;
    }

    /**
     * Retorna un array con los valores para el execute del INSERT.
     * Va a contener las claves que coinciden con las columnas y los valores de $data ascoiados.
     *
     * @param array $data
     * @param array $columns
     * @return array
     */
    protected function prepareInsertData(array $data, array $columns): array
    {
        $salida = [];
        foreach($columns as $column) {
            $salida[$column] = $data[$column];
        }
        return $salida;
    }
}
