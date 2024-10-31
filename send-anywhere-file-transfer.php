<?php
/*
 * Plugin Name: Send Anywhere (File transfer)
 * Plugin URI: https://send-anywhere.com
 * Description: The Simplest way to Send files Anywhere.
 * Version: 1.1.0
 * Author: Estmob Inc.
 * Author URI: https://send-anywhere.com
 */
?>
<?php
class sa_widget extends WP_Widget{
    // constructor
    //function sa_widget(){
    //    parent::WP_Widget(false, $name = __('Send Anywhere', 'sa_widget'));
    //}
    //function __construct($name){
    //    $this->$name = __('Send Anywhere', 'sa_widget');
    //};
    function __construct(){
        $widget_ops = array(' ' => 'Send Anywhere',
             'description'=> 'The Simplest way to Send files Anywhere');
        $this->WP_Widget('sa_widget','Send Anywhere', $widget_ops);
    }

    // widget form creation
    function form($instance){
        //Check values
        if($instance){
            $title = esc_attr($instance['title']);
            $text = esc_attr($instance['text']);
            $select = esc_attr($instance['select']);
            $radio = esc_attr($instance['radio']);
        }else{
            $title = '';
            $text = '';
            $select = '';
            $radio = '';
        }
?>
        <p>
        <label for="<?php echo $this->get_field_id('title'); ?>">
            <?php _e('Widget Title: ', 'sa-widget'); ?>
        </label>
        <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
        <label for="<?php echo $this->get_field_id('text'); ?>">
            <?php _e('Text: ', 'sa-widget'); ?>
        </label>
        <input id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo $text; ?>" />
        </p>
        <p>
        <label for="<?php echo $this->get_field_id('select'); ?>">
            <?php _e('Type: ', 'sa-widget'); ?>
        </label>
        <select name="<?php echo $this->get_field_name('select'); ?>" id="<?php echo $this->get_field_id('select'); ?>">
        <?php
        $options = array('Send&Receive', 'Send', 'Receive');
        foreach ($options as $option) {
           echo '<option value="' . $option . '" id="' . $option . '"', $select == $option ? ' selected="selected"' : '', '>', $option, '</option>';
        }
        ?>
        </select>
       </p>
        <p>
          <input id="<?php echo $this->get_field_id('radio'); ?>" name="<?php echo $this->get_field_name('radio'); ?>" type="radio" value="large" <?php checked( 'large', $radio ); ?> />
          <label for="<?php echo $this->get_field_id('radio'); ?>"><?php _e('Large', 'sa_widget'); ?></label>
          <input id="<?php echo $this->get_field_id('radio'); ?>" name="<?php echo $this->get_field_name('radio'); ?>" type="radio" value="small" <?php checked( 'small', $radio ); ?> />
          <label for="<?php echo $this->get_field_id('radio'); ?>"><?php _e('Small', 'sa_widget'); ?></label>

        </p>
    <?php
    }

    // widget update
    function update($new_instance, $old_instance){
        $instance = $old_instance;
        // Fields
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['text'] = strip_tags($new_instance['text']);
        $instance['select'] = strip_tags($new_instance['select']);
        $instance['radio'] = strip_tags($new_instance['radio']);
        return $instance;
    }

   // widget display
    function widget($args, $instance){
    	 extract($args);
        // these are the widget options
        $title = apply_filters('widget_title', $instance['title']);
        $text = $instance['text'];
        $select = $instance['select'];
        $radio = $instance['radio'];

        echo $before_widget;
        // Display the widget
        echo '<div class="widget-text wp_widget_plugin_box">';

        // Check if title is set
        if($title){
            echo $before_title . $title . $after_title;
        }

        if($text){
            echo '<p class="wp_widget_plugin_text">'.$text.'</p>';
        }

        // Get $select value
        if($select == 'Send&Receive'){
            $type = 'send-receive';
            $size = ($radio == 'small' ? '224*430' : '280*540');
        }else if($select == 'Send'){
            $type = 'send';
            $size = ($radio == 'small' ? '224*240' : '280*300');
        }else if($select == 'Receive'){
            $type = 'receive';
            $size = ($radio == 'small' ? '224*218' : '280*275');
        }
        $size = explode('*', $size);
        echo '<div class="sa-plugin" data-type="'.$type.'" data-width="'.$size[0].'" data-height="'.$size[1].'"></div>';
        echo '</div>';
        echo $after_widget;
    }
}

function add_sa_platform(){
    echo '<script src="' . plugins_url( 'platform.js', __FILE__ ) . '" async defer></script>';
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("sa_widget");'));
add_action('wp_head',add_sa_platform);
?>
