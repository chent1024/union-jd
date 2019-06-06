<?php

namespace UnionJd\Api;

/**
 * 获取推广链接API
 *
 * @package UnionJd\Api
 */
class Promotion extends Request
{
    /**
     * 通过subUnionId获取推广链接【申请】[jd.union.open.promotion.bysubunionid.get]
     *
     * @param array $param
     * @return bool|mixed
     */
    public function bySubUnionId($param)
    {
        $param = [
            'promotionCodeReq' => $param
        ];

        return $this->execute('jd.union.open.promotion.bysubunionid.get', $param);
    }

    /**
     * 通过unionId获取推广链接【申请】[jd.union.open.promotion.byunionid.get]
     *
     * @param array $param
     * @return bool|mixed
     */
    public function byUnionId($param)
    {
        $param = [
            'promotionCodeReq' => $param
        ];

        return $this->execute('jd.union.open.promotion.byunionid.get', $param);
    }

    /**
     * 获取通用推广链接 [jd.union.open.promotion.common.get]
     *
     * @param $param
     * @return bool|mixed
     */
    public function common($param)
    {
        $param = [
            'promotionCodeReq' => $param
        ];

        return $this->execute('jd.union.open.promotion.common.get', $param);
    }
}