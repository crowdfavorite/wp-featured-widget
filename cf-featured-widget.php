<?php
/**
 * Plugin Name: CF Featured Widget
 * Plugin URI:
 * Description: A widget that displays a title, description, image and links to specified URL. Intended to be styled as desired to match your theme.
 * Author: Crowd Favorite
 * Author URI: http://crowdfavorite.com
 * Version: 0.1
 */

function register_cf_featured_widget() {
	register_widget( 'CF_Featured_Widget' );
}
add_action( 'widgets_init', 'register_cf_featured_widget' );

class CF_Featured_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {

		load_plugin_textdomain( 'cf-featured-widget', false, basename( dirname( __FILE__ ) ) . '/languages' );

		parent::__construct(
			'featured-widget',
			'Featured Widget',
			array( 'description' => __( 'A callout with title, description, image path and link.', 'cf-featured-widget' ), )
		);
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
		$title = apply_filters( 'widget_title', $instance['title'] );
		$description = wpautop( $instance['description'] );
		$image_path = $instance['image_path'];
		$link_url = $instance['link_url'];

		echo $args['before_widget'];

		if ( !empty($title) && !empty($link_url) ) {
			echo $args['before_title'] . '<a href="">' . $title . '</a>' . $args['after_title'];
		} else if ( !empty($title) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		if ( !empty($image_path) && !empty($link_url) ) {
			echo '<a href="' . $link_url . '"' . '><img src="' . $image_path . '"></a>';
		} else if ( !empty($image_path) ) {
			echo '<img src="' . $image_path . '">';
		}

		if ( !empty( $description ) ) {
			echo $description;
		}

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

		// Set defaults
		if( !isset($instance['title']) ) { $instance['title'] = ''; }
		if( !isset($instance['description']) ) { $instance['description'] = ''; }
		if( !isset($instance['image_path']) ) { $instance['image_path'] = ''; }
		if( !isset($instance['link_url']) ) { $instance['link_url'] = ''; }

		$title = $instance[ 'title' ];
		$description = $instance[ 'description' ];
		$image_path = $instance[ 'image_path' ];
		$link_url = $instance[ 'link_url' ];
		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'description' ); ?>"><?php _e( 'Description:' ); ?></label>
			<textarea class="widefat" rows="8" cols="20" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>"><?php echo esc_attr( $description ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'image_path' ); ?>"><?php _e( 'Image Path:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'image_path' ); ?>" name="<?php echo $this->get_field_name( 'image_path' ); ?>" type="text" value="<?php echo esc_attr( $image_path ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'link_url' ); ?>"><?php _e( 'Link:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'link_url' ); ?>" name="<?php echo $this->get_field_name( 'link_url' ); ?>" type="text" value="<?php echo esc_attr( $link_url ); ?>" />
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
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['description'] = ( !empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
		$instance['image_path'] = ( !empty( $new_instance['image_path'] ) ) ? strip_tags( $new_instance['image_path'] ) : '';
		$instance['link_url'] = ( !empty( $new_instance['link_url'] ) ) ? strip_tags( $new_instance['link_url'] ) : '';
		return $instance;
	}

}
