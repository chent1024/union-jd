<?php

namespace UnionJd\Api;

use Curl\Curl;
use UnionJd\Client;

class Request
{
    /**
     * 配置信息
     *
     * @var array
     */
    protected $config = [
        'api_url' => 'https://router.jd.com/api?',
        'app_key' => '',
        'secret_key' => ''
    ];

    /**
     * @var Curl
     */
    protected $curl;

    protected $method = '';

    protected $client;

    public function __construct($config, Client $client)
    {
        $this->config = array_merge($this->config, $config);
        $this->curl = new Curl();
        $this->client = $client;
    }

    /**
     * 执行接口请求
     *
     * @param string $method
     * @param array $param
     * @return bool|mixed
     */
    public function execute($method, array $param = [])
    {
        $paramStr = $this->setParam($method, $param);
        $url = $this->config['api_url'] . $paramStr;
        $this->curl->get($url);
        if ($this->curl->error) {
            return $this->setError($this->curl->errorMessage);
        }
        $this->method = $method;

        return $this->parseResponse($this->curl->getResponse());
    }

    /**
     * 格式化接口数据
     *
     * @param string $response
     * @return bool|mixed
     */
    protected function parseResponse($response)
    {
        // 兼容结果返回object问题 ╭( T □ T )╮
        if(is_object($response)){
            $res = (array)$response;
        }else{
            $res = json_decode($response, true);
        }

        $error = 'result error: ';
        if(isset($res['errorResponse'])){
            return $this->setError($error . $res['errorResponse']->msg);
        }

        if (!is_array($res)) {
            return $this->setError($error . $res);
        }

        $resKey = str_replace('.', '_', $this->method) . '_response';
        if (is_null($res) || !isset($res[$resKey])) {
            return $this->setError($error . ' data not found');
        }

        $data = $res[$resKey];
        if ($data['code'] != 0) {
            $error .= isset($data['msg']) ? $data['msg'] : "code [{$data['code']}]";
            return $this->setError($error);
        }

        $data = json_decode($data['result'], true);
        if ($data['code'] != 200) {
            $error .= isset($data['message']) ? $data['message'] : "code [{$data['code']}]";
            return $this->setError($error);
        }

        return $data;
    }

    /**
     * 设置错误信息
     *
     * @param $error
     * @return bool
     */
    public function setError($error)
    {
        $this->client->setError($error);
        return false;
    }

    /**
     * 设置参数信息
     *
     * @param string $method
     * @param array $param
     * @return string
     */
    protected function setParam($method, array $param)
    {
        $param = [
            'method' => $method,
            'app_key' => $this->config['app_key'],
            'timestamp' => date('Y-m-d H:i:s'),
            'format' => 'json',
            'v' => '1.0',
            'sign_method' => 'md5',
            'param_json' => json_encode($param)
        ];
        $param['sign'] = $this->makeSign($param);

        ksort($param);
        $str = '';
        foreach ($param as $key => $value) {
            $str .= urlencode($key) . '=' . urlencode($value) . '&';
        }
        return rtrim($str, '&');
    }

    /**
     * 参数签名
     *
     * @param array $param
     * @return string
     */
    protected function makeSign(array $param)
    {
        ksort($param);
        $str = '';
        foreach ($param as $key => $value) {
            if (!empty($value)) {
                $str .= ($key) . ($value);
            }
        }

        $str = $this->config['secret_key'] . $str . $this->config['secret_key'];

        $sign = strtoupper(md5($str));

        return $sign;
    }
}
