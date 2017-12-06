<?php
namespace App\Models;

use Phalcon\Mvc\Model;
class News extends Model
{

    public function getSource()
    {
        return 'news';
    }

    /*
    * Befor Create MySQL
    */
    public function beforeCreate()
    {
        $dateTime = date('Y-m-d H:i:s');

        $this->created_at = $dateTime;
        $this->updated_at = $dateTime;
    }

    /*
    * Befor Update MySQL
    */
    public function beforeUpdate()
    {
        $this->updated_at = date('Y-m-d H:i:s');
    }
}
