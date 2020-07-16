<?php
namespace Jd\request;

class PopOrderEnSearchRequest
{
    private $apiParas = array();
    private $version;
    private $startDate;
    private $endDate;
    private $orderState;
    private $optionalFields;
    private $page;
    private $pageSize;
    private $sortType;
    private $dateType;

    public function getApiMethodName()
    {
        return 'jingdong.pop.order.enSearch';
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

    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
        $this->apiParas['start_date'] = $startDate;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
        $this->apiParas['end_date'] = $endDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function setOrderState($orderState)
    {
        $this->orderState = $orderState;
        $this->apiParas['order_state'] = $orderState;
    }

    public function getOrderState()
    {
        return $this->orderState;
    }

    public function setOptionalFields($optionalFields)
    {
        $this->optionalFields = $optionalFields;
        $this->apiParas['optional_fields'] = $optionalFields;
    }

    public function getOptionalFields()
    {
        return $this->optionalFields;
    }

    public function setPage($page)
    {
        $this->page = $page;
        $this->apiParas['page'] = $page;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function setPageSize($pageSize)
    {
        $this->pageSize = $pageSize;
        $this->apiParas['page_size'] = $pageSize;
    }

    public function getPageSize()
    {
        return $this->pageSize;
    }

    public function setSortType($sortType)
    {
        $this->sortType = $sortType;
        $this->apiParas['sortType'] = $sortType;
    }

    public function getSortType()
    {
        return $this->sortType;
    }

    public function setDateType($dateType)
    {
        $this->dateType = $dateType;
        $this->apiParas['dateType'] = $dateType;
    }

    public function getDateType()
    {
        return $this->dateType;
    }
}
