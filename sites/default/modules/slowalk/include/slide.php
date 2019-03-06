<?php
/**
 * Created by PhpStorm.
 * User: js
 * Date: 2019-03-06
 * Time: 16:25
 */

function wz_slide_callback($form, &$form_state)
{
    $form['wz_slide_count'] = array(
        '#type' => 'select',
        '#title' => '슬라이드 개수 설정',
        '#options' => drupal_map_assoc(array(1,2,3,4,5)),
        '#default_value' => variable_get('wz_slide_count', 5),
        '#required' => TRUE,
    );

    for($i=1; $i<=5; $i++) {
        $form['fieldset-'.$i.'-slide'] = array(
            '#type' => 'fieldset',
            '#title' => '슬라이드 #'.$i,
        );

        $form['fieldset-'.$i.'-slide']['slide_'.$i.'_title'] = array(
            '#type' => 'textfield',
            '#title' => '제목',
            '#default_value' => variable_get('slide_'.$i.'_title', ''),
        );

        $form['fieldset-'.$i.'-slide']['slide_'.$i.'_body'] = array(
            '#type' => 'textarea',
            '#title' => '내용',
            '#default_value' => variable_get('slide_'.$i.'_body', ''),
        );

        $form['fieldset-'.$i.'-slide']['slide_'.$i.'_image'] = array(
            '#type' => 'managed_file',
            '#title' => '이미지',
            '#default_value' => variable_get('slide_'.$i.'_image', ''),
        );

        $form['fieldset-'.$i.'-slide']['slide_'.$i.'_link'] = array(
            '#type' => 'textfield',
            '#title' => '링크',
            '#default_value' => variable_get('slide_'.$i.'_link', ''),
        );

        $form['fieldset-'.$i.'-slide']['slide_'.$i.'_blank'] = array(
            '#type' => 'checkbox',
            '#title' => '새창열기',
            '#default_value' => variable_get('slide_'.$i.'_blank', '')
        );
    }

    $form['#attached']['js'] = array(__SLOWALK__ . '/js/slide.js' => array('scope' => 'footer', 'type' => 'file'));

    return system_settings_form($form);
}

function wz_slide_callback_validate($form, &$form_state)
{
    $start = $form_state['values']['wz_slide_count'] + 1;

    for($i = 1; $i < $start; $i++) {
        $file = file_load($form_state['values']['slide_'.$i.'_image']);
        $ref = file_usage_list($file);
        dpm($ref);
        if(empty($ref)) {
            dpm('empty');
            file_usage_add($file, 'slowalk', 'mainslide', $i);
        }
    }

    for($i = $start; $i <= 5; $i++) {
        $form_state['values']['slide_'.$i.'_title'] = '';
        $form_state['values']['slide_'.$i.'_body'] = '';
        if($form_state['values']['slide_'.$i.'_image']) {
            $file = file_load($form_state['values']['slide_'.$i.'_image']);
            file_usage_delete($file, 'slowalk', 'mainslide', $i);
            file_delete($file);
        }
        $form_state['values']['slide_'.$i.'_image'] = 0;
        $form_state['values']['slide_'.$i.'_link'] = '';
        $form_state['values']['slide_'.$i.'_blank'] = 0;
    }
}