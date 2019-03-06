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
                    $return = array(
                        'nid' => $nid,
                        'url' => '/node/'.$nid,
                        'title' => $node->title,
                        'img' => image_style_url('medium', $node->field_image['und'][0]['uri']),
                        'body' => text_summary($node->body['und'][0]['value'], 'plain_text', 100)
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
                        $return[] = array(
                            'nid' => $nid,
                            'url' => '/node/'.$nid,
                            'title' => $node->title,
                            'category' => $catLabel[$tid],
                            'img' => image_style_url('medium', $node->field_image['und'][0]['uri']),
                            'body' => text_summary($node->body['und'][0]['value'], 'plain_text', 100)
                        );
                    }
                }
                break;
        }
        drupal_json_output($return);
    }

}