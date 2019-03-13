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
            2 => '연구자의 말',
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
                        'img' => ($node->field_image) ? image_style_url('main_feature', $node->field_image['und'][0]['uri']) : file_create_url('public://default_images/no-image.png'),
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
                    ->propertyCondition('nid', $nid, 'NOT IN')
                    ->fieldCondition('field_vol', 'tid', $vol)
                    ->fieldOrderBy('field_category', 'tid', 'ASC')
                    ->propertyOrderBy('created', 'DESC')
                    ->execute();
                if($result['node']) {
                    $nids = array_keys($result['node']);
                    $nodes = entity_load('node', $nids);
                    foreach($nodes as $node) {
                        $tid = $node->field_category['und'][0]['tid'];
                        $nid = $node->nid;
                        $img_uri = ($node->field_image) ? image_style_url('main_article', $node->field_image['und'][0]['uri']) : file_create_url('public://default_images/no-image.png');
                        $body = field_view_field('node', $node, 'body', 'teaser');
                        $return[] = array(
                            'nid' => $nid,
                            'url' => '/node/'.$nid,
                            'title' => $node->title,
                            'category' => $catLabel[$tid],
                            'img' => $img_uri,
                            'body' => strip_tags(render($body))
                        );
                    }
                }
                break;
            case 'search':
                if(isset($_POST['key'])) {
                    $key = $_POST['key'];
                    if(strpos($key, ' ') !== false) {
                        $keyArr = explode(' ', $key);
                        $keyCount = count($keyArr);
                        $query = "SELECT COUNT(*) AS expression FROM (SELECT t.item_id AS item_id, SUM(t.score) AS score, 1 AS expression FROM (SELECT t.item_id AS item_id, t.word AS word, SUM(score) AS score FROM search_api_db_default_node_index_text t WHERE (word IN (";
                        for($i=0;$i<$keyCount;$i++) {
                            if($i !== 0) $query .= ", ";
                            $query .= "'".$keyArr[$i]."'";
                        }
                        $query .= ")) AND (field_name IN ('body:summary', 'body:value', 'title')) GROUP BY t.item_id, t.word) t LEFT OUTER JOIN search_api_db_default_node_index t_2 ON t.item_id = t_2.item_id WHERE (( (t_2.status = '1') )) GROUP BY t.item_id HAVING (COUNT(DISTINCT t.word) >= '$keyCount') ) subquery";
                        $keyword = db_query($query)->fetchField();
//                        $query = search_api_query('default_node_index');
//                        $query->condition('type', 'article', '=');
//                        $query->condition('status', 1, '=');
//                        $filter = $query->createFilter('OR');
//                        $filter->condition('title', $keyArr, 'IN');
//                        $filter->condition('body:value', $keyArr, 'IN');
//                        $filter->condition('body:summary', array($kye), 'IN');
//                        $query->filter($filter);
//                        $data = $query->execute();
//                        $keyword = $data['result count'];
                    } else {
                        $keyword = db_query("SELECT COUNT(*) AS expression FROM (SELECT 1 AS expression FROM search_api_db_default_node_index_text t WHERE (word IN ('$key')) AND (field_name IN ('body:summary', 'body:value', 'title')) GROUP BY t.item_id) subquery")->fetchField();
                    }
                    $term = db_query("SELECT COUNT(*) AS expression FROM (SELECT 1 AS expression FROM search_api_db_default_node_index_text t WHERE (word IN ('$key')) AND (field_name IN ('field_area:name', 'field_category:name', 'field_person:description', 'field_person:field_lifetime', 'field_person:name', 'field_tags:name', 'field_vol:name', 'field_writer:description', 'field_writer:field_contact', 'field_writer:field_position', 'field_writer:name', 'field_years:name')) GROUP BY t.item_id) subquery")->fetchField();
                    $return = array('keyword' => $keyword, 'term' => $term);
                }
                break;
        }
        drupal_json_output($return);
    } else {
        drupal_json_output(array('error' => '정상적인 접근이 아닙니다.'));
    }
}