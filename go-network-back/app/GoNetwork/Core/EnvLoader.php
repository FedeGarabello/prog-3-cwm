<?php

namespace GoNetwork\Core;

class EnvLoader
{
    /** @var string */
    private $name = ".env";

    /** @var array */
    private $data = [];

    /**
     *
     * @param string $path
     */
    public function __construct($path = "")
    {
        $this->loadEnv($path . "/" . $this->name);
        echo $this->loadEnv($path . "/" . $this->name);
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
        $split = strpos($line, '=');
        if($split <= 0) {
            return;
        }

        $key = substr($line, 0, $split);
        $value = substr($line, $split + 1);

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
