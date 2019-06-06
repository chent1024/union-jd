<?php

namespace UnionJd\Api;

/**
 * 查询商品API
 *
 * @package UnionJd\Api
 */
class Order extends Request
{
    /**
     * 订单查询接口 [jd.union.open.order.query]
     *
     * @param $param
     * @return mixed
     */
    public function query($param)
    {
        $param['pageNo'] = isset($param['pageNo']) ? $param['pageNo'] : 1;
        $param['pageSize'] = isset($param['pageSize']) ? $param['pageSize'] : 20;
        $param['type'] = isset($param['type']) ? $param['type'] : 1;
        $param = [
            'orderReq' => $param
        ];

        return $this->execute('jd.union.open.order.query', $param);
    }
}
