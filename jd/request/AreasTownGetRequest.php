<?php
namespace Jd\request;

class AreasTownGetRequest
{
    private $apiParas = array();
    private $parentId;

    public function getApiMethodName()
    {
      return "jingdong.areas.town.get";
    }

    public function getApiParas()
    {
        return json_encode($this->apiParas);
    }

    public function check(){

    }

    public function putOtherTextParam($key, $value)
    {
        $this->apiParas[$key] = $value;
        $this->$key = $value;
    }

    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
        $this->apiParas["parent_id"] = $parentId;
    }

    public function getParentId()
    {
        return $this->parentId;
    }
}
