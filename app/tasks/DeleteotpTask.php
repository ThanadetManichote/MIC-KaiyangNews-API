<?php

use Phalcon\Cli\Task;

class DeleteotpTask extends Task
{
    public function runAction(array $params) 
    {
        echo "==========================================================\n";
        echo '================== ENVIRONMENT : '.getenv('ENVIRONMENT')." ==================\n";
        echo "==========================================================\n\n";
        $data = $this->deleteOTP($params);
    }

    private function deleteOTP($params)
    {
        $expire = $params['0'];

        $this->otpRepository = $this->repository->getRepository('OtpRepository');

        $input = ['expire' => $expire];
        $records = $this->otpRepository->deleteOTPCode($input);

        print_r($records);
        die();
    }

}
