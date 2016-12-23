<?php

namespace xll\common\sms;

interface SmsInterface
{
    public function sendVerifyCode($mobile, $templateId, $verifyCode);

    public function sendNotify($mobile, $templateId, $params);
}