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
                <a href="/">일본군'위안부'문제연구소-웹진-결</a>
                <em><b>02</b><i>.vol</i></em>
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
        <!-- 뉴스레터 -->
        <div class="fc01_03">
            <div class="inner">
                <h2 class="th02">일본군'위안부'문제연구소의 <br/>새로운 소식을 받아보세요</h2>
                <form class="cf02" method="post">
                    <fieldset>
                        <label for="letter_email">이메일</label>
                        <input type="email" name="letter_email" id="letter_email" placeholder="이메일을 입력하세요"/>
                        <button>뉴스레터 신청하기</button>
                    </fieldset>
                </form>

            </div>
        </div>
        <!-- //뉴스레터 -->
    </div>
    <!-- //메인 컨텐츠 영역 -->
    <footer>
        <div class="inner">
            <p class="cpr">Copyright 2019 일본군위안부문제연구소웹진. All Rights Reserved.</p>
        </div>
    </footer>
</div>
<!-- //main_wrap -->
