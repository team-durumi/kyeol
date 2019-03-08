<?php
/**
 * Created by PhpStorm.
 * User: js
 * Date: 2019-03-07
 * Time: 12:08
 */

/**
 * hook_js_alter().
 * @param $javascript
 */
function webzine_js_alter(&$javascript)
{
    $javascript['misc/jquery.js']['version'] = '3.3.1';
    $javascript['misc/jquery.js']['data'] = 'https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js';
}

function webzine_preprocess_page(&$variables)
{
    //호수 템플릿 설정
    if(isset($variables['page']['content']['system_main']['term_heading']['term']['#bundle'])) {
        $variables['theme_hook_suggestions'][] = 'page__' . $variables['page']['content']['system_main']['term_heading']['term']['#bundle'];
    }
}