<?php
namespace Jd;

use \Exception;
use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Json;

class JdClient
{
    public $serverUrl = "https://api.jd.com/routerjson";
    public $accessToken;
    public $connectTimeout = 0;
    public $readTimeout = 0;
    public $appKey;
    public $appSecret;
    public $version = "2.0";
    public $format = "json";
    private $charset_utf8 = "UTF-8";
    private $json_param_key = "360buy_param_json";

    protected function generateSign($params)
    {
        ksort($params);
        $stringToBeSigned = $this->appSecret;
        foreach ($params as $k => $v) {
            if("@" != substr($v, 0, 1)) {
                $stringToBeSigned .= "$k$v";
            }
        }
        unset($k, $v);
        $stringToBeSigned .= $this->appSecret;
        return strtoupper(md5($stringToBeSigned));
    }

    public function curl($url, $postFields = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($this->readTimeout) {
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->readTimeout);
        }
        if ($this->connectTimeout) {
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
        }
        //https 请求
        if(strlen($url) > 5 && strtolower(substr($url,0,5)) == "https" ) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        if (is_array($postFields) && 0 < count($postFields)) {
            $postBodyString = "";
            $postMultipart = false;
            foreach ($postFields as $k => $v) {
                if ("@" != substr($v, 0, 1)) { // 判断是不是文件上传
                    $postBodyString .= "$k=" . urlencode($v) . "&";
                } else { //文件上传用multipart/form-data，否则用www-form-urlencoded
                    $postMultipart = true;
                }
            }
            unset($k, $v);
            curl_setopt($ch, CURLOPT_POST, true);
            if ($postMultipart) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString, 0, -1));
            }
        }
        $response = curl_exec($ch);
        $this->recordAccessOutLog($ch, 'POST', $url, $response, $postFields, ['logResponse' => true]);
        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch), 0);
        } else {
            $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (200 !== $httpStatusCode) {
                throw new Exception($response, $httpStatusCode);
            }
        }
        curl_close($ch);
        return $response;
    }

    public function execute($request, $access_token = null)
    {
        //组装系统参数
        $sysParams["app_key"] = $this->appKey;
        $sysParams["v"] = $this->version;
        $sysParams["method"] = $request->getApiMethodName();
        $sysParams["timestamp"] = date("Y-m-d H:i:s");
        if (null != $access_token) {
            $sysParams["access_token"] = $access_token;
        }

        //获取业务参数
        $apiParams = $request->getApiParas();
        $sysParams[$this->json_param_key] = $apiParams;

        //签名
        $sysParams["sign"] = $this->generateSign($sysParams);
        //系统参数放入GET请求串
        if (strpos($this->serverUrl, '?') !== false) {
            $requestUrl = $this->serverUrl . "&";
        } else {
            $requestUrl = $this->serverUrl . "?";
        }
        foreach ($sysParams as $sysParamKey => $sysParamValue) {
            $requestUrl .= "$sysParamKey=" . urlencode($sysParamValue) . "&";
        }
        //发起HTTP请求
        try {
            $resp = $this->curl($requestUrl, $apiParams);
        } catch (Exception $e) {
            $result->code = $e->getCode();
            $result->msg = $e->getMessage();
            return $result;
        }

        //解析JD返回结果
        $respWellFormed = false;
        if ("json" == $this->format) {
            $respObject = json_decode($resp, true);
            if (null !== $respObject) {
                $respWellFormed = true;
                foreach ($respObject as $propKey => $propValue) {
                    $respObject = $propValue;
                }
            }
        } else if("xml" == $this->format) {
            $respObject = @simplexml_load_string($resp);
            if (false !== $respObject) {
                $respWellFormed = true;
            }
        }

        //返回的HTTP文本不是标准JSON或者XML，记下错误日志
        if (false === $respWellFormed) {
            $result->code = 0;
            $result->msg = "HTTP_RESPONSE_NOT_WELL_FORMED";
            return $result;
        }

        return $respObject;
    }

    public function exec($paramsArray)
    {
        if (!isset($paramsArray["method"])) {
            trigger_error("No api name passed");
        }
        $inflector = new LtInflector;
        $inflector->conf["separator"] = ".";
        $requestClassName = ucfirst($inflector->camelize(substr($paramsArray["method"], 7))) . "Request";
        if (!class_exists($requestClassName)) {
            trigger_error("No such api: " . $paramsArray["method"]);
        }

        $session = isset($paramsArray["session"]) ? $paramsArray["session"] : null;

        $req = new $requestClassName;
        foreach($paramsArray as $paraKey => $paraValue)
        {
            $inflector->conf["separator"] = "_";
            $setterMethodName = $inflector->camelize($paraKey);
            $inflector->conf["separator"] = ".";
            $setterMethodName = "set" . $inflector->camelize($setterMethodName);
            if (method_exists($req, $setterMethodName)) {
                $req->$setterMethodName($paraValue);
            }
        }
        return $this->execute($req, $session);
    }

    private function recordAccessOutLog($ch, $method, $url, $content, $params, $options = [])
    {
        // 如果是跑test case的直接跳过
        if (YII_ENV == 'test') {
            return true;
        }

        $info = curl_getinfo($ch);
        $message = [
            'type' => 'accessOut',
            'remoteAddr' => $info['primary_ip'],
            'reqId' => defined('REQUEST_ID') ? REQUEST_ID : '00000000-0000-0000-0000-000000000000',
            'scheme' => parse_url($url, PHP_URL_SCHEME),
            'host' => parse_url($url, PHP_URL_HOST),
            'port' => $info['primary_port'],
            'method' => $method,
            'url' => substr($url, strpos($url, parse_url($url, PHP_URL_PATH))),
            'responseStatus' => $info['http_code'],
            'responseTime' => floor($info['total_time'] * 1000), // 单位:毫秒
            'others' => [
                'contentType' => $info['content_type'],
                'namelookupTime' => floor($info['namelookup_time'] * 1000),
                'connectTime' => floor($info['connect_time'] * 1000),
                'pretransferTime' => floor($info['pretransfer_time'] * 1000),
                'starttransferTime' => floor($info['starttransfer_time'] * 1000),
            ],
        ];

        if (!empty($params) && in_array($method, ['POST', 'PUT'])) {
            $message['body'] = $params;
        }

        if (isset($options['logResponse']) && $options['logResponse']) {
            $message['others']['responseBody'] = $content;
        }

        $encodedMessage = Json::encode($message) . "\n";

        if (defined('DISABLE_ACCESS_OUT_LOG')) {
            $logFile = Yii::$app->getRuntimePath() . '/logs/access-out.log';
            $logPath = dirname($logFile);
            if (!is_dir($logPath)) {
                FileHelper::createDirectory($logPath, 0775, true);
            }
            $text = '[' . date('Y-m-d H:i:s', time()) . ']' . $encodedMessage;
            $file = fopen($logFile, 'a');
            fwrite($file, $text);
            fclose($file);

            return true;
        }

        if (PHP_SAPI === 'cli') {
            echo $encodedMessage;
        } else {
            file_put_contents('/var/run/phplog', $encodedMessage);
        }

        return true;
    }
}
