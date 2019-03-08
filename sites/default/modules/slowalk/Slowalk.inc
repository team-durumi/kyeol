<?php
/**
 * Created by PhpStorm.
 * User: js
 * Date: 2019-03-06
 * Time: 15:10
 */

class Slowalk
{
    public $vol, $catLabel, $category, $webzines, $person, $location, $years, $writer, $featureIds, $featureLabel, $baseUrl;

    public function __construct()
    {
        global $base_url;
        $this->vol = variable_get('wz_main_vol', '');   //호수
        $this->featureIds = array();    //메인피쳐
        $this->baseUrl = $base_url;

        //기사 분류
        $this->catLabel = array(
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
        $this->featureLabel = array(
            $this->catLabel[$this->category[0]],
            $this->catLabel[$this->category[1]]
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

    protected function getData($data)
    {
        $request = drupal_http_request($this->baseUrl . '/ajax/webzine', array(
            'headers' => array('Content-Type' => 'application/x-www-form-urlencoded'),
            'method' => 'POST',
            'data' => http_build_query($data)
        ));
        dpm($request);
        if(isset($request->data)) {
            return drupal_json_decode($request->data);
        } else {
            return array();
        }
    }
}

class Main extends Slowalk
{
    /**
     * @return array
     */
    public function slide(): array
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
    public function features(): array
    {
        $features = array();
        if($this->vol) {
            for($i = 0; $i < 2; $i++) {
                $data = array(
                    'vol' => $this->vol,
                    'category' => $this->category[$i],
                    'type' => 'features'
                );
                $request = $this->getData($data);
                $this->featureIds[] = $request['nid'];
                $features[] = $request;
            }
        }
        return $features;
    }

    public function articles(): array
    {
        $articles = array();
        if(empty($this->featureIds)) {
            $this->features();
        }

        if(!empty($this->featureIds) && $this->vol) {
            $data = array(
                'vol' => $this->vol,
                'nid' => $this->featureIds,
                'type' => 'articles'
            );

            $articles = $this->getData($data);
        }
        return $articles;
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