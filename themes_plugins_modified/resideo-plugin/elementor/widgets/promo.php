<?php
/**
 * @package WordPress
 * @subpackage Resideo
 */

class Elementor_Resideo_Promo_Widget extends \Elementor\Widget_Base {
    public function get_name() {
        return 'promo';
    }

    public function get_title() {
        return __('Promo', 'resideo');
    }

    public function get_icon() {
        return 'fa fa-info-circle';
    }

    public function get_categories() {
        return ['resideo'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'title_section',
            [
                'label' => __('Title', 'resideo'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'resideo'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'string',
                'placeholder' => __('Enter title', 'resideo'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'background_section',
            [
                'label' => __('Background Image', 'resideo'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'background_image',
            [
                'label' => __('Choose image', 'resideo'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'cta_section',
            [
                'label' => __('CTA', 'resideo'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'cta_link',
            [
                'label' => __('CTA Link', 'resideo'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('Enter CTA link', 'resideo'),
                'show_external' => true,
            ]
        );

        $this->add_control(
            'cta_color',
            [
                'label' => __('CTA Color', 'resideo'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cta_label',
            [
                'label' => __('CTA Label', 'resideo'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'string',
                'placeholder' => __('Enter CTA label', 'resideo'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'resideo'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'text',
            [
                'label' => __('Text', 'resideo'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Enter promo text', 'resideo'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'layout_section',
            [
                'label' => __('Layout', 'resideo'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'caption_position',
            [
                'label' => __('Caption Position', 'resideo'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'topLeft',
                'options' => array(
                    'topLeft' => __('Top Left', 'resideo'),
                    'topRight' => __('Top Right', 'resideo'),
                    'centerLeft' => __('Center Left', 'resideo'),
                    'center' => __('Center', 'resideo'),
                    'centerRight' => __('Center Right', 'resideo'),
                    'bottomLeft' => __('Bottom Left', 'resideo'),
                    'bottomRight' => __('Bottom Right', 'resideo'),
                )
            ]
        );

        $this->add_control(
            'margin',
            [
                'label' => __('Margin', 'resideo'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'resideo'),
                'label_off' => __('No', 'resideo'),
                'return_value' => 'yes'
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $margin_class = $settings['margin'] == 'yes' ? 'mt-100' : '';

        $section_class = 'pb-300';
        $caption_class = '';

        $bg_image_src = '';
        $bg_image = false;
        if (isset($settings['background_image'])) {
            $bg_image = wp_get_attachment_image_src($settings['background_image']['id'], 'pxp-full');

            if ($bg_image != false) {
                $bg_image_src = $bg_image[0];
            }
        }

        switch ($settings['caption_position']) {
            case 'topLeft':
                $section_class = 'pb-300';
                $caption_class = '';
            break;
            case 'topRight':
                $section_class = 'pb-300';
                $caption_class = 'justify-content-end';
            break;
            case 'centerLeft':
                $section_class = 'pt-200 pb-200';
                $caption_class = '';
            break;
            case 'center':
                $section_class = 'pt-200 pb-200';
                $caption_class = 'justify-content-center';
            break;
            case 'centerRight':
                $section_class = 'pt-200 pb-200';
                $caption_class = 'justify-content-end';
            break;
            case 'bottomLeft':
                $section_class = 'pt-300';
                $caption_class = '';
            break;
            case 'bottomRight':
                $section_class = 'pt-300';
                $caption_class = 'justify-content-end';
            break;
            default:
                $section_class = 'pb-300';
                $caption_class = '';
            break;
        }

        $cta_id = uniqid();
        $cta_color = isset($settings['cta_color']) ? $settings['cta_color'] : ''; ?>

        <div class="pxp-cta-1 pxp-cover <?php echo esc_attr($margin_class); ?> <?php echo esc_attr($section_class); ?>" style="background-image: url(<?php echo esc_url($bg_image_src); ?>)">
            <div class="container">
                <div class="row <?php echo esc_attr($caption_class); ?>">
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="pxp-cta-1-caption pxp-animate-in">
                            <h2 class="pxp-section-h2"><?php echo esc_html($settings['title']); ?></h2>
                            <p class="pxp-text-light"><?php echo esc_html($settings['text']); ?></p>

                            <?php if ($settings['cta_link']['url'] != '') { 
                                $target = $settings['cta_link']['is_external'] ? ' target="_blank"' : '';
                                $nofollow = $settings['cta_link']['nofollow'] ? ' rel="nofollow"' : ''; ?>
                                <a href="<?php echo esc_url($settings['cta_link']['url']); ?>" class="pxp-primary-cta text-uppercase mt-3 mt-md-5 pxp-animate" id="cta-<?php echo esc_attr($cta_id); ?>" style="color: <?php echo esc_attr($cta_color); ?>" <?php echo $target; ?> <?php echo $nofollow; ?>><?php echo esc_html($settings['cta_label']); ?></a>
                                <style>.pxp-primary-cta#cta-<?php echo esc_attr($cta_id); ?>:after { border-top: 2px solid <?php echo esc_html($cta_color); ?>; }</style>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php }
}
?>