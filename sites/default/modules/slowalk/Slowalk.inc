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
        if(isset($request->data)) {
            return drupal_json_decode($request->data);
        } else {
            return array();
        }
    }

    public function vol()
    {
        if($this->vol) {
            $term = taxonomy_term_load($this->vol);
            return $term->name;
        } else {
            return 0;
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
                if($request) {
                    $this->featureIds[] = $request['nid'];
                    $features[] = $request;
                }
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
    //연구자의 말
    function opinion()
    {
        return $this->getWebzine(2);
    }
    //자료해제
    function annotation()
    {
        return $this->getWebzine(5);
    }
    //연구자와 지원단체
    function personnel()
    {
        return $this->getWebzine(6);
    }
    //논평
    function review()
    {
        return $this->getWebzine(3);
    }
    //에세이
    function essay()
    {
        return $this->getWebzine(4);
    }
    //인터뷰
    function interview()
    {
        return $this->getWebzine(7);
    }

    private function getWebzine($category)
    {
        $machine_names = array(
            2 => 'opinion',
            3 => 'review',
            4 => 'essay',
            5 => 'annotation',
            6 => 'personnel',
            7 => 'interview'
        );
        $options['category'] = $this->catLabel[$category];
        $query = new EntityFieldQuery();
        $result = $query->entityCondition('entity_type', 'node')
            ->entityCondition('bundle', 'article')
            ->propertyCondition('status', 1)
            ->fieldCondition('field_vol', 'tid', $this->vol)
            ->fieldCondition('field_category', 'tid', $category)
            ->propertyOrderBy('created', 'DESC')
            ->execute();
        if(isset($result['node'])) {
            $nids = array_keys($result['node']);
            $opinion = node_load_multiple($nids);
            $rows = array();
            foreach($opinion as $item) {
                $rows[] = array(
                    '{{ img }}' => ($item->field_image) ? image_style_url('main_article', $item->field_image['und'][0]['uri']) : fiel_create_url('public://default_images/noimage_default.png'),
                    '{{ vol_path }}' => '/vol/'.$item->field_vol['und'][0]['tid'],
                    '{{ vol }}' => sprintf('%02d', $this->vol()),
                    '{{ category_path }}' => '/category/' . $machine_names[$category],
                    '{{ category }}' => $this->catLabel[$category],
                    '{{ node_url }}' => '/node/' . $item->nid,
                    '{{ title }}' => $item->title,
                    '{{ summary }}' => text_summary($item->body['und'][0]['value'], 'plain_text', 100),
                    '{{ writer }}' => $this->writer($item->field_writer['und']),
                    '{{ date }}' => format_date($item->created, 'custom', 'Y.m.d')
                );
            }
            $options['rows'] = $rows;
        }
        return $this->template($options);
    }

    private function template($options)
    {
        $html = '<div class="fc_box02">
                    <h2>'.$options['category'].'</h2>
                    <ul class="lc02 lc02_01">';
        if(isset($options['rows'])) {
            foreach($options['rows'] as $row) {
                $html .= '<li>
                    <a href="#" class="thumb"><span><img src="{{ img }}" alt=""/></span></a>
                    <dl class="conA">
                        <dt>
                            <span class="category">
                                <a class="btn02 version" href="{{ vol_path }}">{{ vol }}호</a>
                                <a class="btn02 mention" href="{{ category_path }}">{{ category }}</a>
                            </span>
                            <a href="{{ node_url }}">{{ title }}</a>
                        </dt>
                        <dd>
                            <p class="summury">{{ summary }}</p>
                            <p class="meta">
                                <span>{{ writer }}</span>
                                <em>{{ date }}</em>
                            </p>
                        </dd>
                    </dl>
                </li>';
                $html = strtr($html, $row);
            }
        }
        $html .= '</ul>
                </div>';
        return $html;
    }

    private function writer($writers)
    {
        $return = array();
        foreach($writers as $writer) {
            $term = taxonomy_term_load($writer['tid']);
            $return[] = $term->name;
        }
        return implode(', ', $return);
    }

    public function total()
    {
        $query = new EntityFieldQuery();
        $result = $query->entityCondition('entity_type', 'node')
            ->entityCondition('bundle', 'article')
            ->propertyCondition('status', 1)
            ->fieldCondition('field_vol', 'tid', $this->vol)
            ->execute();
        if(isset($result['node'])) {
            return count($result['node']);
        } else {
            return 0;
        }
    }
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

class Search extends Slowalk
{
    public $key;

    public function execute()
    {
        if($this->key) {
            $result = db_select('search_index', 'si')->fields('si', array('sid'))->condition('word', $this->key)->execute();
        }
    }
}