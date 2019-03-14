<?php
/**
 * Created by PhpStorm.
 * User: js
 * Date: 2019-03-06
 * Time: 16:35
 */

function wz_devel()
{
    $search = views_get_view('search_term');
    $search->set_display('page');
    $filter = $search->get_item('page', 'filter', 'search_api_views_fulltext');
    $filter['value'] = "'진원'이 용인";
    $search->set_item('page', 'filter', 'search_api_views_fulltext', $filter);
    $search->pre_execute();
    $search->execute();
    $total = $search->total_rows;
    dpm($total);
    return '';
}