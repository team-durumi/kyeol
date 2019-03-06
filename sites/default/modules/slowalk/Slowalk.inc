<?php
/**
 * Created by PhpStorm.
 * User: js
 * Date: 2019-03-06
 * Time: 15:10
 */

class Slowalk
{
    public $vol, $category, $main, $webzines, $person, $location, $years, $writer;

    public function __construct()
    {
        //호수
        $this->vol = variable_get('wz_main_vol', '');

        //기사 분류
        $catLabel = array(
            2 => '연구자의 말',
            3 => '논평',
            4 => '에세이',
            5 => '자료해제',
            6 => '연구자와 지원단체',
            7 => '인터뷰'
        );
        $this->category = array(
            variable_get('wz_main_first_feature', ''),
            variable_get('wz_main_second_feature', '')
        );

        //메인페이지
        $this->main = array(
            'vol' => '',
            'slide' => array(),
            'features' => array(),
            'articles' => array()
        );

        //지난호 보기
        $this->webzines = '';

        //모아보기 - 인물
        $this->person = '';

        //모아보기 - 지역
        $this->location = '';

        //모아보기 - 시기
        $this->years = '';

        //모아보기 - 필자
        $this->writer = '';
    }
}

class Main extends Slowalk
{
    /**
     * @return array
     */
    protected function slide(): array
    {
        $total = variable_get('wz_slide_count', 0);
        $slide = array();
        if($total) {
            for($i=1; $i<=$total; $i++) {
                $slide[] = array(
                    'title' => variable_get('slide_'.$i.'_title', ''),
                    'body' => variable_get('slide_'.$i.'_body', ''),
                    'fid' => variable_get('slide_'.$i.'_image', ''),
                    'link' => variable_get('slide_'.$i.'_link', ''),
                    'blank' => variable_get('slide_'.$i.'_blank', '')
                );
            }
        }
        return $slide;
    }

    /**
     * @return array
     */
    protected function features(): array
    {
        global $base_url;
        $features = array();
        for($i = 0; $i < 2; $i++) {
            $data = array(
                'vol' => $this->vol,
                'category' => $this->category[$i],
                'type' => 'features'
            );
            $features[] = drupal_http_request($base_url . '/webzine/ajax', array(
                'methid' => 'POST',
                'data' => http_build_query($data)
            ));
        }
        return $features;
    }
}

class Webzines extends Slowalk
{

}

class Location extends Slowalk
{

}

class Years extends Slowalk
{

}

class Writer extends Slowalk
{

}