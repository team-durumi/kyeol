<?php
/**
 * Created by PhpStorm.
 * User: js
 * Date: 2019-03-07
 * Time: 12:08
 */

define('__WZ__', drupal_get_path('theme', 'webzine'));

/**
 * hook_js_alter().
 * @param $javascript
 */
function webzine_js_alter(&$javascript)
{
    $javascript['misc/jquery.js']['version'] = '3.3.1';
    $javascript['misc/jquery.js']['data'] = 'https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js';
}


/**
 * hook_css_alter().
 * @param $css
 */
function webzine_css_alter(&$css)
{
    unset($css['modules/system/system.menus.css']);
    unset($css['modules/system/system.theme.css']);
}

/**
 * hook_preprocess_page().
 * @param $variables
 */
function webzine_preprocess_page(&$variables)
{
    //호수 템플릿 설정
    if(isset($variables['page']['content']['system_main']['term_heading']['term']['#bundle'])) {
        $variables['theme_hook_suggestions'][] = 'page__' . $variables['page']['content']['system_main']['term_heading']['term']['#bundle'];
    }

    drupal_add_library('system', 'ui.slider');
    drupal_add_js('https://cdn.jsdelivr.net/npm/jquery-validation@1.19.0/dist/jquery.validate.min.js', array('type' => 'external', 'scope' => 'header', 'group' => JS_LIBRARY ));
    drupal_add_js('https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js', array('type' => 'external', 'scope' => 'header', 'group' => JS_THEME ));
    drupal_add_css('https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css', array('type' => 'external', 'group' => CSS_THEME));
    drupal_add_css('https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css', array('type' => 'external', 'group' => CSS_THEME));

    drupal_add_css('http://cdn.jsdelivr.net/npm/xeicon@2.3.3/xeicon.min.css', array('type' => 'external', 'group' => CSS_THEME));

    //호수 노출
    $main = new Slowalk();
    $variables['vol'] = sprintf('%02d', $main->vol());
}

function get_writers($field_writer)
{
    if(isset($field_writer['#items'])) {
        $writers = array();
        foreach($field_writer['#items'] as $item) {
            $writers[] = $item['taxonomy_term']->name;
        }
        return implode(', ', $writers);
    }
}