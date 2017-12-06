<?php
namespace App\Controllers\helpers;
use Phalcon\DI;
trait NewsTraits
{
    private $rulesCreate = [
        [
            'type'   => 'required',
            'fields' => [
                'name',
                'image',
                'thumbnail',
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
                'name',
                'image',
                'thumbnail',
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
                    'id' => $vData['id'],
                    'name' => $vData['name'],
                    'detail' => $vData['detail'],
                    'thumbnail' => $this->baseConfig->image_path.$vData['thumbnail'],
                    'image' => $this->baseConfig->image_path.$vData['image'],
                    'app_show' => $vData['app_show'],
                    'position' => $vData['position'],
                    'start_date' => $vData['start_date'],
                    'end_date' => $vData['end_date'],
                    'created_at' => $vData['created_at'],
                    'updated_at' => $vData['updated_at'],
                    'status' => $vData['status'],
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
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'detail' => $data['detail'],
                    'thumbnail' => $this->baseConfig->image_path.$data['thumbnail'],
                    'image' => $this->baseConfig->image_path.$data['image'],
                    'app_show' => $data['app_show'],
                    'position' => $data['position'],
                    'start_date' => $data['start_date'],
                    'end_date' => $data['end_date'],
                    'created_at' => $data['created_at'],
                    'updated_at' => $data['updated_at'],
                    'status' => $data['status'],
                ];
        }
        
        return $dataDetail;
    }


}

