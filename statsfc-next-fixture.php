<?php
/*
Plugin Name: StatsFC Next Fixture
Plugin URI: https://statsfc.com/next-fixture
Description: StatsFC Next Fixture
Version: 3.0.1
Author: Will Woodward
Author URI: https://willjw.co.uk
License: GPL2
*/

/*  Copyright 2020  Will Woodward  (email : will@willjw.co.uk)

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

define('STATSFC_NEXTFIXTURE_ID',      'StatsFC_NextFixture');
define('STATSFC_NEXTFIXTURE_NAME',    'StatsFC Next Fixture');
define('STATSFC_NEXTFIXTURE_VERSION', '3.0.1');


/**
 * Adds StatsFC widget.
 */
class StatsFC_NextFixture extends WP_Widget
{
    public $isShortcode = false;

    protected static $count = 0;

    private static $defaults = array(
        'title'       => '',
        'key'         => '',
        'team'        => '',
        'competition' => '',
        'date'        => '',
        'timezone'    => 'Europe/London',
        'default_css' => true,
        'omit_errors' => false,
    );

    private static $whitelist = array(
        'team',
        'competition',
        'date',
        'timezone',
        'omitErrors',
        'lang',
    );

    /**
     * Register widget with WordPress.
     */
    public function __construct()
    {
        parent::__construct(STATSFC_NEXTFIXTURE_ID, STATSFC_NEXTFIXTURE_NAME, array('description' => 'StatsFC Next Fixture'));
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance)
    {
        $instance    = wp_parse_args((array) $instance, self::$defaults);
        $title       = strip_tags($instance['title']);
        $key         = strip_tags($instance['key']);
        $team        = strip_tags($instance['team']);
        $competition = strip_tags($instance['competition']);
        $date        = strip_tags($instance['date']);
        $timezone    = strip_tags($instance['timezone']);
        $default_css = strip_tags($instance['default_css']);
        $omit_errors = strip_tags($instance['omit_errors']);
        ?>
        <p>
            <label>
                <?php _e('Title', STATSFC_NEXTFIXTURE_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Key', STATSFC_NEXTFIXTURE_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('key'); ?>" type="text" value="<?php echo esc_attr($key); ?>">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Team', STATSFC_NEXTFIXTURE_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('team'); ?>" type="text" value="<?php echo esc_attr($team); ?>">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Competition', STATSFC_NEXTFIXTURE_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('competition'); ?>" type="text" value="<?php echo esc_attr($competition); ?>">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Date (YYYY-MM-DD)', STATSFC_NEXTFIXTURE_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('date'); ?>" type="text" value="<?php echo esc_attr($date); ?>" placeholder="YYYY-MM-DD">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Timezone', STATSFC_NEXTFIXTURE_ID); ?>
                <select class="widefat" name="<?php echo $this->get_field_name('timezone'); ?>">
                    <?php
                    $zones = timezone_identifiers_list();

                    foreach ($zones as $zone) {
                        echo '<option value="' . esc_attr($zone) . '"' . ($zone == $timezone ? ' selected' : '') . '>' . esc_attr($zone) . '</option>' . PHP_EOL;
                    }
                    ?>
                </select>
            </label>
        </p>
        <p>
            <label>
                <?php _e('Use default styles?', STATSFC_NEXTFIXTURE_ID); ?>
                <input type="checkbox" name="<?php echo $this->get_field_name('default_css'); ?>"<?php echo ($default_css == 'on' ? ' checked' : ''); ?>>
            </label>
        </p>
        <p>
            <label>
                <?php _e('Omit error messages?', STATSFC_NEXTFIXTURE_ID); ?>
                <input type="checkbox" name="<?php echo $this->get_field_name('omit_errors'); ?>"<?php echo ($omit_errors == 'on' ? ' checked' : ''); ?>>
            </label>
        </p>
    <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance)
    {
        $instance                = $old_instance;
        $instance['title']       = strip_tags($new_instance['title']);
        $instance['key']         = strip_tags($new_instance['key']);
        $instance['team']        = strip_tags($new_instance['team']);
        $instance['competition'] = strip_tags($new_instance['competition']);
        $instance['date']        = strip_tags($new_instance['date']);
        $instance['timezone']    = strip_tags($new_instance['timezone']);
        $instance['default_css'] = strip_tags($new_instance['default_css']);
        $instance['omit_errors'] = strip_tags($new_instance['omit_errors']);

        return $instance;
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {
        extract($args);

        $title       = apply_filters('widget_title', (array_key_exists('title', $instance) ? $instance['title'] : ''));
        $unique_id   = ++static::$count;
        $key         = (array_key_exists('key', $instance) ? $instance['key'] : '');
        $referer     = (array_key_exists('HTTP_HOST', $_SERVER) ? $_SERVER['HTTP_HOST'] : '');
        $default_css = (array_key_exists('default_css', $instance) && filter_var($instance['default_css'], FILTER_VALIDATE_BOOLEAN));

        $options = array(
            'team'        => (array_key_exists('team', $instance) ? $instance['team'] : ''),
            'competition' => (array_key_exists('competition', $instance) ? $instance['competition'] : ''),
            'date'        => (array_key_exists('date', $instance) ? $instance['date'] : ''),
            'timezone'    => (array_key_exists('timezone', $instance) ? $instance['timezone'] : ''),
            'omitErrors'  => (array_key_exists('omit_errors', $instance) && filter_var($instance['omit_errors'], FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false'),
            'lang'        => substr(get_bloginfo('language'), 0, 2),
        );

        $html = '';

        if (isset($before_widget)) {
            $html .= $before_widget;
        }

        if (isset($before_title)) {
            $html .= $before_title;
        }

        $html .= $title;

        if (isset($after_title)) {
            $html .= $after_title;
        }

        $html .= '<div id="statsfc-next-fixture-' . $unique_id . '"></div>' . PHP_EOL;

        if (isset($after_widget)) {
            $html .= $after_widget;
        }

        // Enqueue CSS
        if ($default_css) {
            wp_enqueue_style(STATSFC_NEXTFIXTURE_ID, plugins_url('next-fixture.css', __FILE__), null, STATSFC_NEXTFIXTURE_VERSION);
        }

        // Enqueue base JS
        wp_enqueue_script(STATSFC_NEXTFIXTURE_ID, plugins_url('next-fixture.js', __FILE__), array('jquery'), STATSFC_NEXTFIXTURE_VERSION, true);

        // Enqueue widget JS
        $object = 'statsfc_next_fixture_' . $unique_id;

        $script  = '<script>' . PHP_EOL;
        $script .= 'var ' . $object . ' = new StatsFC_NextFixture(' . json_encode($key) . ');' . PHP_EOL;
        $script .= $object . '.referer = ' . json_encode($referer) . ';' . PHP_EOL;

        foreach (static::$whitelist as $parameter) {
            if (! array_key_exists($parameter, $options)) {
                continue;
            }

            $script .= $object . '.' . $parameter . ' = ' . json_encode($options[$parameter]) . ';' . PHP_EOL;
        }

        $script .= $object . '.display("statsfc-next-fixture-' . $unique_id . '");' . PHP_EOL;
        $script .= '</script>';

        add_action('wp_print_footer_scripts', function () use ($script) {
            echo $script;
        });

        if ($this->isShortcode) {
            return $html;
        } else {
            echo $html;
        }
    }

    public static function shortcode($atts)
    {
        $args = shortcode_atts(self::$defaults, $atts);

        $widget              = new self;
        $widget->isShortcode = true;

        return $widget->widget(array(), $args);
    }
}

// Register StatsFC widget
add_action('widgets_init', function () {
    register_widget(STATSFC_NEXTFIXTURE_ID);
});

add_shortcode('statsfc-next-fixture', STATSFC_NEXTFIXTURE_ID . '::shortcode');
