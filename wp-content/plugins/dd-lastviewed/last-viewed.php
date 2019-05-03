<?php
/*
Plugin Name: DD Last Viewed
Version: 3.2.4
Plugin URI: http://dijkstradesign.com
Description: Shows the users recently viewed/visited Posts, Pages, Custom Types and even Terms in a widget.
Author: Wouter Dijkstra
Author URI: http://dijkstradesign.com
*/


/*  Copyright 2017  WOUTER DIJKSTRA  (email : info@dijkstradesign.nl)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class lastViewed extends WP_Widget
{
    private  $widget_id;
    private  $before_widget;
    private  $after_widget;
    private  $before_title;
    private  $title;
    private  $after_title;
    private  $post_list;
    private  $post_title_settings;
    private  $post_thumb_settings;
    private  $post_content_settings;
    private  $settings_are_set;

    /**
     * lastViewed constructor.
     */
    function __construct()
    {
        $widget_ops = array(
            'classname' => 'dd_last_viewed',
            'description' => __("A list of the recently viewed posts, pages or custom posttypes.")
        );
        parent::__construct('dd_last_viewed', _x('DD Last Viewed', 'DD Last Viewed widget'), $widget_ops);

        add_action('customize_preview_init', array($this, 'my_preview_js'));
        add_action('wp_enqueue_scripts', array($this, 'dd_lastviewed_add_front'));
        add_action('admin_init', array($this, 'dd_lastviewed_admin'));
        add_action('get_header', array($this, 'add_lastviewed_id'));
        add_shortcode('dd_lastviewed', array($this, 'shortcode_lastviewed'));
        add_shortcode('dd_lastviewed_template', array($this, 'widget_template_shortcode'));
    }

    /**
     * scripts in admins previewmode
     */
    function my_preview_js()
    {
        wp_enqueue_script('dd_js_admin-lastviewed', plugins_url('/js/admin-lastviewed.js', __FILE__), array('jquery'), '');
    }

    /**
     * scripts in front
     */
    function dd_lastviewed_add_front()
    {
        wp_register_style('dd_lastviewed_css', plugins_url('/css/style.css', __FILE__));
        wp_enqueue_style('dd_lastviewed_css');
    }

    /**
     * script in admin
     */
    function dd_lastviewed_admin()
    {
        wp_register_style('dd_lastviewed_admin_styles', plugins_url('/css/admin-style.css', __FILE__));
        wp_enqueue_style('dd_lastviewed_admin_styles');
        wp_enqueue_script('jquery');
        wp_enqueue_script('select-2', plugins_url('/js/select2.min.js', __FILE__), array('jquery'), '');
        wp_enqueue_script('dd_js_admin-lastviewed', plugins_url('/js/admin-lastviewed.js', __FILE__), array(
            'jquery',
            'select-2'
        ), '');
    }

    /**
     * Adds postid to cookie
     */
    function add_lastviewed_id()
    {
        if (is_singular()) {

            global $post;
            $post_id = $post->ID;
            $post_type = get_post_type();
            $lastviewed_widgets = get_option('widget_dd_last_viewed');
            $post_selected_terms = $this->get_all_selected_terms($post_id);
            array_push($post_selected_terms, $post_type);

            foreach ($lastviewed_widgets as $id => $lastviewed_widget) {

                if ($id != '_multiwidget') :

                    $selection = $lastviewed_widget["selection"] ? $lastviewed_widget["selection"] : array();
                    $matching_selection = array_intersect($selection, $post_selected_terms);
                    $exclude_ids = explode(',', $lastviewed_widget["lastviewed_excl_ids"]);
                    $exclude_post = in_array($post_id, $exclude_ids); //true/false

                    if (!empty($matching_selection) && !$exclude_post) {

                        $clc=  $lastviewed_widget["cookie_lifetime_checked"] ? $lastviewed_widget["cookie_lifetime_checked"] : false ;
                        $cl = $lastviewed_widget["cookie_lifetime"] ? $lastviewed_widget["cookie_lifetime"] : 1 ;
                        $ct = $lastviewed_widget["cookie_timeformat"] ? $lastviewed_widget["cookie_timeformat"] : 'days';

                        if ($clc && $ct == 'seconds'):
                            $expire_time = $cl;
                        elseif ($clc && $ct == 'minutes'):
                            $expire_time = $cl * 60;
                        elseif ($clc && $ct == 'hours'):
                            $expire_time = $cl * 60 * 60;
                        elseif ($clc && $ct == 'days'):
                            $expire_time = $cl * 60 * 60 * 24;
                        elseif ($clc && $ct == 'years'):
                            $expire_time = $cl * 60 * 60 * 24 * 365;
                        else:
                            $expire_time = 60 * 60 * 24 * 365;
                        endif;

                        $cookieName = "cookie_data_lastviewed_widget_" . $id;
                        $cookieVal = isset($_COOKIE[$cookieName]) ? $_COOKIE[$cookieName] : '';
                        $oldList = explode(',', $cookieVal);
                        $newList = isset($cookieVal) ? array_diff($oldList, array($post_id)) : array();
                        array_push($newList, $post_id);
                        $newList = implode(",", $newList);
                        setcookie($cookieName, $newList, time() + $expire_time, "/");
                    }
                endif;
            }
        }
    }

    /**
     * @param $atts
     * @return string
     */
    function shortcode_lastviewed($atts)
    {
        $args = array(
            'widget_id' => $atts['widget_id'],
            'by_shortcode' => 'shortcode_',
        );

        ob_start();
        the_widget('lastviewed', '', $args);
        $output = ob_get_clean();

        return $output;
    }

    /**
     * This shortcode Outputs the template
     * file from the templates/folder.
     *
     * @since 3.1.4
     */
    function widget_template_shortcode()
    {
        return $this->get_widget_template('lastviewed-widget.php');
    }
    
    /**
     * Get template.
     *
     * Search for the template and include the file.
     *
     * @since 3.1.4
     *
     * @see locate_widget_template()
     *
     * @param string $template_name Template to load.
     * @param array $args Args passed for the template file.
     * @param string $template_path Path to templates.
     * @param string $default_path Default path to template files.
     */
    function get_widget_template($template_name, $args = array(), $template_path = '', $default_path = '')
    {
        if (is_array($args) && isset($args)) :
            extract($args);
        endif;
        $template_file = $this->locate_widget_template($template_name, $template_path, $default_path);
        if (!file_exists($template_file)) :
            _doing_it_wrong(__FUNCTION__, sprintf('<code>%s</code> does not exist.', $template_file), '1.0.0');
            return;
        endif;
        include $template_file;
    }
    
    /**
     * Locate template.
     *
     * Locate the called template.
     * Search Order:
     * 1. /themes/theme/dd_templates/$template_name
     * 2. /themes/theme/$template_name
     * 3. /plugins/dd_lastviewed/dd_templates/$template_name.
     *
     * @since 3.1.4
     *
     * @param    string $template_name Template to load.
     * @param    string $template_path Path to templates.
     * @param    string $default_path Default path to template files.
     * @return   string                            Path to the template file.
     */
    function locate_widget_template($template_name, $template_path = '', $default_path = '')
    {
        // Set variable to search in dd-lastviewed-templates folder of theme.
        $template_path = $template_path ? $template_path : 'dd_templates/';
        // Set default plugin templates path.
        $default_path = $default_path ? $default_path : plugin_dir_path(__FILE__) . 'dd_templates/'; // Path to the template folder
        // Search template file in theme folder.
        $template = locate_template(array($template_path . $template_name, $template_name));
        // Get plugins template file.
        $template = $template ? $template : $default_path . $template_name;

        return apply_filters('locate_widget_template', $template, $template_name, $template_path, $default_path);
    }

    /**
     * @param $post_id
     * @return array
     */
    function get_all_selected_terms($post_id)
    {
        $selected_terms = array();
        $args = array('hide_empty' => 1, 'fields' => 'ids');
        $taxonomies = get_taxonomies();

        foreach ($taxonomies as $taxonomy) {
            $termID = wp_get_post_terms($post_id, $taxonomy, $args);
            $selected_terms = array_merge($selected_terms, $termID);
        }
        return $selected_terms;
    }

    /**
     * @param $instance
     */
    function form($instance)
    {
        include('dd_templates/form.php');
    }

    /**
     * @param $new_instance
     * @param $old_instance
     * @return mixed
     */
    function update($new_instance, $old_instance)
    {
        // processes widget options to be saved
        $instance = $old_instance;
        $instance['lastviewedTitle'] = strip_tags($new_instance['lastviewedTitle']);
        $instance['selected_posttypes'] = $new_instance['selected_posttypes'];
        $instance['selection'] = $new_instance['selection'];

        $instance['lastViewed_thumb'] = strip_tags($new_instance['lastViewed_thumb']);
        $instance['lastViewed_total'] = strip_tags($new_instance['lastViewed_total']);
        $instance['lastViewed_truncate'] = strip_tags($new_instance['lastViewed_truncate']);
        $instance['lastViewed_linkname'] = strip_tags($new_instance['lastViewed_linkname']);
        $instance['lastViewed_showPostTitle'] = (bool)$new_instance['lastViewed_showPostTitle'];
        $instance['lastViewed_showThumb'] = (bool)$new_instance['lastViewed_showThumb'];
        $instance['lastViewed_thumbSize'] = strip_tags($new_instance['lastViewed_thumbSize']);
        $instance['lastViewed_showExcerpt'] = (bool)$new_instance['lastViewed_showExcerpt'];
        $instance['lastViewed_content_type'] = strip_tags($new_instance['lastViewed_content_type']);
        $instance['lastViewed_showTruncate'] = (bool)$new_instance['lastViewed_showTruncate'];
        $instance['lastViewed_showMore'] = (bool)$new_instance['lastViewed_showMore'];
        $instance['lastViewed_lv_link_thumb'] = (bool)$new_instance['lastViewed_lv_link_thumb'];
        $instance['lastViewed_lv_link_title'] = (bool)$new_instance['lastViewed_lv_link_title'];
        $instance['lastViewed_lv_link_excerpt'] = (bool)$new_instance['lastViewed_lv_link_excerpt'];
        $instance['lastviewed_excl_ids'] = strip_tags($new_instance['lastviewed_excl_ids']);

        $instance['cookie_lifetime_checked'] = (bool)$new_instance['cookie_lifetime_checked'];

        if ($instance['cookie_lifetime_checked']) {
            $instance['cookie_lifetime'] = strip_tags(isset($new_instance['cookie_lifetime']) ? $new_instance['cookie_lifetime'] : 1);
            $instance['cookie_timeformat'] = strip_tags($new_instance['cookie_timeformat']);
        }
        else {
            $instance['cookie_lifetime'] = 365;
            $instance['cookie_timeformat'] = 'days';

        }

        return $instance;
    }

    /**
     * @param $post_type
     * @param array $selected_post_types
     * @return bool
     */
    function is_posttype_checked($post_type, $selected_post_types = array())
    {
        $selected_post_types = array_values($selected_post_types);

        return in_array($post_type, $selected_post_types);
    }

    /**
     * @param $id
     * @return mixed
     */
    function contentfilter($id)
    {
        $content_type = $this->post_content_settings['type'];
        $truncate_active = $this->post_content_settings['truncate_active'];
        $truncate_size = $this->post_content_settings['truncate_size'];
        $regex = '/\[dd_lastviewed(.*?)\]/'; //avoid shortcode '[lastviewed] in order to prevent a loop
        $strip_content = $content_type == 'plain content'; // 1/0

        $content = get_post_field('post_content', $id);

        $content = preg_replace($regex, '', $content);
        $content = apply_filters('the_content', $content);
        $content = $strip_content ? strip_shortcodes($content) : $content;
        $content = $strip_content ? wp_strip_all_tags($content, true) : $content;
        $content = $content_type === 'excerpt' ? get_the_excerpt($id) : $content;
        $content = $truncate_active ? substr($content, 0, strrpos(substr($content, 0, $truncate_size), ' ')) : $content;

        return $content;
    }

    /**
     * @param $args
     * @param $instance
     */
    function widget($args, $instance)
    {
        extract($args, EXTR_SKIP);
        $widgetID = str_replace('dd_last_viewed-', '', $args['widget_id']);

        $widgetOptions = get_option($this->option_name);
        $thisWidget = $widgetOptions[$widgetID];
        $show_max = $thisWidget['lastViewed_total'] ? $thisWidget['lastViewed_total'] : -1;

        $cookie_name = 'cookie_data_lastviewed_widget_' . $widgetID;
        $lastlist = isset($_COOKIE[$cookie_name]) ? $_COOKIE[$cookie_name] : '';
        $idList = explode(",", $lastlist);
        $idList = array_reverse($idList);
        $idList = is_singular() ? array_diff($idList, array(get_the_ID())) : $idList; // strip this id from idlist if on single
        $list_args = array(
            'post__in' => $idList,
            'post_type' => 'any',
            'post_status' => 'publish',
            'orderby' => 'post__in',
            'posts_per_page' => $show_max
        );

        $post_title_settings = array(
            "is_active" => $thisWidget['lastViewed_showPostTitle'],
            "is_link" => $thisWidget['lastViewed_lv_link_title']
        );

        $post_thumb_settings = array(
            'is_active' => $thisWidget['lastViewed_showThumb'],
            'is_link' => $thisWidget['lastViewed_lv_link_thumb'],
            'size' => $thisWidget['lastViewed_thumbSize']
        );

        $post_content_settings = array (
            'is_active' => $thisWidget['lastViewed_showExcerpt'],
            'is_link' => $thisWidget['lastViewed_lv_link_excerpt'],
            'type' => $thisWidget['lastViewed_content_type'],
            'truncate_active' => $thisWidget['lastViewed_showTruncate'],
            'truncate_size' => $thisWidget['lastViewed_truncate'] ? $thisWidget['lastViewed_truncate'] : false,
            'more_active' => $thisWidget['lastViewed_showMore'],
            'more_title' => $thisWidget['lastViewed_linkname']
        );

        $settings_set = $post_title_settings['is_active'] || $post_thumb_settings['is_active'] || $post_content_settings['is_active'];

        $this->widget_id = $widgetID;
        $this->before_widget = $before_widget;
        $this->after_widget = $after_widget;
        $this->before_title = $before_title;
        $this->title = $thisWidget['lastviewedTitle'];
        $this->after_title = $after_title;
        $this->post_list = new WP_Query($list_args);
        $this->post_title_settings = $post_title_settings;
        $this->post_thumb_settings = $post_thumb_settings;
        $this->post_content_settings = $post_content_settings;
        $this->settings_are_set = $settings_set;

        echo do_shortcode('[dd_lastviewed_template]');
        
        wp_reset_query();
    }
}

add_action('widgets_init', create_function('', 'return register_widget("lastviewed");'));