<?php
/**
 * Created by PhpStorm.
 * User: js
 * Date: 2019-03-11
 * Time: 11:59
 */

$action = '/search';
if(current_path() === 'search/term') {
    $action = '/search/term';
}
?>
<header>
    <div class="inner">
        <div class="lg01">
            <a href="<?php print $front_page;?>"><?php print $site_name;?></a>
            <em><b><?php print $vol;?></b><i>.vol</i></em>
        </div>
        <ul class="ng01">
            <li class="search"><a href="#" title="검색창 열기"><i class="xi-search"></i></a></li>
            <li class="menu"><a href="#" title="메뉴 열기"><i class="xi-bars"></i></a></li>
        </ul>
        <nav>
            <a href="#" class="btn_icon01" title="메뉴 닫기"><i class="xi-close"></i></a>
            <?php print theme('links__system_main_menu', array('links' => $main_menu, 'attributes' => array('id' => 'main-menu', 'class' => array('links', 'inline', 'clearfix')), 'heading' => t('Main menu'))); ?>
            <?php print theme('links__system_secondary_menu', array('links' => $secondary_menu, 'attributes' => array('id' => 'secondary-menu', 'class' => array('links', 'inline', 'clearfix')), 'heading' => t('Secondary menu'))); ?>
        </nav>
        <form class="cf01" method="get" action="<?php print $action;?>">
            <a href="#" class="btn_icon01" title="검색창 닫기"><i class="xi-close"></i></a>
            <fieldset>
                <label for="search_query">검색어</label>
                <input type="text" name="key" id="search_query" placeholder="검색어를 입력해 주세요" value="<?php print ($_GET['key']) ?? '';?>"/>
                <button><i class="xi-search"></i></button>
            </fieldset>
        </form>
    </div>
    <?php print render($page['header']); ?>
</header>
