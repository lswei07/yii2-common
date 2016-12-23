Common for Yii 2
=========================

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist xll/yii2-common
```

or add

```
"xll/yii2-common": "~2.0.0"
```

to the require section of your `composer.json` file.


Usage
-----

yii migrate --migrationPath=@xll/common/migrations
yii migrate/down --migrationPath=@xll/common/migrations
yii migrate/create --migrationPath=@xll/common/migrations create_table

yii gii/model   --tableName=lookup    --modelClass=Lookup --ns=xll\common\models

codecept bootstrap
codecept generate:test unit models\SequenceTest

codecept run unit models\SequenceTest

params

aliyun.accessKey
aliyun.accessSecret
aliyun.oss.endpoint => http://oss-cn-hangzhou.aliyuncs.com
aliyun.oss.bucket
aliyun.sts.region
aliyun.sts.roleArn
aliyun.sms.signName