<?php namespace Yandex\RichContentAPI;

use GuzzleHttp\Client;

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
	public $url;

    /**
     * Optional parameters
     * See documentation
     * @link https://tech.yandex.com/rca/doc/dg/index-docpage/
     *
     * @var array
     */
    public $options = [];


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
     */
    protected function executeData($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);

        $json = curl_exec($ch);
        var_dump($json);

        if ($json === false) {
            throw new Exception(curl_error($ch), curl_errno($ch));
            echo curl_error($ch) . curl_errno($ch);
            echo "123";
        }

        curl_close($ch);

        $data = json_decode($json, true);

        return $data;
    }

}