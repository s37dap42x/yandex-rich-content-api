<?php namespace Yandex\RichContentAPI;

/**
 * Class Exception
 * look up documentation
 * @link https://tech.yandex.com/rca/doc/dg/index-docpage/
 * @package Yandex\RichContentAPI
 */
class Exception extends \Exception
{
    public function __construct($code, $data)
    {
        $this->code = $code;

        switch ($code) {
            case '400':
            case '500':
            case '502':
                foreach($data as $key => $value) {
                    $this->message .= $key . ": " . $value . ";" . PHP_EOL;
                }
                break;
            case '401':
                $this->message = "Invalid key.";
                break;
            case '403':
                $this->message = "The mandatory key parameter is missing.";
                break;
            default:
                $this->message = "Unknown error, try again";
                break;
        }

        parent::__construct();
    }
}