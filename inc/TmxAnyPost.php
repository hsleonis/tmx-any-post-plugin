<?php
/**
 * @package: ThemeAxe
 * @author: Shahriar
 * @date: 5/13/16
 * ThemeAxe Any Post Widget
 */

namespace Themeaxe;


class TmxAnyPost extends \WP_Widget {

    /**
     * TmxAnyPost constructor.
     */
    function __construct() {
        parent::__construct( 'tmx_any_post', 'ThemeAxe Any Post' );
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
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }

        $args = array(
            'post_type'         => array( $instance['post'] ),
            'posts_per_page'    => $instance['count'],
            'order'             => $instance['order'],
            'orderby'           => $instance['orderby'],
            'thumbnail'         => (bool) $instance['thumbnail']
        );
        self::anyposts($args);

        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( '', 'themeaxe' );
        $post = ! empty( $instance['post'] ) ? $instance['post'] : __( 'post', 'themeaxe' );
        $count = ! empty( $instance['count'] ) ? $instance['count'] : __( '5', 'themeaxe' );
        $order = ! empty( $instance['order'] ) ? $instance['order'] : __( 'DESC', 'themeaxe' );
        $orderby = ! empty( $instance['orderby'] ) ? $instance['orderby'] : __( 'date', 'themeaxe' );
        $thumbnail = (bool) $instance['thumbnail'];

        //print_r($instance); // Check instance values

        $args = array(
            'public'   => true
        );
        $output = "names";
        $operator = "and";
        $post_types = get_post_types( $args, $output, $operator );
        //unset($post_types['attachment']); // Remove 'attachment' from list

        $orderby_list = array(
            'none' => 'None',
            'rand' => 'Random',
            'id' => 'ID',
            'title' => 'Title',
            'name' => 'Slug',
            'date' => 'Date (Default)',
            'modified' => 'Modified date',
            'parent' => 'Parent ID',
            'menu_order' => 'Menu Order',
            'comment_count' => 'Comment Count'
        );
        ?>
        <p class="tap-title">
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p class="tap-post">
            <label for="<?php echo $this->get_field_id( 'post' ); ?>"><?php _e( 'Select post type:' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'post' ); ?>" name="<?php echo $this->get_field_name( 'post' ); ?>">
                <?php foreach ($post_types as $item=>$val): ?>
                <option value="<?php echo $val; ?>" <?php if($val==$post) echo "selected"; ?>><?php echo $item; ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p class="tap-count">
            <label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" min="-1" max="100" type="number" value="<?php echo esc_attr( $count ); ?>">
        </p>
        <p class="tap-thumbnail">
            <label for="<?php echo $this->get_field_id( 'thumbnail' ); ?>"><?php _e( 'Show thumbnails:' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'thumbnail' ); ?>" name="<?php echo $this->get_field_name( 'thumbnail' ); ?>" type="checkbox" value="<?php print_r($thumbnail); ?>" <?php checked($thumbnail); ?>>
        </p>
        <p class="tap-order">
            <label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Order:' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>">
                <option value="ASC" <?php if('ASC'==$order) echo "selected"; ?>>ASC</option>
                <option value="DESC" <?php if('DESC'==$order) echo "selected"; ?>>DESC</option>
            </select>
        </p>
        <p class="tap-orderby">
            <label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Order by:' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
                <?php foreach ($orderby_list as $key=>$val): ?>
                    <option value="<?php echo $key; ?>" <?php if($key==$orderby) echo "selected"; ?>><?php echo $val; ?></option>
                <?php endforeach; ?>
            </select>
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
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $fields = array('title','post','count','order','orderby');

        foreach ($fields as $field)
        $instance[$field] = ( ! empty( $new_instance[$field] ) ) ? strip_tags( $new_instance[$field] ) : '';
        $instance['thumbnail'] = isset($new_instance['thumbnail'])?1:0;

        return $instance;
    }

    /**
     * Post type loop
     * @param $args WP_query objecct
     */
    public function anyposts($args){
        // The Query
        $query = new \WP_Query( $args );

        // The Loop
        if ( $query->have_posts() ) {
            ?>
            <ul class="tmx-any-post-list">
        <?php
            while ( $query->have_posts() ) {
                $query->the_post();
                ?>
                <li>
                    <a href='<?php the_permalink(); ?>'>
                        <?php if($args['thumbnail']) the_post_thumbnail(); ?>
                        <?php the_title(); ?>
                    </a>
                <?php
            }
        ?>
            </ul>
        <?php
        } else {
            echo "No posts found";
        }

        // Restore original Post Data
        wp_reset_postdata();
    }
}