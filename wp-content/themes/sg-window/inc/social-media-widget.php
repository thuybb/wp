<?php
/**
 * Add a widget
 */
class sgwindow_SocialIcons extends WP_Widget {

	function sgwindow_SocialIcons() {

		/* Widget settings. */
		$widget_ops = array(
		'classname' => 'sgwindow_socialicons',
		'description' => __('Display Social Media Links.', 'sg-window' ));

		/* Widget control settings. */
		$control_ops = array(
		'width' => 250,
		'height' => 250,
		'id_base' => 'sgwindow_socialicons_widget');
		
		/* Create the widget. */		
		parent::__construct( 'sgwindow_socialicons_widget', __('SG Social Media Icons', 'sg-window' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		// Widget output
		extract($args);
		
		$defaults = $this->get_defaults();			
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		
		$classes = '';

		if( $instance['is_vertical'] != '' )
			$classes = 'vertical';
		else
			$classes = 'horizontal';
			
		if( $instance['is_small'] != ''  )
			$classes .= ' small';
		else
			$classes .= ' big';
		
		$out = '<ul class="'.$classes.'">';
		foreach($instance as $id => $icon) {
			if(trim($icon) != '' && $id != 'is_vertical' & $id != 'is_small' & $id != 'title') {
				$out .= '<li><a style="background: url('.get_template_directory_uri().'/img/icons/'.($instance['is_small'] != ''  ? 'small/' : '' ).$id.'.png)" href="'.esc_url($icon).'" target="_blank" title="'. esc_attr($id).'"></a></li>';
			}
		}
		
		$out .= '</ul>';	

		//print the widget for the sidebar
		echo $before_widget;
		if(trim($instance['title']) !== '') echo $before_title.esc_html($instance['title']).$after_title;
		echo $out;
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		// Save widget options
		foreach ( $new_instance as $key => $instance ) {
			if( $key == 'title' || $key == 'is_small' || $key == 'is_vertical' )
				$new_instance[$key] = esc_html($new_instance[$key]);
			else
				$new_instance[$key] = esc_url_raw($new_instance[$key]);
		}
		return $new_instance;
	}

	function form( $instance ) {
		// Output admin widget options form
		// Set up some default widget settings. 
		$defaults = $this->get_defaults();			
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		
		$icons = $this->social_icons();
		
		$instance = wp_parse_args( (array) $instance, $icons ); 
		
		sgwindow_echo_input_text( $this, 'title', $instance, __( 'Title: ', 'sg-window' ), 0);
		
		sgwindow_echo_input_checkbox( $this, 'is_small', $instance, __( 'Small Icons.', 'sg-window'));
		sgwindow_echo_input_checkbox( $this, 'is_vertical', $instance, __( 'Vertical Icons.', 'sg-window'));

		
		foreach ($icons as $id => $icon) {
			sgwindow_echo_input_text( $this, $id, $instance, $id);
		}
	}
	function get_defaults() {
		return array('title' => '',
						  'is_small'   => '',	
						  'is_vertical'   => '',	
						);
	}
	function echo_input_text($name, $instance, $title, $show_mage = 1) { ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( $name ) );?>"><?php echo esc_html(strtoupper($title)); ?></label>
			<hr>
			<?php if ( $show_mage ) : ?>
				<img src="<?php echo get_template_directory_uri().'/img/icons/'.$name.'.png'; ?>">
			<?php endif; ?>	
			<input size="34" type="text" name="<?php echo esc_attr( $this->get_field_name( $name ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( $name ) ); ?>" value="<?php echo esc_html($instance[$name]); ?>" />		
		</p>
		<hr>
		<?php 
	}
	function echo_input_checkbox($name, $instance, $title) { ?>
			<p>
				<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( $name ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( $name ) ); ?>"  value="1" <?php checked( $instance[$name], '1'); ?> />
				<label for="<?php echo esc_attr( $this->get_field_id( $name ) ); ?>"><?php echo esc_html($title); ?></label>
			</p>
			<hr>
		<?php
	}
	
	/**
	 * Return array Social Icons List
	 *
	 * @since SG Window 1.0.0
	 */
	function social_icons(){
		$icons = array(
						'facebook' => '',
						'twitter' => '',
						'google' => '',
						'wordpress' => '',
						'blogger' => '',
						'yahoo' => '',
						'youtube' => '',
						'myspace' => '',
						'livejournal' => '',
						'linkedin' => '',
						'friendster' => '',
						'friendfeed' => '',
						'digg' => '',
						'delicious' => '',
						'aim' => '',
						'ask' => '',
						'buzz' => '',
						'tumblr' => '',		
						'flickr' => '',						
						'rss' => '',
					  );
					  
		foreach ($icons as $id => $icon) {
			$icons[$id] = get_theme_mod($id, '');
		}
		return $icons;
	}
}
/* Register widget*/
function sgwindow_register_social_widgets() {
	register_widget( 'sgwindow_SocialIcons' );
}
add_action( 'widgets_init', 'sgwindow_register_social_widgets' );
