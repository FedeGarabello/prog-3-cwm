<?php

namespace GoNetwork\Core;
class EnvLoader
{
    /** @var string */
    private $name = ".env";

    /** @var array */
    private $data = [];

    /**
     * EnvLoader constructor.
     *
     * @param string
     */
    public function __construct($path = "")
    {
        $this->loadEnv($path . "/" . $this->name);
    }

    /**
     * @param string $file
     */
    private function loadEnv(string $file)
    {
        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach($lines as $line) {

            $line = trim($line);
            if(strpos($line, '#') !== 0) {
                $this->readLine($line);
            }
        }
    }

    /**
     *
     * @param string $line
     */
    private function readLine(string $line)
    {
        $separador = strpos($line, '=');
        if($separador <= 0) {
            return;
        }
        $key = substr($line, 0, $separador);
        $value = substr($line, $separador + 1);

        $this->data[$key] = $value;
    }

    /**
     * @param string $key
     * @return array
     */
    public function getEnv(string $key): string
    {
        return $this->data[$key];
    }
}
