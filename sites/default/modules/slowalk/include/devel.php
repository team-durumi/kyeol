<?php
/**
 * Created by PhpStorm.
 * User: js
 * Date: 2019-03-06
 * Time: 16:35
 */

function wz_devel()
{
    $archive = new Archive();
    $person = $archive->template('years');
    dpm($person);
    return '';
}