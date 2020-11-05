<?php
if (!class_exists('Ample_Magazine_Advertisement_Widget')) {
    class Ample_Magazine_Advertisement_Widget extends WP_Widget
    {
        private function defaults()
        {
            $defaults = array(
                'title' => '',
                'ad_img' => '',
                'ad_link' => '',
            );
            return $defaults;
        }

        public function __construct()
        {
            parent::__construct(
                'ample-magazine-advertisement-widget',
                esc_html__('AT: Advertisement Widget', 'ample-magazine'),
                array('description' => esc_html__(' Top Header Advertisement Widget', 'ample-magazine'))
            );
        }

        public function form($instance)
        {
            $instance = wp_parse_args((array )$instance, $this->defaults());
            $title = esc_attr($instance['title']);
            $ad_link = esc_url($instance['ad_link']);
            $ad_img = esc_url($instance['ad_img']);
            ?>

            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <?php esc_html_e('Title', 'ample-magazine'); ?>
                </label><br/>
                <input type="text" name="<?php echo esc_attr($this->get_field_name('title')); ?>" class="widefat"
                       id="<?php echo esc_attr($this->get_field_id('title')); ?>" value="<?php echo esc_attr($title); ?>">
            </p>

            <p>
                <label for="<?php echo esc_attr($this->get_field_id('ad_link')); ?>">
                    <?php esc_html_e('Advertisement Link', 'ample-magazine'); ?>
                </label><br/>
                <input type="text" name="<?php echo esc_attr($this->get_field_name('ad_link')); ?>"
                       class="widefat" id="<?php echo esc_attr($this->get_field_id('ad_link')); ?>"
                       value="<?php echo esc_attr($ad_link); ?>">
            </p>

            <p>
                <label for="<?php echo esc_attr($this->get_field_id('ad_img')); ?>">
                    <?php _e('Select Advertisement Image', 'ample-magazine'); ?>:
                </label>
                <span class="img-preview-wrap" <?php if (empty($ad_img)) { ?> style="display:none;" <?php } ?>>
                    <img class="widefat" src="<?php echo esc_url($ad_img); ?>"
                         alt="<?php esc_attr_e('Image preview', 'ample-magazine'); ?>"/>
                </span><!-- .img-preview-wrap -->
                <input type="text" class="widefat" name="<?php echo esc_attr($this->get_field_name('ad_img')); ?>"
                       id="<?php echo esc_attr($this->get_field_id('ad_img')); ?>"
                       value="<?php echo esc_url($ad_img); ?>"/>
                <input type="button" id="custom_media_button"
                       value="<?php esc_attr_e('Upload Image', 'ample-magazine'); ?>" class="button media-image-upload"
                       data-title="<?php esc_attr_e('Select Advertisement Image', 'ample-magazine'); ?>"
                       data-button="<?php esc_attr_e('Select Advertisement Image', 'ample-magazine'); ?>"/>
                <input type="button" id="remove_media_button"
                       value="<?php esc_attr_e('Remove Image', 'ample-magazine'); ?>"
                       class="button media-image-remove"/>
            </p>

            <hr>
            <?php
        }

        public function update($new_instance, $old_instance)
        {
            $instance = $old_instance;
            $instance['title'] = sanitize_text_field($new_instance['title']);
            $instance['ad_link'] = esc_url_raw($new_instance['ad_link']);
            $instance['ad_img'] = esc_url_raw($new_instance['ad_img']);

            return $instance;
        }

        public function widget($args, $instance)
        {

            if (!empty($instance)) {
                $instance = wp_parse_args((array )$instance, $this->defaults());
                $title = apply_filters('widget_title', !empty($instance['title']) ? esc_html($instance['title']) : '', $instance, $this->id_base);
                $ad_img = esc_url($instance['ad_img']);
                $ad_link = esc_url($instance['ad_link']);

                echo $args['before_widget']; ?>


                <div class="ads-profile">

                    <?php

                    if ($title) {
                        echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
                    } ?>

                    <div class="profile-wrapper ads-section">

                            <figure class="ads">
                                <a href="<?php echo esc_url( $ad_link);?>" target="_blank"><img src="<?php echo esc_url ($ad_img); ?>">
                                </a>
                            </figure>

                    </div>
                    <!-- .profile-wrapper -->

                </div><!-- .ads-profile -->



                <?php

                echo $args['after_widget'];

            }
        }
    }
}
add_action('widgets_init', 'ample_magazine_Advertisement_widget');
function ample_magazine_advertisement_widget()
{
    register_widget('Ample_Magazine_Advertisement_Widget');

}
