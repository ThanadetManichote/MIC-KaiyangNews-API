<?php

namespace App\Tests;

use App\Controllers\MemberController;
use App\Tests\UnitTestCase;

class MemberControllerTest extends UnitTestCase
{

    public function testgetMember()
    {

        $controler = new MemberController();
        $res       = $controler->getMemberCodeAction(1);
        $result    = $controler->unitTestAfterExecuteRoute($res);
        
        $result    = json_decode($result, 1);
        
        $this->assertEquals(11, $result['data']['id']);

    }

    // public function getMemberAction()
    // {
    //     $input = $this->getInput();
    //     $input = $this->setPagination($input);

    //     $list = $this->memberRepository->getMemberList($input);

    //     $pagination = [
    //             'page'      => $this->page,
    //             'perpage'   => $this->perpage,
    //             'totalpage' => $this->page,
    //             'records'   => $list['count']
    //         ];

    //     $records = $list['record'];
        
    //     $result = [
    //             'pagination' => $pagination,
    //             'records'    => $records
    //         ];

    //     return array(0 => $result);
    // }

    // public function getMembercardAction(){
    //    //rules
    //     $rules = array([
    //         'type'   => 'required',
    //         'fields' => ['email']
    //         ]  
    //     );

    //     //get param
    //     $inputs  = $this->getInput();
    //     $default = ['email'];
    //     $params  = $this->validateApi($rules, $default, $inputs);

    //     if (isset($params['msgError'])) {
    //         return [400 => [$params['fieldError'], $params['msgError']] ];
    //     }
    //     $data = $this->memberRepository->getDataMember($inputs['email']);

    //     $dataMember = [
    //         'name' => $data['name'],
    //         'id'   => $data['member_card'],
    //         'pic'  => $data['pic']
    //     ];
        
    //     $memberCard = $this->drawCard->createCardmember($dataMember);
        
    //     header('Content-Type: image/png');
        
    //     echo $memberCard->getImageBlob();
    // }

    // public function postRegisterAction()
    // {
    // 	$input  = $this->postInput();

    //     $input['password'] = $this->security->hash($input['password']);
    //     $input['status']   = 'active';

    //     $insert_id  = $this->memberRepository->registerMember($input);

    //     $memberCode = self::genMemberCode($insert_id);

    //     $data    = ['member_code' => $memberCode];
    //     $where   = ['id' => $insert_id];
    //     $result  = $this->memberRepository->updateMember($data, $where);

    //     return array(0 => ['id' => $insert_id]);
    // }

    // private function genMemberCode($member_id)
    // {
    //     $member_id = '00000'.$member_id;
    //     $member_id = substr($member_id, -6, 6);

    //     $codeCard = date("dmYh").$member_id;

    //     return $codeCard;
    // }
    
}