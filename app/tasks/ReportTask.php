<?php

use Phalcon\Cli\Task;

class ReportTask extends Task
{
    private $path = 'public/data/report';
    private $configMail;
    public function initialize(){
        $this->configMail = $this->config['mail'];

    }
	// Method for get sms repo
    private function getRepo(){
        return $this->repository->getRepository('ReportLogRepository');
    }
    public function runAction(array $params)
    {
        echo "==========================================================\n";
        echo '================== ENVIRONMENT : '.getenv('ENVIRONMENT')." ==================\n";
        echo "==========================================================\n\n";
        $data = $this->chunkSendReport(0,100);

    }
    private function chunkSendReport($start = 0,$limit = 100){

        $filter['status'] = 'W';
        $filter['offset'] = $start;
        $filter['limit']  = $limit;

        echo "==========================================================\n";
        echo '🚀 '." Status : ".$filter['status']." and Start : $start and Limit : $limit \n";
        echo '🚀 '." Start Process (Memory Usage: ".memory_get_usage().")\n";
        echo "==========================================================\n";
        try {
            $data = $this->getRepo()->getRequestReport($filter);

            if(count($data) > 0){
                foreach ($data as $key => $value) {
                    $nameFile = $value['cvid'].'_'.time();
                    $date = explode('|', $value['date']);

                    $dataReport['customer'] = $value;
                    // loop get data redeem

                    $arrRedeem['id'] = $value['id'];
                    $arrRedeem['email'] = $value['email'];
                    $arrRedeem['date'] = $date;
                    $arrRedeem['customer_name'] = $value['customer_name'];

                    foreach ($date as $vkey => $vDate) {
                        $value['date'] = $vDate;
                        $dataReport['redeem'] = $this->getRepo()->getDataReport($value);

                        # writer File excel
                        $fullName = $nameFile.'_'.$vDate.".xlsx";
                        $this->writeFile($dataReport , $fullName);
                        $arrRedeem['files'][] = $fullName;
                    }
                    // Send Report
                    $this->sendReport($arrRedeem);
                }
                sleep(1);
                # Run chunk send report
                $start = $start + $limit;
                $this->chunkSendReport($start,$limit);
            }else{
                echo '🚧 '." No Data ...\n";
            }

        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }

    }
    private function sendReport($data){

        # send email
        $statusEmail = $this->sendEmail($data);
        if($statusEmail){
            # update status table report_log
            $update = $this->getRepo()->updateStatusReportLog($data['id']);
            if($update){
                echo ' 📝 ' . "ID : ".$data['id'] ." Status : SUCCESS. \n";
            }else{
                echo ' 📝 ' . "ID : ".$data['id'] ." Status : FAIL. \n";
            }
        }
    }
    private function sendEmail($data){
        try {

            $mailer = new \Phalcon\Ext\Mailer\Manager((array) $this->configMail);

            $viewPath = 'email/forgot_message';
            // Set variables to views (OPTIONAL)
            $viewsDirLocal = __DIR__ . '/views/';

            $params = [
                'name' => $data['customer_name'],
                'date' => $data['date'],
            ];

            $message = $mailer->createMessageFromView($viewPath, $params, $viewsDirLocal)
                    ->to($data['email'], 'CP Fivestar')
                    ->subject('You requested redeem history');

            // Set the Cc addresses of this message.
            //$message->cc('example_cc@gmail.com');

            // Set the Bcc addresses of this message.
            //$message->bcc('example_bcc@gmail.com');

            // Set File.
            foreach ($data['files'] as $key => $name) {
                $message->attachment($this->path . '/'. $name);
            }
            // Send message
            if($message->send()){
                echo "Email Sending. \n";
                return true;
            }
            echo '❌ '."Email Can Not Send. \n";
            return false;
        } catch (\Exception $e) {
            echo '❌ '.$e->getMessage()." \n";
            return false;
        }

    }
    private function writeFile($data , $fullName){

        $header = [
            'Customers Name' => 'string',
            'Member Code'    => 'string',
            'Campaign Name'  => 'string',
            'Redeem Code'    => 'string',
            'Use Date'       => 'YYYY-MM-DD HH:MM:SS',
        ];

        $wExcel = new \Ellumilel\ExcelWriter();
        $wExcel->writeSheetHeader('Sheet1', $header);
        $wExcel->setAuthor('report redeem');
        // $styleArray = array(
        //       'borders' => array(
        //           'allborders' => array(
        //               'style' => \PHPExcel_Style_Border::BORDER_THIN
        //           )
        //       )
        //   );
        // $wExcel->getDefaultStyle()->applyFromArray($styleArray);
        // $wExcel->getStyle("A1:Z1")->applyFromArray(
        //     array(
        //         'borders' => array(
        //             'allborders' => array(
        //                 'style' => PHPExcel_Style_Border::BORDER_THIN,
        //                 'color' => array('rgb' => 'DDDDDD')
        //             )
        //         )
        //     )
        // );
        // $wExcel->getActiveSheet()
        // ->getStyle("A".($rowNumber-1).":E".($rowNumber-1))
        // ->applyFromArray($styleBordersArray, False);
        // $wExcel = array(
        //   'borders' => array(
        //     'allborders' => array(
        //       'style' => \PHPExcel_Style_Border::BORDER_THIN
        //     )
        //   )
        // );
        foreach ($data['redeem'] as $key => $value) {
            $wExcel->writeSheetRow('Sheet1', [
                $data['customer']['customer_name'],
                $data['customer']['member_code'],
                $value['campaign_name'],
                $value['redeem_code'],
                $value['used_date'],
            ]);
        }
        $wExcel->writeToFile($this->path . "/". $fullName);
    }

}