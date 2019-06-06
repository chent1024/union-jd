<?php

namespace UnionJd\Api;

/**
 * 查询商品API
 *
 * @package UnionJd\Api
 */
class Goods extends Request
{
    /**
     * 京粉精选商品查询接口 [jd.union.open.goods.jingfen.query]
     *
     * @param array $param
     * @return bool|mixed
     */
    public function jingfen(array $param = [])
    {
        $param['pageIndex'] = isset($param['pageIndex']) ? $param['pageIndex'] : 1;
        $param['pageSize'] = isset($param['pageSize']) ? $param['pageSize'] : 20;
        $param['sortName'] = isset($param['sortName']) ? $param['sortName'] : 'inOrderCount30DaysSku';
        $param['sort'] = isset($param['sort']) ? $param['sort'] : 'desc';
        $param = [
            'goodsReq' => $param
        ];

        return $this->execute('jd.union.open.goods.jingfen.query', $param);
    }

    /**
     * 关键词商品查询接口 [jd.union.open.goods.query]
     *
     * @param array $param
     * @return bool|mixed
     */
    public function query(array $param = [])
    {
        $param = [
            'goodsReqDTO' => $param
        ];

        return $this->execute('jd.union.open.goods.query', $param);
    }
}