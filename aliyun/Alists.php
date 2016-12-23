<?php

namespace xll\common\aliyun;

use Yii;
use yii\base\Object;

class Alists extends Object
{
    public $sessionName = '';
    public $duration = 3600;
    public $policy = [

    ];

    private $id;
    private $secret;
    private $region;
    private $roleArn;

    private $_client;

    public function getTemporaryCredential() {
        try {
            $request = new AssumeRoleRequest();
            $request->setRoleSessionName($this->sessionName);
            $request->setRoleArn($this->roleArn);
            $request->setPolicy($this->policy);
            $request->setDurationSeconds($this->duration);

            $reponse = $this->getClient()->doAction($request);
        } catch(\Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            return false;
        }

        $credential = json_decode($reponse->getBody(), true);

        return $credential;
    }

    private function getClient() {
        if(null === $this->_client) {
            $profile = \DefaultProfile::getProfile($this->region, $this->id, $this->secret);
            $this->_client = new \DefaultAcsClient($profile);
        }
        return $this->_client;
    }
}