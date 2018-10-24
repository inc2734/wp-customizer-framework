<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Customizer_Framework\App\Customize_Control;

class Content_Control extends \WP_Customize_Control {

	/**
	 * @var string
	 */
	public $type = 'content';

	/**
	 * Custom property
	 *
	 * @var string
	 */
	protected $content = '';

	/**
	 * Render the control's content
	 *
	 * @return void
	 */
	public function render_content() {
		?>
		<?php if ( ! empty( $this->label ) ) : ?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<?php endif; ?>

		<?php if ( ! empty( $this->description ) ) : ?>
			<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
		<?php endif; ?>

		<?php if ( ! empty( $this->content ) ) : ?>
			<div class="content customize-control-content">
				<?php echo wp_kses_post( $this->content ); ?>
			</div>
		<?php endif; ?>
		<?php
	}
}
