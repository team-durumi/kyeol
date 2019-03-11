<?php
/**
 * Created by PhpStorm.
 * User: js
 * Date: 2019-03-09
 * Time: 10:38
 */
?>

<div id="main_wrap" class="mainPage">
    <?php include_once 'header.php';?>
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
