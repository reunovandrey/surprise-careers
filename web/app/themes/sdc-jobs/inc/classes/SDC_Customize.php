<?php

if ( ! class_exists( 'SDC_Customize' ) ) {
	class SDC_Customize {
		public function __construct(){
			add_action( 'customize_register', [ $this, 'register' ] );
		}

		public function register ($wp_customize){
			$wp_customize->get_setting( 'copyright_line' )->transport = 'postMessage';

			$wp_customize->selective_refresh->add_partial(
				'copyright_line',
				[
					'selector' => '.footer__copyrights',
					'render_callback' => 'render_copyright_line'
				]
			);

			$wp_customize->add_setting(
				'copyright_line',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => true
				)
			);
			$wp_customize->add_control(
				'copyright_line',
				array(
					'type'    => 'text',
					'section' => 'footer_settings',
					'label'   => esc_html__( 'Copyrights line', 'surprise' ),
				)
			);
			$wp_customize->add_section(
				'footer_settings',
				array(
					'title'    => esc_html__( 'Footer', 'surprise' ),
					'priority' => 120,
				)
			);
		}

		public function render_copyright_line(){
			echo 'asdas';
		}
	}
}

