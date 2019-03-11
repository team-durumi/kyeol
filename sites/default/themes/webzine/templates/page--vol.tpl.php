<?php

/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 */
?>

<div id="main_wrap" class="mainPage">
    <?php include_once 'header.php';?>

    <!-- 서브 컨텐츠 영역 -->
    <div class="<?php print $main_class;?>" id="main-content">
        <div class="inner">
            <nav></nav>
            <!-- 사이드바 영역 -->
            <?php if ($page['sidebar_first']): ?>
                <aside>
                    <div id="sidebar-first" class="column sidebar">
                        <div class="section">
                            <?php print render($page['sidebar_first']); ?>
                        </div>
                    </div>
                </aside>
            <?php endif; ?>
            <!-- //사이드바 영역 -->
            <section>
                <div class="header">
                    <?php print render($title_prefix); ?>
                    <?php if ($title): ?><h1 class="title" id="page-title"><?php print $title; ?></h1><?php endif; ?>
                    <?php print render($title_suffix); ?>
                </div>
                <div class="cBody">
                    <?php print $messages;?>
                    <?php if ($tabs): ?><div class="tabs"><?php print render($tabs); ?></div><?php endif; ?>
                    <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
                    <div class="fc_box01 fc_box01_01">
                        <p class="td01 leftF"><i>2</i>호에 대한 기사가 총 <em>15건</em> 있습니다.</p>
                        <a class="btn01 rightF" href="#">호수 목록 보기</a>
                    </div>
                    <div class="fc_box02">
                        <h2>연구자의 말</h2>
                        <ul class="lc02 lc02_01">
                            <li>
                                <a href="#" class="thumb"><span><img src="/<?php print __WZ__;?>/images/@lc01.png" alt=""/></span></a>
                                <dl class="conA">
                                    <dt>
										<span class="category">
											<a class="btn02 version" href="#">03호</a>
											<a class="btn02 mention" href="#">연구자의 말</a>
										</span>
                                        <a href="#">탈분단적 시각으로 바라보는 위안부 문제 - 첫번째 시간 탈분단적 시각으로 바라보는 위안부 문제 - 첫번째 시간</a>
                                    </dt>
                                    <dd>
                                        <p class="summury">이는 이상 우리 수 그와 칼이다. 만물은 전인 품고 사랑의 싶이 긴지라 못하다 있으랴? 천자만홍이 남는 사는가 가치를 같은 대고, 유소년에게서 운다.이는 이상 우리 수 그와 칼이다. 만물은 전인 품고 사랑의 싶이 긴지라 못하다 있으랴? 천자만홍이 남는 사는가 가치를 같은 대고, 유소년에게서 운다. 이는 이상 우리 수 그와 칼이다. 이는 이상 우리 수 그와 칼이다.</p>
                                        <p class="meta">
                                            <span>김지홍, 이선희</span>
                                            <em>2019. 03. 01</em>
                                        </p>
                                    </dd>
                                </dl>
                            </li>
                        </ul>
                    </div>
                    <div class="fc_box02">
                        <h2>자료해제</h2>
                        <ul class="lc02 lc02_01">
                            <li>
                                <a href="#" class="thumb"><span><img src="/<?php print __WZ__;?>/images/@lc01.png" alt=""/></span></a>
                                <dl class="conA">
                                    <dt>
										<span class="category">
											<a class="btn02 version" href="#">03호</a>
											<a class="btn02 mention" href="#">연구자의 말</a>
										</span>
                                        <a href="#">탈분단적 시각으로 바라보는 위안부 문제 - 첫번째 시간 탈분단적 시각으로 바라보는 위안부 문제 - 첫번째 시간</a>
                                    </dt>
                                    <dd>
                                        <p class="summury">이는 이상 우리 수 그와 칼이다. 만물은 전인 품고 사랑의 싶이 긴지라 못하다 있으랴? 천자만홍이 남는 사는가 가치를 같은 대고, 유소년에게서 운다.이는 이상 우리 수 그와 칼이다. 만물은 전인 품고 사랑의 싶이 긴지라 못하다 있으랴? 천자만홍이 남는 사는가 가치를 같은 대고, 유소년에게서 운다. 이는 이상 우리 수 그와 칼이다. 이는 이상 우리 수 그와 칼이다.</p>
                                        <p class="meta">
                                            <span>김지홍, 이선희</span>
                                            <em>2019. 03. 01</em>
                                        </p>
                                    </dd>
                                </dl>
                            </li>
                        </ul>
                    </div>
                    <div class="fc_box02">
                        <h2>연구자와 지원단체</h2>
                        <ul class="lc02 lc02_01">
                            <li>
                                <a href="#" class="thumb"><span><img src="/<?php print __WZ__;?>/images/@lc01.png" alt=""/></span></a>
                                <dl class="conA">
                                    <dt>
										<span class="category">
											<a class="btn02 version" href="#">03호</a>
											<a class="btn02 mention" href="#">연구자의 말</a>
										</span>
                                        <a href="#">탈분단적 시각으로 바라보는 위안부 문제 - 첫번째 시간 탈분단적 시각으로 바라보는 위안부 문제 - 첫번째 시간</a>
                                    </dt>
                                    <dd>
                                        <p class="summury">이는 이상 우리 수 그와 칼이다. 만물은 전인 품고 사랑의 싶이 긴지라 못하다 있으랴? 천자만홍이 남는 사는가 가치를 같은 대고, 유소년에게서 운다.이는 이상 우리 수 그와 칼이다. 만물은 전인 품고 사랑의 싶이 긴지라 못하다 있으랴? 천자만홍이 남는 사는가 가치를 같은 대고, 유소년에게서 운다. 이는 이상 우리 수 그와 칼이다. 이는 이상 우리 수 그와 칼이다.</p>
                                        <p class="meta">
                                            <span>김지홍, 이선희</span>
                                            <em>2019. 03. 01</em>
                                        </p>
                                    </dd>
                                </dl>
                            </li>
                        </ul>
                    </div>
                    <div class="fc_box02">
                        <h2>논평</h2>
                        <ul class="lc02 lc02_01">
                            <li>
                                <a href="#" class="thumb"><span><img src="/<?php print __WZ__;?>/images/@lc01.png" alt=""/></span></a>
                                <dl class="conA">
                                    <dt>
										<span class="category">
											<a class="btn02 version" href="#">03호</a>
											<a class="btn02 mention" href="#">연구자의 말</a>
										</span>
                                        <a href="#">탈분단적 시각으로 바라보는 위안부 문제 - 첫번째 시간 탈분단적 시각으로 바라보는 위안부 문제 - 첫번째 시간</a>
                                    </dt>
                                    <dd>
                                        <p class="summury">이는 이상 우리 수 그와 칼이다. 만물은 전인 품고 사랑의 싶이 긴지라 못하다 있으랴? 천자만홍이 남는 사는가 가치를 같은 대고, 유소년에게서 운다.이는 이상 우리 수 그와 칼이다. 만물은 전인 품고 사랑의 싶이 긴지라 못하다 있으랴? 천자만홍이 남는 사는가 가치를 같은 대고, 유소년에게서 운다. 이는 이상 우리 수 그와 칼이다. 이는 이상 우리 수 그와 칼이다.</p>
                                        <p class="meta">
                                            <span>김지홍, 이선희</span>
                                            <em>2019. 03. 01</em>
                                        </p>
                                    </dd>
                                </dl>
                            </li>
                        </ul>
                    </div>
                    <div class="fc_box02">
                        <h2>에세이</h2>
                        <ul class="lc02 lc02_01">
                            <li>
                                <a href="#" class="thumb"><span><img src="/<?php print __WZ__;?>/images/@lc01.png" alt=""/></span></a>
                                <dl class="conA">
                                    <dt>
										<span class="category">
											<a class="btn02 version" href="#">03호</a>
											<a class="btn02 mention" href="#">연구자의 말</a>
										</span>
                                        <a href="#">탈분단적 시각으로 바라보는 위안부 문제 - 첫번째 시간 탈분단적 시각으로 바라보는 위안부 문제 - 첫번째 시간</a>
                                    </dt>
                                    <dd>
                                        <p class="summury">이는 이상 우리 수 그와 칼이다. 만물은 전인 품고 사랑의 싶이 긴지라 못하다 있으랴? 천자만홍이 남는 사는가 가치를 같은 대고, 유소년에게서 운다.이는 이상 우리 수 그와 칼이다. 만물은 전인 품고 사랑의 싶이 긴지라 못하다 있으랴? 천자만홍이 남는 사는가 가치를 같은 대고, 유소년에게서 운다. 이는 이상 우리 수 그와 칼이다. 이는 이상 우리 수 그와 칼이다.</p>
                                        <p class="meta">
                                            <span>김지홍, 이선희</span>
                                            <em>2019. 03. 01</em>
                                        </p>
                                    </dd>
                                </dl>
                            </li>
                        </ul>
                    </div>
                    <div class="fc_box02">
                        <h2>인터뷰</h2>
                        <ul class="lc02 lc02_01">
                            <li>
                                <a href="#" class="thumb"><span><img src="/<?php print __WZ__;?>/images/@lc01.png" alt=""/></span></a>
                                <dl class="conA">
                                    <dt>
										<span class="category">
											<a class="btn02 version" href="#">03호</a>
											<a class="btn02 mention" href="#">연구자의 말</a>
										</span>
                                        <a href="#">탈분단적 시각으로 바라보는 위안부 문제 - 첫번째 시간 탈분단적 시각으로 바라보는 위안부 문제 - 첫번째 시간</a>
                                    </dt>
                                    <dd>
                                        <p class="summury">이는 이상 우리 수 그와 칼이다. 만물은 전인 품고 사랑의 싶이 긴지라 못하다 있으랴? 천자만홍이 남는 사는가 가치를 같은 대고, 유소년에게서 운다.이는 이상 우리 수 그와 칼이다. 만물은 전인 품고 사랑의 싶이 긴지라 못하다 있으랴? 천자만홍이 남는 사는가 가치를 같은 대고, 유소년에게서 운다. 이는 이상 우리 수 그와 칼이다. 이는 이상 우리 수 그와 칼이다.</p>
                                        <p class="meta">
                                            <span>김지홍, 이선희</span>
                                            <em>2019. 03. 01</em>
                                        </p>
                                    </dd>
                                </dl>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- //서브 컨텐츠 영역 -->
    <footer>
        <div class="inner">
            <?php print render($page['footer']);?>
        </div>
    </footer>
</div>
<!-- //main_wrap -->