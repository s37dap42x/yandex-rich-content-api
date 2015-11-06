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
     * Unique API key
     *
     * @var string
     */
    protected $key;

    /**
     * The URL that data is being requested for
     *
     * @var string
     */
    protected $url;

    /**
     * Optional parameters
     * look up documentation
     * @link https://tech.yandex.com/rca/doc/dg/index-docpage/
     *
     * @var array
     */
    protected $options = [];

    /**
     * Composed url for executing
     *
     * @var string
     */
    private $exec_url;


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
     * Set optional parameters
     * @param array
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }


    /**
     * Get optional parameters
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }


    /**
     * Get url
     * @return string
     */
    public function getURL()
    {
        return $this->url;
    }


    /**
     * @param $url
     * @return mixed
     * @throws \Yandex\RichContentAPI\Exception
     */
    public function getContent($url)
    {
        $this->url = $url;
        $this->composeExecURL();

        return $this->executeData();
    }


    /**
     * Compose URL for executing
     */
    protected function composeExecURL()
    {
        $exec_url = self::BASE_URI . "?key=" . $this->key . "&url=" . urlencode($this->url);

        if(!empty($this->options)) {
            foreach($this->options as $key => $value) {
                $exec_url .= "&" . $key . "=" . $value;
            }
        }

        $this->exec_url = $exec_url;
    }


    /**
     * Execute data from API
     *
     * @param string
     * @return mixed
     * @throws \Yandex\RichContentAPI\Exception
     */
    protected function executeData()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->exec_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);

        $json = curl_exec($ch);

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $data = json_decode($json);

        if($http_code != "200") {
            throw new Exception($http_code, $data);
        }

        return $data;
    }

}