##This library helps you generate date ranges starting from certain date.

######Example of use:

```php
$rangeByTypeGenerator = new RangeByTypeGenerator();
$dateRange = $rangeByTypeGenerator->handle(new DateTime('2016-05-18'), RangeByTypeGenerator::TYPE_LAST_MONTH);

$dateRange->getFrom();
//DateTime('2016-04-01 00:00:00')

$dateRange->getTo();
//DateTime('2016-04-30 23:59:59')
```
######You can use one of predefined types:

- TYPE_TODAY,
- TYPE_YESTERDAY,
- TYPE_THIS_WEEK,
- TYPE_LAST_WEEK,
- TYPE_LAST_THIRTY_DAYS.
- TYPE_THIS_MONTH,
- TYPE_LAST_MONTH,
- TYPE_THIS_QUARTER,
- TYPE_THIS_YEAR,
- TYPE_LAST_YEAR


