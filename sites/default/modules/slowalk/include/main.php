<?php
/**
 * Created by PhpStorm.
 * User: js
 * Date: 2019-03-06
 * Time: 16:25
 */

function wz_main_callback($form, &$form_state)
{
    global $base_url;
    drupal_add_js(array(
        'Webzine' => array('ajaxUrl' => $base_url . '/ajax/webzine')
    ), 'setting');

    $form['fieldset'] = array(
        '#type' => 'fieldset',
        '#title' => '메인 콘첸츠 선택'
    );

    $vol = taxonomy_vocabulary_machine_name_load('vol');
    $volTerms = taxonomy_get_tree($vol->vid);
    $volOptions = array('_none_' => '- 선택 -');
    krsort($volTerms);
    foreach($volTerms as $term) {
        $volOptions[$term->tid] = $term->name;
    }

    $form['fieldset']['wz_main_vol'] = array(
        '#type' => 'select',
        '#title' => 'Vol.',
        '#options' => $volOptions,
        '#default_value' => variable_get('wz_main_vol', '_none_'),
        '#required' => TRUE
    );

    $form['fieldset']['wz_main_features'] = array(
        '#type' => 'checkboxes',
        '#title' => '기사 분류',
        '#options' => array(
            2 => '좌담',
            3 => '논평',
            4 => '에세이',
            5 => '자료해제',
            6 => '연구자와 지원단체',
            7 => '인터뷰'
        ),
        '#default_value' => variable_get('wz_main_features', array()),
        '#required' => TRUE
    );

    $form['fieldset']['grid'] = array(
        '#type' => 'item',
        '#title' => t('Features'),
        '#markup' => '<div id="first" class="item"></div><div id="second" class="item"></div>'
    );

    $form['fieldset']['hr'] = array(
        '#type' => 'markup',
        '#markup' => '<hr />'
    );

    $form['fieldset']['lists'] = array(
        '#type' => 'item',
        '#title' => t('Articles'),
        '#markup' => '<div id="lists"></div>'
    );

    $form['wz_main_first_feature'] = array(
        '#type' => 'hidden',
        '#default_value' => variable_get('wz_main_first_feature', '')
    );

    $form['wz_main_second_feature'] = array(
        '#type' => 'hidden',
        '#default_value' => variable_get('wz_main_second_feature', '')
    );

    $form['#attached'] = array(
        'js' => array(__SLOWALK__ . '/js/webzine.js' => array('scope' => 'footer', 'type' => 'file')),
        'css' => array(__SLOWALK__ . '/css/webzine.css')
    );

    return system_settings_form($form);
}