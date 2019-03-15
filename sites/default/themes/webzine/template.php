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
    $main = new Slowalk();

    $variables['main_class'] = 'fc02';
    if(empty($variables['page']['sidebar_first'])) {
        $variables['main_class'] = 'fc03';
        if(strpos(request_uri(), 'vol') !== false) {
            $variables['title'] = '지난호 보기';
            $variables['theme_hook_suggestions'][] = 'page__vol';
        } elseif (arg(0) === 'taxonomy') {
            drupal_add_css('#page-title:before{content:"#"}', 'inline');
        }
        if(isset($variables['node'])) {
            if($variables['node']->type === 'article') {
                $main->vol = $variables['node']->field_vol['und'][0]['tid'];
                $variables['main_class'] = 'fc04';
                $cat_tid = $variables['node']->field_category['und'][0]['tid'];
                $variables['category'] = $main->catLabel[$cat_tid];
                $wid = $variables['node']->field_writer['und'][0]['tid'];
                $writer = taxonomy_term_load($wid);
                $variables['writer'] = $writer->name;
                $variables['writer_info'] = ($writer->field_position) ? strip_tags($writer->field_position['und'][0]['value']) : '';
                $image = ($variables['node']->field_image) ? image_style_url('article', $variables['node']->field_image['und'][0]['uri']) : '';
                $variables['image'] = ($image) ? ' style="background-image:url('.$image.')"' : '';
                $variables['vol_path'] = '/vol/' . $main->vol();
                $variables['category_path'] = '/category/' . $main->machine_name[$cat_tid];
                $variables['url'] = $main->baseUrl . request_uri();
            }
        }
    }
    drupal_add_js(array('Webzine' => array('vol' => $main->baseUrl.'/vol/'.$main->vol())), 'setting');
    drupal_add_js('https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', array('type' => 'external', 'scope' => 'header', 'group' => JS_LIBRARY));
    drupal_add_js('https://cdn.jsdelivr.net/npm/jquery-validation@1.19.0/dist/jquery.validate.min.js', array('type' => 'external', 'scope' => 'header', 'group' => JS_LIBRARY ));
    drupal_add_js('https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js', array('type' => 'external', 'scope' => 'header', 'group' => JS_THEME ));
    drupal_add_js(drupal_get_path('module', 'ckeditor') . '/plugins/cavacnote/jquery/jquery.cavacnote.js', array('type' => 'file', 'scope' => 'header', 'group' => JS_LIBRARY));
    drupal_add_js(drupal_get_path('theme', 'webzine') . '/js/jquery.dialogOptions.js', array('type' => 'file', 'scope' => 'header', 'group' => JS_THEME));
    drupal_add_css('https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css', array('type' => 'external', 'group' => CSS_THEME));
    drupal_add_css('https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css', array('type' => 'external', 'group' => CSS_THEME));
    drupal_add_css('http://cdn.jsdelivr.net/npm/xeicon@2.3.3/xeicon.min.css', array('type' => 'external', 'group' => CSS_THEME));
    drupal_add_css('https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css', array('type' => 'external', 'group' => CSS_THEME));
    drupal_add_css(drupal_get_path('module', 'ckeditor') . '/plugins/cavacnote/css/cavacnote.css', array('type' => 'file', 'group' => CSS_THEME));

    //호수 노출
    $variables['vol'] = sprintf('%02d', $main->vol());
}

/**
 * @param $field_writer
 * @return string
 */
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

/**
 * @param $term
 * @param array $options
 */
function get_term_link($term, $options = array())
{
    if(isset($term['#items'])) {
        $html[] = '';
        $classes = '';
        if($options) {
            $classes = $options['class'] ?? '';
        }
        $first = true;
        foreach($term['#items'] as $item) {
            $name = isset($options['type']) ? sprintf($options['type'], $item['taxonomy_term']->name) : $item['taxonomy_term']->name;
            if(!$first && strpos($name, '년대') !== false) {
                $html[] = '<br /><br />';
            }
            if(isset($options['prefix'])) {
                $name = $options['prefix'] . $name;
            }
            if(isset($options['suffix'])) {
                $name .= $options['suffix'];
            }
            if(isset($options['voca'])) {
                $html[] = '<a class="'.$classes.'" href="/archive/'.$options['voca'].'?search='.$name.'">'.$name.'</a>';
            } else {
                $html[] = '<a class="'.$classes.'" href="/'.drupal_get_path_alias('taxonomy/term/'.$item['tid']).'">'.$name.'</a>';
            }
            $first = false;
        }
        return implode('', $html);
    }
}

/**
 * @return mixed
 */
function countWriters()
{
    $cnt = db_query("select distinct(field_writer_tid) from field_data_field_writer")->rowCount();
    return $cnt;
}

/**
 * hook_breadcrumb()
 * @param $variables
 * @return string
 */
function webzine_breadcrumb($variables) {
    $breadcrumb = $variables['breadcrumb'];
    if (!empty($breadcrumb)) {
        $breadcrumb = str_replace('Taxonomy term', '태그', $breadcrumb);
        $breadcrumb = str_replace('Search', '키워드 검색', $breadcrumb);
        // Provide a navigational heading to give context for breadcrumb links to
        // screen-reader users. Make the heading invisible with .element-invisible.
        $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';
        $output .= '<div class="breadcrumb">' . implode(' ', $breadcrumb) . '</div>';
        return $output;
    }
}