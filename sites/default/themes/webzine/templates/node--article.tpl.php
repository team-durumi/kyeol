<?php

/**
 * @file
 * Default theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct URL of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type; for example, "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type; for example, story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode; for example, "full", "teaser".
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined; for example, $node->body becomes $body. When needing to
 * access a field's raw values, developers/themers are strongly encouraged to
 * use these variables. Otherwise they will have to explicitly specify the
 * desired field language; for example, $node->body['en'], thus overriding any
 * language negotiation rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 *
 * @ingroup themeable
 */
?>

<?php if($teaser): ?>
    <a href="<?php print $node_url;?>" class="thumb"><span><img src="<?php print image_style_url('article_thumbnail', $content['field_image'][0]['#item']['uri']);?>" alt="<?php print $title;?>"/></span></a>
    <dl class="conA">
        <dt>
            <a href="<?php print $node_url;?>"><?php print $title;?></a>
        </dt>
        <dd>
            <p class="summury"><?php print strip_tags($content['body'][0]['#markup']);?></p>
            <p class="meta">
                <span><?php print get_writers($content['field_writer']);?></span>
                <em><?php print format_date($created, 'custom', 'Y.m.d');?></em>
            </p>
        </dd>
    </dl>
<?php else: ?>
    <!-- cBody -->
    <div class="cBody">
        <!-- postA -->
        <div class="postA"><?php print render($content['body']);?></div>
        <!-- //postA -->
        <!-- attachA -->
        <div class="attachA">
            <?php if(render($content['field_slide'])):?>
                <dl class="ng04 slide">
                    <!--dt>이미지</dt-->
                    <dd>
                        <ul class="slider">
                            <?php foreach($content['field_slide']['#items'] as $slide): ?>
                                <li><img src="<?php print image_style_url('slide', $slide['uri']);?>" alt="<?php print $slide['alt'];?>"></li>
                            <?php endforeach;?>
                        </ul>
                    </dd>
                    <dd>
                        <ul class="slider-nav">
                            <?php foreach($content['field_slide']['#items'] as $slide): ?>
                                <li><img src="<?php print image_style_url('slide_dot', $slide['uri']);?>" alt="<?php print $slide['alt'];?>"></li>
                            <?php endforeach;?>
                        </ul>
                    </dd>
                </dl>
            <?php endif;?>
            <?php if(render($content['field_url'])): ?>
                <dl class="ng04 link">
                    <dt>참고문헌</dt>
                    <dd>
                        <ul>
                            <?php foreach($content['field_url']['#items'] as $link): ?>
                                <li><a href="<?php print $link['url'];?>"><?php print $link['title'];?></a></li>
                            <?php endforeach;?>
                        </ul>
                    </dd>
                </dl>
            <?php endif;?>

            <?php if(render($content['field_file'])): ?>
                <dl class="ng04 file">
                    <dt>도움이 되는 자료</dt>
                    <dd>
                        <ul>
                            <?php foreach($content['field_file']['#items'] as $file): ?>
                                <li><a class="btn03" href="<?php print file_create_url($file['uri']);?>"><i class="xi-paperclip"></i><?php print $file['filename'];?></a></li>
                            <?php endforeach;?>
                        </ul>
                    </dd>
                </dl>
            <?php endif;?>
        </div>
        <!-- //attachA -->
        <!-- aside -->
        <aside>
            <?php if(render($content['field_person'])): ?>
                <dl class="ng05">
                    <dt>관련인물</dt>
                    <dd><?php print get_term_link($content['field_person'], array('class' => 'btn03', 'prefix' => '#'));?></dd>
                </dl>
            <?php endif;?>

            <?php if(render($content['field_area'])): ?>
                <dl class="ng05">
                    <dt>관련지역</dt>
                    <dd><?php print get_term_link($content['field_area'], array('class' => 'btn03', 'prefix' => '#'));?></dd>
                </dl>
            <?php endif;?>

            <?php if(render($content['field_years'])): ?>
                <dl class="ng05">
                    <dt>관련시기</dt>
                    <dd><?php print get_term_link($content['field_years'], array('class' => 'btn03', 'prefix' => '#'));?></dd>
                </dl>
            <?php endif;?>
        </aside>
        <!-- //aside -->
    </div>
    <!-- //cBody -->

    <?php if(render($content['field_tags'])): ?>
        <div class="taglistA">
            <dl class="ng06 inner">
                <dt>Tag</dt>
                <dd><?php print get_term_link($content['field_tags'], array('class' => 'btn03', 'prefix' => '#'));?></dd>
            </dl>
        </div>
    <?php endif;?>

    <?php if(render($content['field_writer'])): ?>
        <div class="writerA">
            <?php foreach($content['field_writer']['#items'] as $writer): ?>
                <dl class="tc02 inner">
                    <dt>
                        <i>글쓴이</i>
                        <b><?php print $writer['taxonomy_term']->name;?></b>
                    </dt>
                    <dd>
                        <p><?php print $writer['taxonomy_term']->description;?></p>
                        <?php if($writer['taxonomy_term']->field_contact): ?>
                            <a href="mailto:<?php print $writer['taxonomy_term']->field_contact['und'][0]['value'];?>"><?php print $writer['taxonomy_term']->field_contact['und'][0]['value'];?></a>
                        <?php endif;?>
                    </dd>
                </dl>
            <?php endforeach;?>
        </div>
    <?php endif;?>

    <?php if(render($content['field_related_article'])): ?>
    <div class="relateA">
        <ul class="lc01 inner">
            <?php $i=1; foreach($content['field_related_article']['#items'] as $article): ?>
                <?php if($article['node']->status !== '1') continue; ?>
                <?php $img = ($article['node']->field_image) ? image_style_url('main_article', $article['node']->field_image['und'][0]['uri']) : file_create_url(drupal_get_path('theme', 'webzine').'/images/no-image-square.png');?>
                <li class="l<?php print $i++;?>">
                    <a href="/node/<?php print $article['node']->nid;?>" class="thumb"><span><img src="<?php print $img;?>" alt="<?php print $article['node']->title;?>"/></span></a>
                    <dl class="conA">
                        <dt>
                            <a href="/node/<?php print $article['node']->nid;?>"><?php print $article['node']->title;?></a>
                        </dt>
                        <dd><?php print text_summary($article['node']->body['und'][0]['value'], 'plain_text', '100');?></dd>
                    </dl>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
    <?php endif;?>
<?php endif;?>