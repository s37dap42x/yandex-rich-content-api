<?php namespace Yandex\RichContentAPI;


class RichContent
{
    /**
     * Base URL to Yandex Rich Contetn API
     */
	const BASE_API_URL = "http://rca.yandex.com/";

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
        $url = self::BASE_API_URL . "?key=" . $this->key . "&url=" . urlencode($this->url);

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
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $json = curl_exec($curl);

        curl_close($curl);
        return $json;
        /*
        $data = json_decode($json, true);

        return $data;*/
    }

}