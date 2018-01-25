<?php
namespace App\Controllers\helpers;
use Phalcon\DI;
trait NewsTraits
{
    private $rulesCreate = [
        [
            'type'   => 'required',
            'fields' => [
                'name_en',
                'detail_en',
                'start_date',
                'end_date',
                'status',
                'app_show'
            ]
        ],
        [
            'type' => 'inclusion_in',
            'fields' => [
                'status'
            ],
            "domain" => [
                "status" => [
                    "",
                    "active",
                    "inactive"
                ]
            ]
        ],
        [
            'type' => 'number',
            'fields' =>[
                'position'
            ]
        ]
    ];

    private $rulesUpdate = [
        [
            'type'   => 'required',
            'fields' => [
                'name_en',
                'start_date',
                'end_date',
                'status',
                'app_show'
            ]
        ],
        [
            'type' => 'inclusion_in',
            'fields' => [
                'status'
            ],
            "domain" => [
                "status" => [
                    "",
                    "active",
                    "inactive"
                ]
            ]
        ],
        [
            'type' => 'number',
            'fields' =>[
                'position'
            ]
        ]
    ];

    private $rulesStatus = [
        [
            'type'   => 'required',
            'fields' => [
                'status'
            ]
        ],
        [
            'type' => 'inclusion_in',
            'fields' => [
                'status'
            ],
            "domain" => [
                "status" => [
                    "active",
                    "inactive"
                ]
            ]
        ]
    ];

    /**
     * Set data to dateList
     * @param array $data, array $params
     */
    private function setDataList(array $data, array $params)
    {
        $this->baseConfig = DI::getDefault()->get('config');
        $dataList = [];
        if (!empty($data)) {
            foreach ($data as $kData => $vData) {
                $dataList[] = [
                    'id'          => $vData['id'],
                    'name_en'     => $vData['name_en'],
                    'name_mm'     => $vData['name_mm'],
                    'detail_en'   => $vData['detail_en'],
                    'detail_mm'   => $vData['detail_mm'],
                    'image_en'    => $vData['image_en'],
                    'image_mm'    => $vData['image_mm'],
                    'app_show'    => $vData['app_show'],
                    'position'    => $vData['position'],
                    'start_date'  => $vData['start_date'],
                    'end_date'    => $vData['end_date'],
                    'created_at'  => $vData['created_at'],
                    'updated_at'  => $vData['updated_at'],
                    'status'      => $vData['status'],
                    'sent_status' => $vData['sent_status'],
                    'sent_date'   => $vData['sent_date'],
                ];
            }
        }

        return $dataList;
    }

    private function setDataDetail(array $data)
    {
        $this->baseConfig = DI::getDefault()->get('config');
        $dataDetail = [];
        if (!empty($data)) {
                $dataDetail = [
                    'id'          => $data['id'],
                    'name_en'     => $data['name_en'],
                    'name_mm'     => $data['name_mm'],
                    'detail_en'   => $data['detail_en'],
                    'detail_mm'   => $data['detail_mm'],
                    'image_en'    => $data['image_en'],
                    'image_mm'    => $data['image_mm'],
                    'app_show'    => $data['app_show'],
                    'position'    => $data['position'],
                    'start_date'  => $data['start_date'],
                    'end_date'    => $data['end_date'],
                    'created_at'  => $data['created_at'],
                    'updated_at'  => $data['updated_at'],
                    'status'      => $data['status'],
                    'sent_status' => $data['sent_status'],
                    'sent_date'   => $data['sent_date'],
                ];
        }
        
        return $dataDetail;
    }


}

