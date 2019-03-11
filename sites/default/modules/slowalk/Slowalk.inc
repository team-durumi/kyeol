<?php
/**
 * Created by PhpStorm.
 * User: js
 * Date: 2019-03-06
 * Time: 15:10
 */

class Slowalk
{
    public $vol, $catLabel, $category, $years, $featureIds, $featureLabel, $baseUrl, $machine_name;

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
        $this->machine_name = array(
            2 => 'opinion',
            3 => 'review',
            4 => 'essay',
            5 => 'annotation',
            6 => 'personnel',
            7 => 'interview'
        );
        $this->category = array(
            variable_get('wz_main_first_feature', ''),
            variable_get('wz_main_second_feature', '')
        );
        $this->featureLabel = array(
            $this->catLabel[$this->category[0]],
            $this->catLabel[$this->category[1]]
        );

        //시기
        $this->years = array();
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
        }
        return array();
    }

    public function vol()
    {
        if($this->vol) {
            $term = taxonomy_term_load($this->vol);
            return $term->name;
        }
        return 0;
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
    public function getWebzine($category)
    {
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
                    '{{ img }}' => $item->field_image ? image_style_url('main_article', $item->field_image['und'][0]['uri']) : file_create_url('public://default_images/noimage_default.png'),
                    '{{ vol_path }}' => '/vol/'.$this->vol(),
                    '{{ vol }}' => sprintf('%02d', $this->vol()),
                    '{{ category_path }}' => '/category/' . $this->machine_name[$category],
                    '{{ category }}' => $this->catLabel[$category],
                    '{{ node_url }}' => '/node/' . $item->nid,
                    '{{ title }}' => $item->title,
                    '{{ summary }}' => text_summary($item->body['und'][0]['value'], 'plain_text', 100),
                    '{{ writer }}' => $this->writer($item->field_writer['und']),
                    '{{ date }}' => format_date($item->created, 'custom', 'Y.m.d')
                );
            }
            $options['rows'] = $rows;
            return $this->template($options);
        }
        return false;
    }

    private function template($options): string
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

    private function writer($writers): string
    {
        $return = array();
        foreach($writers as $writer) {
            $term = taxonomy_term_load($writer['tid']);
            $return[] = $term->name;
        }
        return implode(', ', $return);
    }

    public function total(): ?int
    {
        $query = new EntityFieldQuery();
        $result = $query->entityCondition('entity_type', 'node')
            ->entityCondition('bundle', 'article')
            ->propertyCondition('status', 1)
            ->fieldCondition('field_vol', 'tid', $this->vol)
            ->execute();
        if(isset($result['node'])) {
            return count($result['node']);
        }
        return 0;
    }
}

class Archive extends Slowalk
{
    protected function query($machine_name, $condition)
    {
        $start = $condition['start'];
        $end = $condition['end'];
        $vid = $this->vid($machine_name);
        $term = db_select('taxonomy_term_data', 't')->fields('t', array('name'))->condition('vid', $vid)->condition('name', $start, '>=');
        if($end) {
            $term->condition('name', $end, '<');
        }
        $result = $term->execute()->fetchCol();
        return $result;
    }

    protected function total($machine_name)
    {
        $vid = $this->vid($machine_name);
        return db_select('taxonomy_term_data', 't')->fields('t', array('name'))->condition('vid', $vid)->execute()->rowCount();
    }

    private function vid($machine_name)
    {
        return db_select('taxonomy_vocabulary', 'v')->fields('v', array('vid'))->condition('machine_name', $machine_name)->execute()->fetchField();
    }

    private function index($machine_name)
    {
        if($machine_name === 'years') {
            $index = $this->yearsQeury();
        } else {
            $index = array(
                $this->query($machine_name, array('start' => '가', 'end' => '아')),
                $this->query($machine_name, array('start' => '아', 'end' => '')),
                $this->query($machine_name, array('start' => 'A', 'end' => 'ㄱ'))
            );
        }

        return array('total' => $this->total($machine_name), 'index' => $index);
    }

    private function yearsQeury()
    {
        $vid = $this->vid('years');
        $parentQ = db_select('taxonomy_term_data', 't');
        $parentQ->leftJoin('taxonomy_term_hierarchy', 'h', 'h.tid = t.tid');
        $parentQ->fields('t', array('tid', 'name'));
        $parents = $parentQ->condition('t.vid', $vid)->condition('h.parent', 0)->execute()->fetchAll();
        $data = array();
        foreach($parents as $parent) {
            $data[$parent->tid]['name'] = $parent->name;
            $tid = $parent->tid;
            $childQ = db_select('taxonomy_term_data', 't');
            $childQ->leftJoin('taxonomy_term_hierarchy', 'h', 'h.tid = t.tid');
            $child = $childQ->fields('t', array('name'))->condition('h.parent', $parent->tid)->execute()->fetchCol();
            $data[$parent->tid]['child'] = $child;
        }
        $this->years = $data;
        return $data;
    }

    public function template($machine_name)
    {
        $data = $this->index($machine_name);
        $html = '<div class="fc_box01"><p class="td01">총 <em>'.$data['total'].'개</em>의 태그가 있습니다.</p></div>';
        if($machine_name === 'years') {
            $html .= '<div class="ng02"><div class="tagA">';
            foreach($data['index'] as $index) {
                $html .= '<a class="btn03" href="/archive/'.$machine_name.'/?search=' . $index['name'] . '">#' . $index['name'] . '</a>';
                foreach($index['child'] as $child) {
                    $html .= '<a class="btn03" href="/archive/'.$machine_name.'/?search=' . $child . '">#' . $child . '</a>';
                }
                $html .= '<br />';
            }
            $html .= '</div></div>';
        } else {
            foreach($data['index'] as $i => $index) {
                if($index) {
                    if($i === 0) {
                        $h3 = 'ㄱ~ㅅ';
                    } elseif($i === 1) {
                        $h3 = 'ㅇ~ㅎ';
                    } else {
                        $h3 = 'A~Z';
                    }
                    $html .= '<div class="ng02"><h3>'.$h3.'</h3><div class="tagA">';
                    foreach($index as $term) {
                        $html .= '<a class="btn03" href="/archive/'.$machine_name.'/?search=' . $term . '">#' . $term . '</a>';
                    }
                    $html .= '</div></div>';
                }
            }
        }
        return $html;
    }

    public function getYears($machine_name)
    {
        $term = taxonomy_get_term_by_name($_GET['search'], $machine_name);
        $tid = key($term);
        $parent = taxonomy_get_parents($tid);
        if(empty($parent)) {$pid = $tid;}
        else {$pid = key($parent);}
        $this->yearsQeury();
        $html = '';
        $html .= '<a class="btn03" href="/archive/years/?search=' . $this->years[$pid]['name'] . '">#' . $this->years[$pid]['name'] . '</a>';
        foreach($this->years[$pid]['child'] as $child) {
            $html .= '<a class="btn03" href="/archive/years/?search=' . $child . '">#' . $child . '</a>';
        }
        return $html;
    }

    public function getMap()
    {
        $term = taxonomy_get_term_by_name($_GET['search'], 'location');
        $term = array_shift($term);
        $view = taxonomy_term_view($term);
        return render($view);
    }
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