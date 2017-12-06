<?php
namespace App\Library;

use App\Models\Cms;
use Phalcon\DI;

class DrawMemberCard {

    protected $draw;
    protected $pathSave;

    protected $card_config = [
        'width'            => '600',
        'height'           => '338',
        'font_size_name'   => '18',
        'font_size_idcard' => '16',
        'width_member'     => '80',
        'height_member'    => '80',
    ];

    public function __construct() {

        // var_dump($this->config->['CDN_PATH']);
        //$this->pathSave = $this->config['CDN_PATH'];

        $this->baseConfig = DI::getDefault()->get('config');
    }

    private function _setConfigClassicCard()
    {
        $config = [
            'cardImage' => [
                'width'     => '600',
                'height'    => '338',
                'backgroud' => $this->baseConfig->card_path->pic,
            ],
            'profileImage' => [
                'width'   => '110',
                'height'  => '110',
                'ratio'   => '110',
                'x'       => '450',
                'y'       => '30',
                'default' => $this->baseConfig->card_path->picdefault

            ],
            'name'      => [
                'x'      => '60',
                'y'      => '100',
                'font'   => '33',
                'lenght' => '20'
            ],
            'header'    => [
                'x'    => '60',
                'y'    => '200',
                'text' => 'Member No.',
                'font' => '22'
            ],
            'id'        => [
                'x'     => '60',
                'y'     => '245',
                'font'  => '30',
                'split' => '4'
            ],
            'font' => [
                'pathB' => 'font/RSU_BOLD.ttf',
                'pathL' => 'font/RSU_light.ttf',
                'color' => '#fff',
                'style' => 'bold',
            ]

        ];

        return $config;
    }
    


    //for group image
    public function createCardmember($params)
    {
         $config = $this->_setConfigClassicCard();
         $config = self::changeLang($config, $params);

         $canvas = new \Imagick();

         $canvas->newImage( $config['cardImage']['width'], $config['cardImage']['height'], new \ImagickPixel('transparent'));
         $canvas->setImageFormat( 'png' );

         $frameImage = new \Imagick( $config['cardImage']['backgroud']);
         $canvas->compositeImage( $frameImage, \imagick::COMPOSITE_OVER, 0, 0 );

         // draw profile image
         $this->drawImageCircle(
            $canvas,
            $params['pic'],
            $config['profileImage']['ratio'],
            $config['profileImage']['x'],
            $config['profileImage']['y'],
            $config['profileImage']['default']
        );

        // draw text name
        $this->drawText(
            $canvas,
            $this->substrName($params['name'],$config['name']['lenght']),
            $config['name']['x'],
            $config['name']['y'],
            $config['name']['font'],
            $config['font']['color'],
            $config['font']['pathB']
        );
         
         // draw text id
         $this->drawText(
            $canvas,
            $this->spritCardNumber($params['id']),
            $config['id']['x'],
            $config['id']['y'],
            $config['id']['font'],
            $config['font']['color'],
            $config['font']['pathB']
        );
         
         // draw text title 
         $this->drawText(
            $canvas,
            $config['header']['text'],
            $config['header']['x'],
            $config['header']['y'],
            $config['header']['font'],
            $config['font']['color'],
            $config['font']['pathL']
        );
         

         return $canvas;
    }


    protected function drawText($image,$text='',$x,$y,$size,$color,$font){
         $draw  = new \ImagickDraw();
         $draw->setFont($font);
         $draw->setTextEncoding('utf8');
         $draw->setFillColor($color);
         $draw->setFontSize($size);
         $draw->setFontWeight(100);
         $draw->annotation($x, $y, $text);
         $image->drawImage($draw);
          
    }

    protected function drawImageCircle($canvas,$pic,$size,$x,$y,$default='')
    {
        $goCircle    = true;
        $content_pic = @file_get_contents($pic);

        if (isset($http_response_header[0]) && $http_response_header[0] == 'HTTP/1.1 200 OK' && $pic != '') {
        
            try {
                $profileImage = new \Imagick($pic);

            } catch (ImagickException $ex) {
                $profileImage = new \Imagick($default);

            }

        } else { 
            $profileImage = new \Imagick($default);
            $goCircle = false;
        }
        
        $circle    = new \Imagick();
        $imageSize = @getimagesize($pic);

        if (!$imageSize) {
            $imageSize = getimagesize($default);
        }
        list($width, $height) = $imageSize;
         if($width >= $height){
            $h = $size;
            $w = $width * $size / $height ;
         }else{
            $w = $size;
            $h = $height * $size / $width ;
         }

        $profileImage->resizeimage($w, $h, \Imagick::FILTER_LANCZOS, 1.0, true);
        $circle->newImage( $size, $size, new \ImagickPixel('transparent'));
        $draw = new \ImagickDraw();

        if ($goCircle) {
            $draw->circle($size/2, $size/2, $size/2, $size-2);
            $circle->drawImage($draw);
            $profileImage->compositeImage( $circle, \imagick::COMPOSITE_COPYOPACITY, 0, 0 );
        }

        $canvas->compositeImage( $profileImage, \imagick::COMPOSITE_OVER, $x, $y );
       
    }

    protected function spritCardNumber($card_id){
        $card_id = str_split($card_id,4);
        $card_id_sprit = '';
        foreach ($card_id as $id) {
            $card_id_sprit .= $id.' ';
        }
        return $card_id_sprit;
    }

    protected function substrName($name, $lenght){
        $countText = strlen($name);
        $textStr   = iconv_substr($name, 0, $lenght, "UTF-8");
        $name      = $countText > $lenght ? $textStr . "..." : $name;
        return trim($name);
    }

    private function changeLang($config, $params)
    {
        if ($params['lang'] == 'mm') {

            $config['header']['text'] = 'မန်ဘာ နံပါတ်';
            $config['header']['font'] = '16';
            $config['font']['pathL']  = 'font/myanmar-regular.ttf';
        }

        return $config;
    }


}