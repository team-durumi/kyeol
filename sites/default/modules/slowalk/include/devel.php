<?php
/**
 * Created by PhpStorm.
 * User: js
 * Date: 2019-03-06
 * Time: 16:35
 */

function wz_devel()
{
    $main = new Main();                 //메인페이지
    $slide = $main->slide();            //슬라이드
    $features = $main->features();      //메인 Features
    $articles = $main->articles();      //메인 기사들
    dpm('메인페이지');
    dpm($main);
    dpm('슬라이드');
    dpm($slide);
    dpm('Features');
    dpm($features);
    dpm('Articles');
    dpm($articles);
    return '';
}