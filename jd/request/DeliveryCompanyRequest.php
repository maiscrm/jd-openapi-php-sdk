<?php
namespace Jd\request;

class DeliveryCompanyRequest
{
    private $apiParas = array();
    private $fields;

    public function getApiMethodName()
    {
        return "360buy.get.vender.all.delivery.company";
    }

    public function getApiParas()
    {
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

    public function setFields($fields)
    {
        $this->fields = $fields;
        $this->apiParas["fields"] = $fields;
    }

    public function getFields()
    {
        return $this->fields;
    }
}
