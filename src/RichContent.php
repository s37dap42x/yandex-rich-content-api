<?php namespace Yandex\RichContentAPI;

use Yandex\RichContentAPI\Exception;

/**
 * Class RichContent
 * @package Yandex\RichContentAPI
 */
class RichContent
{
    /**
     * Base URL to Yandex Rich Contetn API
     */
    const BASE_URI = "http://rca.yandex.com/";
    /**
     * The URL that data is being requested for
     *
     * @var string
     */
    public $url;
    /**
     * Optional parameters
     * look up documentation
     * @link https://tech.yandex.com/rca/doc/dg/index-docpage/
     *
     * @var array
     */
    public $options = [];
    /**
     * Unique API key
     *
     * @var string
     */
    protected $key;

    /**
     * Get a free API key on this page:
     * @link https://tech.yandex.com/keys/get/?service=rca
     *
     * @param string $key The API key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * @param $url
     * @return mixed
     * @throws \Yandex\RichContentAPI\Exception
     */
    public function getContent($url)
    {
        $this->url = $url;

        $exec_url = $this->composeExecURL();
        $data = $this->executeData($exec_url);

        return $data;
    }

    /**
     * Compose URL for executing
     *
     * @return string
     */
    public function composeExecURL()
    {
        $url = self::BASE_URI . "?key=" . $this->key . "&url=" . urlencode($this->url);

        if(!empty($this->options)) {
            foreach($this->options as $key => $value) {
                $url .= "&" . $key . "=" . $value;
            }
        }

        return $url;
    }


    /**
     * Execute data from API
     *
     * @param string
     * @return mixed
     * @throws \Yandex\RichContentAPI\Exception
     */
    protected function executeData($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);

        $json = curl_exec($ch);

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $data = json_decode($json, true);

        if($http_code != "200") {
            throw new Exception($http_code, $data);
        }

        return $data;
    }

}