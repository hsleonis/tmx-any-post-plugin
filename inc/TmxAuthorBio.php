<?php
/**
 * @package: ThemeAxe
 * @author: Shahriar
 * @date: 5/13/16
 * ThemeAxe Author Bio widget
 */

namespace Themeaxe;


class TmxAuthor extends \WP_Widget {

    /**
     * TmxAuthorBio constructor.
     */
    function __construct() {
        parent::__construct( 'tmx_author_bio', 'ThemeAxe Author Bio' );
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

        $author_id = $instance['author'];
        self::author($author_id);

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
        $author = ! empty( $instance['author'] ) ? $instance['author'] : __( '', 'themeaxe' );

        //print_r($instance); // Check instance values

        $args = '';

        $author_list = get_users( $args );
        //print_r($author_list);
        ?>
        <p class="tap-title">
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p class="tap-author-name">
            <label for="<?php echo $this->get_field_id( 'author' ); ?>"><?php _e( 'Author:' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'author' ); ?>" name="<?php echo $this->get_field_name( 'author' ); ?>">
                <?php foreach ($author_list as $data): ?>
                    <option value="<?php echo $data->id; ?>" <?php if($data->id==$author) echo "selected"; ?>><?php echo $data->display_name; ?></option>
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
        $fields = array('title','author');

        foreach ($fields as $field)
        $instance[$field] = ( ! empty( $new_instance[$field] ) ) ? strip_tags( $new_instance[$field] ) : '';

        return $instance;
    }

    /**
     * User bio display
     * @param $args Author object
     */
    public function author($args){
        // The Query
        $query = get_user_by('id', $args );
        //print_r($query);
        ?>
        <div class="tmx-author-bio">
            <ul class="tmx-author-bio-list">
                <li>Name: <?php echo $query->data->display_name; ?></li>
                <li>E-mail: <?php echo $query->data->user_email; ?></li>
                <li>Website: <?php echo (isset($query->data->user_url))?"<a href='".$query->data->user_url."'>".$query->data->user_url."</a>":'Not specified'; ?></li>
                <li>Member since: <?php echo human_time_diff( strtotime($query->data->user_registered) ); ?></li>
                <li>Published posts: <?php echo count_user_posts( $args , 'post' ); ?></li>
            </ul>
        </div>
        <?php
    }
}