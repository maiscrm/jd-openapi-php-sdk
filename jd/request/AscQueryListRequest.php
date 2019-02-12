<?php
namespace Jd\request;

class AscQueryListRequest
{
    private $apiParas = array();
    private $buId;
    private $operatePin;
    private $operateNick;
    private $serviceId;
    private $orderId;
    private $applyTimeBegin;
    private $applyTimeEnd;
    private $finishTimeBegin;
    private $finishTimeEnd;
    private $verificationCode;
    private $expressCode;
    private $orderType;
    private $processResult;
    private $customerPin;
    private $customerName;
    private $customerTel;
    private $approveTimeBegin;
    private $approveTimeEnd;
    private $pageSize;
    private $extJsonStr;
    private $pageNumber;

    public function getApiMethodName()
    {
        return "jingdong.asc.query.list";
    }

    public function getApiParas()
    {
        return json_encode($this->apiParas);
    }

    public function check()
    {}

    public function putOtherTextParam($key, $value)
    {
        $this->apiParas[$key] = $value;
        $this->$key = $value;
    }

    public function setBuId($buId)
    {
        $this->buId = $buId;
        $this->apiParas["buId"] = $buId;
    }

    public function getBuId()
    {
        return $this->buId;
    }

    public function setOperatePin($operatePin)
    {
        $this->operatePin = $operatePin;
        $this->apiParas["operatePin"] = $operatePin;
    }

    public function getOperatePin()
    {
        return $this->operatePin;
    }

    public function setOperateNick($operateNick)
    {
        $this->operateNick = $operateNick;
        $this->apiParas["operateNick"] = $operateNick;
    }

    public function getOperateNick()
    {
        return $this->operateNick;
    }

    public function setServiceId($serviceId)
    {
        $this->serviceId = $serviceId;
        $this->apiParas["serviceId"] = $serviceId;
    }

    public function getServiceId()
    {
        return $this->serviceId;
    }

    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
        $this->apiParas["orderId"] = $orderId;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }

    public function setApplyTimeBegin($applyTimeBegin)
    {
        $this->applyTimeBegin = $applyTimeBegin;
        $this->apiParas["applyTimeBegin"] = $applyTimeBegin;
    }

    public function getApplyTimeBegin()
    {
        return $this->applyTimeBegin;
    }

    public function setApplyTimeEnd($applyTimeEnd)
    {
        $this->applyTimeEnd = $applyTimeEnd;
        $this->apiParas["applyTimeEnd"] = $applyTimeEnd;
    }

    public function getApplyTimeEnd()
    {
        return $this->applyTimeEnd;
    }

    public function setFinishTimeBegin($finishTimeBegin)
    {
        $this->finishTimeBegin = $finishTimeBegin;
        $this->apiParas["finishTimeBegin"] = $finishTimeBegin;
    }

    public function getFinishTimeBegin()
    {
        return $this->finishTimeBegin;
    }

    public function setFinishTimeEnd($finishTimeEnd)
    {
        $this->finishTimeEnd = $finishTimeEnd;
        $this->apiParas["finishTimeEnd"] = $finishTimeEnd;
    }

    public function getFinishTimeEnd()
    {
        return $this->finishTimeEnd;
    }

    public function setVerificationCode($verificationCode)
    {
        $this->verificationCode = $verificationCode;
        $this->apiParas["verificationCode"] = $verificationCode;
    }

    public function getVerificationCode()
    {
        return $this->verificationCode;
    }

    public function setExpressCode($expressCode)
    {
        $this->expressCode = $expressCode;
        $this->apiParas["expressCode"] = $expressCode;
    }

    public function getExpressCode()
    {
        return $this->expressCode;
    }

    public function setOrderType($orderType)
    {
        $this->orderType = $orderType;
        $this->apiParas["orderType"] = $orderType;
    }

    public function getOrderType()
    {
        return $this->orderType;
    }

    public function setProcessResult($processResult)
    {
        $this->processResult = $processResult;
        $this->apiParas["processResult"] = $processResult;
    }

    public function getProcessResult()
    {
        return $this->processResult;
    }

    public function setCustomerPin($customerPin)
    {
        $this->customerPin = $customerPin;
        $this->apiParas["customerPin"] = $customerPin;
    }

    public function getCustomerPin()
    {
        return $this->customerPin;
    }

    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;
        $this->apiParas["customerName"] = $customerName;
    }

    public function getCustomerName()
    {
        return $this->customerName;
    }

    public function setCustomerTel($customerTel)
    {
        $this->customerTel = $customerTel;
        $this->apiParas["customerTel"] = $customerTel;
    }

    public function getCustomerTel()
    {
        return $this->customerTel;
    }

    public function setApproveTimeBegin($approveTimeBegin)
    {
        $this->approveTimeBegin = $approveTimeBegin;
        $this->apiParas["approveTimeBegin"] = $approveTimeBegin;
    }

    public function getApproveTimeBegin()
    {
        return $this->approveTimeBegin;
    }

    public function setApproveTimeEnd($approveTimeEnd)
    {
        $this->approveTimeEnd = $approveTimeEnd;
        $this->apiParas["approveTimeEnd"] = $approveTimeEnd;
    }

    public function getApproveTimeEnd()
    {
        return $this->approveTimeEnd;
    }

    public function setPageNumber($pageNumber)
    {
        $this->pageNumber = $pageNumber;
        $this->apiParas["pageNumber"] = $pageNumber;
    }

    public function getPageNumber()
    {
        return $this->pageNumber;
    }

    public function setPageSize($pageSize)
    {
        $this->pageSize = $pageSize;
        $this->apiParas["pageSize"] = $pageSize;
    }

    public function getPageSize()
    {
        return $this->pageSize;
    }

    public function setExtJsonStr($extJsonStr)
    {
        $this->extJsonStr = $extJsonStr;
        $this->apiParas["extJsonStr"] = $extJsonStr;
    }

    public function getExtJsonStr()
    {
        return $this->extJsonStr;
    }
}
