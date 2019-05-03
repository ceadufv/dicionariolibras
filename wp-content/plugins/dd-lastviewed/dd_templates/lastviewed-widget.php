<?php

$before_widget      = $this->before_widget;
$after_widget       = $this->after_widget;
$before_title       = $this->before_title;
$title              = $this->title;
$after_title        = $this->after_title;

$post_list          = $this->post_list;

$title_is_active    = $this->post_title_settings['is_active'];
$title_is_link      = $this->post_title_settings['is_link'];

$thumb_is_active    = $this->post_thumb_settings['is_active'];
$thumb_is_link      = $this->post_thumb_settings['is_link'];
$thumb_size         = $this->post_thumb_settings['size'];

$content_is_active  = $this->post_content_settings['is_active'];
$content_is_link    = $this->post_content_settings['is_link'];
$content_type       = $this->post_content_settings['type'];
$more_active        = $this->post_content_settings['more_active'];
$more_title         = $this->post_content_settings['more_title'];

$settings_are_set   = $this->settings_are_set;

if ($post_list->have_posts()) :

    echo $before_widget;

    if ($title) : echo $before_title . $title . $after_title; endif;

    if ($settings_are_set): ?>
        <ul class="lastViewedList">
            <?php while ($post_list->have_posts()) : $post_list->the_post();

                $id = get_the_ID();
                $title = get_the_title();
                $content = $this->contentfilter($id);

                $thumb = get_the_post_thumbnail($id, $thumb_size);
                $hasThumb = $thumb_is_active && has_post_thumbnail() ? $thumb_is_active : false;
                $perma = get_permalink();
                $class = $hasThumb ? "lastViewedItem clearfix" : "lastViewedItem";

                ?>
                <li class="<?php echo $class; ?>">
                    <?php if ($hasThumb && !$thumb_is_link): ?>
                        <div class="lastViewedThumb"><?php echo $thumb; ?></div>
                    <?php elseif ($hasThumb && $thumb_is_link) : ?>
                        <a class="lastViewedThumb" href="<?php echo $perma; ?>"><?php echo $thumb; ?></a>
                    <?php endif; ?>

                    <div class="lastViewedcontent">
                        <?php if ($title_is_active && $title_is_link) : ?>
                            <a class="lastViewedTitle" href="<?php echo $perma; ?>"><?php echo $title; ?></a>
                        <?php elseif ($title_is_active && !$title_is_link) : ?>
                            <h3 class="lastViewedTitle"><?php echo $title; ?></h3>
                        <?php endif; ?>

                        <?php if ($content_is_link && $content_is_active) : ?>
                            <a href="<?php echo $perma; ?>" class="lastViewedExcerpt">
                                <div>
                                    <?php echo $content; ?>
                                    <?php if ($more_active) : ?>
                                        <span class="more"><?php echo $more_title; ?></span>
                                    <?php endif; ?>
                                </div>
                            </a>
                        <?php elseif (!$content_is_link && $content_is_active) : ?>
                            <div class='lastViewedExcerpt'>
                                <?php echo $content; ?>
                                <?php if ($more_active) : ?>
                                    <a href="<?php echo $perma; ?>" class="more"><?php echo $more_title; ?></a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else : ?>
        <p>No options set yet! Set the options in the <a href="<?php echo esc_url(home_url('/wp-admin/widgets.php')); ?>">widget</a>.</p>
    <?php endif; ?>
    <?php echo $after_widget; ?>
<?php endif; ?>