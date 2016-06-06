<?php
/**
 * @package: ThemeAxe
 * @author: Shahriar
 * @date: 5/13/16
 * ThemeAxe Author Bio widget
 */

namespace Themeaxe;

/**
 * Adds TmxTabs widget.
 */
class TmxTabs extends \WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'TmxTabs',
            'ThemeAxe Tabs',
            array(
                'description'	=> __( 'Display a tabbed content widget for your popular posts, recent posts and popular tags.', 'tmx' )
            )
        );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        $fields = array(
            // Other fields
            'tabs_post_count' => array (
                'tmx_widgets_name'				=> 'tabs_post_count',
                'tmx_widgets_title'			=> __( 'Posts to Show', 'tmx' ),
                'tmx_widgets_field_type'		=> 'text'
            ),
            'tabs_tag_count' => array (
                'tmx_widgets_name'				=> 'tabs_tag_count',
                'tmx_widgets_title'			=> __( 'Tags to Show', 'tmx' ),
                'tmx_widgets_field_type'		=> 'text'
            ),
        );

        return $fields;
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );

        $tabs_post_count	= $instance['tabs_post_count'];
        $tabs_tag_count		= $instance['tabs_tag_count'];

        echo $before_widget;
        ?>

        <ul id="widget-tab" class="clearfix widget-tab-nav">
            <li class="active"><a href="#widget-tab-popular"><?php _e( 'Popular', 'tmx' ); ?></a></li>
            <li><a href="#widget-tab-latest"><?php _e('Latest', 'tmx' ); ?></a></li>
            <li><a href="#widget-tab-tags"><?php _e( 'Tags', 'tmx' ); ?></a></li>
        </ul>

        <div class="widget-tab-content">
            <div class="tab-pane active" id="widget-tab-popular">
                <ul>
                    <?php $popular = new \WP_Query('orderby=comment_count&ignore_sticky_posts=1&posts_per_page=' . $tabs_post_count );
                    while ($popular->have_posts()) : $popular->the_post(); ?>
                        <li class="clearfix">
                            <?php if ( has_post_thumbnail() ) { ?>
                                <div class="widget-entry-thumbnail">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'thumb-small', array( 'title' => get_the_title() ) ); ?></a>
                                </div>
                                <div class="widget-entry-summary">
                                    <h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h4>
                                    <span><?php comments_number( __( 'No Comments', 'tmx' ), __( '1 Comment', 'tmx' ), __( '% Comments', 'tmx' ) ); ?></span>
                                </div>
                            <?php } else { ?>
                                <div class="widget-entry-content">
                                    <h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h4>
                                    <span><?php comments_number( __( 'No Comments', 'tmx' ), __( '1 Comment', 'tmx' ), __( '% Comments', 'tmx' ) ); ?></span>
                                </div>
                            <?php } ?>
                        </li>
                    <?php endwhile; wp_reset_postdata(); ?>
                </ul>
                <!-- #widget-tab-popular --></div>

            <div class="tab-pane" id="widget-tab-latest">
                <ul>
                    <?php $latest = new \WP_Query('orderby=post_date&order=DESC&ignore_sticky_posts=1&posts_per_page=' . $tabs_post_count );
                    while ( $latest -> have_posts() ) : $latest -> the_post(); ?>
                        <li class="clearfix">
                            <?php if ( has_post_thumbnail() ) { ?>
                                <div class="widget-entry-thumbnail">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'thumb-small', array( 'title' => get_the_title() ) ); ?></a>
                                </div>
                                <div class="widget-entry-summary">
                                    <h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h4>
                                    <span><?php the_time('F d, Y'); ?></span>
                                </div>
                            <?php } else { ?>
                                <div class="widget-entry-content">
                                    <h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h4>
                                    <span><?php the_time('F d, Y'); ?></span>
                                </div>
                            <?php } ?>
                        </li>
                    <?php endwhile; wp_reset_postdata(); ?>
                </ul>
                <!-- #widget-tab-latest --></div>

            <div class="tab-pane" id="widget-tab-tags">
                <?php wp_tag_cloud('smallest=1&largest=1.6&unit=em&orderby=count&order=DESC&number=' . $tabs_tag_count ); ?>
                <!-- #widget-tab-tags --></div>
        </div>

        <?php
        echo $after_widget;
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param	array	$new_instance	Values just sent to be saved.
     * @param	array	$old_instance	Previously saved values from database.
     *
     * @uses	tmx_widgets_show_widget_field()		defined in widget-fields.php
     *
     * @return	array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach( $widget_fields as $widget_field ) {
            extract( $widget_field );

            $instance[$widget_field] = ( ! empty( $new_instance[$widget_field] ) ) ? strip_tags( $new_instance[$widget_field] ) : '';
        }

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     *
     * @uses	tmx_widgets_show_widget_field()		defined in widget-fields.php
     */
    public function form( $instance ) {
        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach( $widget_fields as $widget_field ) {

            // Make array elements available as variables
            extract( $widget_field );
            $tmx_widgets_field_value = isset( $instance[$tmx_widgets_name] ) ? esc_attr( $instance[$tmx_widgets_name] ) : '';
            tmx_widgets_show_widget_field( $this, $widget_field, $tmx_widgets_field_value );

        }
    }

}