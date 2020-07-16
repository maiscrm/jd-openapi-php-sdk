<?php
namespace Jd\request;

class UserRelatedRpcI18nServiceGetOpenIdRequest
{
    private $apiParas = array();
    private $version;
    private $pin;

    public function getApiMethodName()
    {
        return 'jingdong.UserRelatedRpcI18nService.getOpenId';
    }

    public function getApiParas()
    {
        if (empty($this->apiParas)) {
            return '{}';
        }
        return json_encode($this->apiParas);
    }

    public function check()
    {
    }

    public function putOtherTextParam($key, $value)
    {
        $this->apiParas[$key] = $value;
        $this->$key = $value;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setPin($pin)
    {
        $this->pin = $pin;
        $this->apiParas['pin'] = $pin;
    }

    public function getPin()
    {
        return $this->pin;
    }
}
