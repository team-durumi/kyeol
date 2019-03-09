<?php
/**
 * Created by PhpStorm.
 * User: js
 * Date: 2019-03-09
 * Time: 10:38
 */
?>

<div id="main_wrap" class="mainPage">
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
            <form class="cf01" method="post">
                <a href="#" class="btn_icon01" title="검색창 닫기"><i class="xi-close"></i></a>
                <fieldset>
                    <label for="search_query">검색어</label>
                    <input type="text" name="search_query" id="search_query" placeholder="검색어를 입력해 주세요"/>
                    <button><i class="xi-search"></i></button>
                </fieldset>
            </form>
        </div>
    </header>
    <!-- 메인 컨텐츠 영역 -->
    <div class="fc01" id="main-content">
        <?php print render($page['content']); ?>
    </div>
    <!-- //메인 컨텐츠 영역 -->
    <footer>
        <div class="inner">
            <?php print render($page['footer']);?>
        </div>
    </footer>
</div>
<!-- //main_wrap -->
