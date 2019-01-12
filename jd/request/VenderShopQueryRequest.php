<?php
namespace Jd\request;

class VenderShopQueryRequest
{
    private $apiParas = array();

    public function getApiMethodName()
    {
        return "jingdong.vender.shop.query";
    }

    public function getApiParas()
    {
        return json_encode(new \stdClass());
    }

     public function check()
     {
     }

     public function putOtherTextParam($key, $value)
     {
          $this->apiParas[$key] = $value;
          $this->$key = $value;
     }
}
