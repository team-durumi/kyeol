<?php
/**
 * Created by PhpStorm.
 * User: js
 * Date: 2019-03-05
 * Time: 13:37
 */

function webzine_ajax_callback()
{
    if(isset($_POST['type'])) {
        $type = $_POST['type'];
        $return = array();
        $catLabel = array(
            2 => '좌담',
            3 => '논평',
            4 => '에세이',
            5 => '자료해제',
            6 => '연구자와 지원단체',
            7 => '인터뷰'
        );
        switch ($type) {
            case 'features':
                $vol = $_POST['vol'];
                $category = $_POST['category'];
                $query = new EntityFieldQuery();
                $result = $query->entityCondition('entity_type', 'node')
                    ->entityCondition('bundle', 'article')
                    ->propertyCondition('status', 1)
                    ->fieldCondition('field_vol', 'tid', $vol)
                    ->fieldCondition('field_category', 'tid', $category)
                    ->propertyOrderBy('created', 'DESC')
                    ->range(0,1)
                    ->execute();
                if($result['node']) {
                    $nid = key($result['node']);
                    $node = node_load($nid);
                    $body = field_view_field('node', $node, 'body', 'teaser');
                    $return = array(
                        'nid' => $nid,
                        'url' => '/node/'.$nid,
                        'title' => $node->title,
                        'img' => ($node->field_image) ? image_style_url('main_feature', $node->field_image['und'][0]['uri']) : file_create_url(drupal_get_path('theme', 'webzine').'/images/no-image-square.png'),
                        'body' => strip_tags(render($body))
                    );
                }
                break;
            case 'articles':
                $vol = $_POST['vol'];
                $nid = $_POST['nid'];
                $query = new EntityFieldQuery();
                $result = $query->entityCondition('entity_type', 'node')
                    ->entityCondition('bundle', 'article')
                    ->propertyCondition('status', 1)
                    ->propertyCondition('promote', 1)
                    ->propertyCondition('nid', $nid, 'NOT IN')
                    ->fieldCondition('field_vol', 'tid', $vol)
//                    ->fieldOrderBy('field_category', 'tid', 'ASC')
                    ->propertyOrderBy('changed', 'DESC')
                    ->range(0,6)
                    ->execute();
                if($result['node']) {
                    $nids = array_keys($result['node']);
                    $nodes = entity_load('node', $nids);
                    foreach($nodes as $node) {
                        $nid = $node->nid;
                        $category = render(field_view_field('node', $node, 'field_category', ['label' => 'hidden']));
                        $img_uri = ($node->field_image) ? image_style_url('main_article', $node->field_image['und'][0]['uri']) : file_create_url(drupal_get_path('theme', 'webzine').'/images/no-image-square.png');
                        $body = strip_tags(render(field_view_field('node', $node, 'body', 'teaser')));
                        $writer = render(field_view_field('node', $node, 'field_writer', ['label' => 'hidden']));
                        $return[] = array(
                            'nid' => $nid,
                            'url' => '/node/'.$nid,
                            'title' => $node->title,
                            'category' => $category,
                            'img' => $img_uri,
                            'body' => $body,
                            'writer' => $writer,
                        );
                    }
                }
                break;
            case 'search':
                if(isset($_POST['key'])) {
                    $key = $_POST['key'];
                    $keyword = _slowalk_search('search', 'page', $key);
                    $term = _slowalk_search('search_term', 'page', $key);
                    $return = array('keyword' => $keyword, 'term' => $term);
                }
                break;
            case 'person':
                $archive = new Archive();
                $return = $archive->getPerson();
                break;
          case 'term':
            $href = $_POST['href'];
            $explode = explode('/', $href);
            $tid = $explode[2];
            $term = taxonomy_term_load($tid);
            $return = $term;
            break;
        }
        drupal_json_output($return);
    } else {
        drupal_json_output(array('error' => '정상적인 접근이 아닙니다.'));
    }
}
