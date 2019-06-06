Union jd
=======
京东联盟sdk

改写自 https://github.com/yumufeng/jd-union-sdk

PHP =>7.0

***wiki***: https://union.jd.com/#/openplatform/api

## 使用方法

```php
use UnionJd\Client
$jd = new Client([
    'app_key' => 'xxx',
    'secret_key' => 'xxx'
]);

$rs = $jd->order->query(['time' => '2019041610']);
// echo $jd->getError();

```

## License

MIT