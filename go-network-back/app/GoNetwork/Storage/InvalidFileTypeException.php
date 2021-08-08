<?php

namespace Storage\Storage;

use Throwable;

/**
 * Class InvalidFileTypeException
 *
 * Las clases de exceptions tienen como requisito heredar de la clase Exception, o al menos, implementar
 * la interfaz Throwable de php.
 *
 * No requieren tener su propio contenido, puede ser suficiente con lo que heredamos de Exception.
 *
 * @package Storage\Storage
 */
class InvalidFileTypeException extends \Exception
{
    /** @var string */
    protected $fileType;

    /**
     * InvalidFileTypeException constructor.
     *
     * @param string $fileType
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $fileType, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->fileType = $fileType;
        if($message === "") {
            $message = 'El tipo de archivo provisto no es válido. Debe ser un array o un string, se pasó un ' . $this->fileType;
        }
        parent::__construct($message, $code, $previous);
    }

    /**
     * The file type provided.
     *
     * @return string
     */
    public function getFileType(): string
    {
        return $this->fileType;
    }
}
