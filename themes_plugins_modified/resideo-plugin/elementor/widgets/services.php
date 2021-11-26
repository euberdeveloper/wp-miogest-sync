<?php
/**
 * @package WordPress
 * @subpackage Resideo
 */

class Elementor_Resideo_Services_Widget extends \Elementor\Widget_Base {
    public function get_name() {
        return 'services';
    }

    public function get_title() {
        return __('Services', 'resideo');
    }

    public function get_icon() {
        return 'fa fa-briefcase';
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

        $this->add_control(
            'subtitle',
            [
                'label' => __('Subtitle', 'resideo'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'string',
                'placeholder' => __('Enter subtitle', 'resideo'),
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
            'services_section',
            [
                'label' => __('Services', 'resideo'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $services = new \Elementor\Repeater();

        $services->add_control(
            'service_icon',
            [
                'label' => __('Icon', 'resideo'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fa fa-camera',
                    'library' => 'solid',
                ],
            ]
        );

        $services->add_control(
            'service_icon_color',
            [
                'label' => __('Icon Color', 'resideo'),
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

        $services->add_control(
            'service_title',
            [
                'label' => __('Title', 'resideo'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'string',
                'placeholder' => __('Enter serice title', 'resideo'),
            ]
        );

        $services->add_control(
            'service_text',
            [
                'label' => __('Text', 'resideo'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Enter service text', 'resideo'),
            ]
        );

        $services->add_control(
            'service_link',
            [
                'label' => __('Service Link', 'resideo'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('Enter service link', 'resideo'),
                'show_external' => true,
            ]
        );

        $services->add_control(
            'service_cta_label',
            [
                'label' => __('CTA Label', 'resideo'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'string',
                'placeholder' => __('Enter service CTA lablel', 'resideo'),
            ]
        );

        $services->add_control(
            'service_cta_color',
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
            'services_list',
            [
                'label' => __('Services List', 'resideo'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $services->get_controls(),
                'title_field' => '{{{ service_title }}}',
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
            'layout',
            [
                'label' => __('Layout', 'resideo'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    '1' => [
                        'title' => __('Layout 1', 'resideo'),
                        'icon' => 'fa fa-columns',
                    ],
                    '2' => [
                        'title' => __('Layout 2', 'resideo'),
                        'icon' => 'fa fa-list',
                    ],
                    '3' => [
                        'title' => __('Layout 3', 'resideo'),
                        'icon' => 'fa fa-indent',
                    ],
                    '4' => [
                        'title' => __('Layout 4', 'resideo'),
                        'icon' => 'fa fa-th-list',
                    ],
                    '5' => [
                        'title' => __('Layout 5', 'resideo'),
                        'icon' => 'fa fa-plus-square-o',
                    ]
                ],
                'default' => '1',
                'toggle' => false,
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

        $bg_image_src = '';
        $bg_image = false;
        if (isset($settings['background_image'])) {
            $bg_image = wp_get_attachment_image_src($settings['background_image']['id'], 'pxp-full');

            if ($bg_image != false) {
                $bg_image_src = $bg_image[0];
            }
        } 
        $margin_class = $settings['margin'] == 'yes' ? 'mt-100' : '';


        switch ($settings['layout']) {
            case '1': ?>
                <div class="pxp-services pxp-cover pt-100 mb-200 <?php echo esc_attr($margin_class); ?>" style="background-image: url(<?php echo esc_url($bg_image_src); ?>);">
                    <h2 class="text-center pxp-section-h2"><?php echo esc_html($settings['title']); ?></h2>
                    <p class="pxp-text-light text-center"><?php echo esc_html($settings['subtitle']); ?></p>

                    <div class="container">
                        <div class="pxp-services-container rounded-lg mt-4 mt-md-5">
                            <?php foreach ($settings['services_list'] as $service) {
                                $target = $service['service_link']['is_external'] ? ' target="_blank"' : '';
                                $nofollow = $service['service_link']['nofollow'] ? ' rel="nofollow"' : '';

                                if ($service['service_link']['url'] != '') { ?>
                                    <a href="<?php echo esc_url($service['service_link']['url']); ?>" class="pxp-services-item" <?php echo $target; ?> <?php echo $nofollow; ?>>
                                <?php } else { ?>
                                    <div class="pxp-services-item">
                                <?php } ?>

                                        <div class="pxp-services-item-fig">
                                            <?php if (is_array($service['service_icon']['value'])) { ?>
                                                <img src="<?php echo esc_url($service['service_icon']['value']['url']); ?>" alt="<?php echo esc_html($service['service_title']); ?>">
                                            <?php } else { ?>
                                                <span class="<?php echo esc_attr($service['service_icon']['value']); ?>" style="color: <?php echo esc_attr($service['service_icon_color']); ?>"></span>
                                            <?php } ?>
                                        </div>

                                        <div class="pxp-services-item-text text-center">
                                            <div class="pxp-services-item-text-title"><?php echo esc_html($service['service_title']); ?></div>
                                            <div class="pxp-services-item-text-sub"><?php echo esc_html($service['service_text']); ?></div>
                                        </div>

                                        <div class="pxp-services-item-cta text-uppercase text-center" style="color: <?php echo esc_attr($service['service_cta_color']); ?>"><?php echo esc_html($service['service_cta_label']); ?></div>

                                <?php if ($service['service_link']['url'] != '') { ?>
                                    </a>
                                <?php } else { ?>
                                    </div>
                                <?php }
                            } ?>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            <?php break;
            case '2': 
                $item_margin = ''; ?>
                <div class="pxp-services-h pt-100 pb-100 <?php echo esc_attr($margin_class); ?>">
                    <div class="container">
                        <h2 class="pxp-section-h2"><?php echo esc_html($settings['title']); ?></h2>
                        <p class="pxp-text-light"><?php echo esc_html($settings['subtitle']); ?></p>

                        <div class="pxp-services-h-container mt-4 mt-md-5">
                            <div class="pxp-services-h-fig pxp-cover rounded-lg pxp-animate-in" style="background-image: url(<?php echo esc_url($bg_image_src); ?>);"></div>
                            <div class="pxp-services-h-items pxp-animate-in ml-0 ml-lg-5 mt-4 mt-md-5 mt-lg-0">
                                <?php $service_i = 0;
                                foreach ($settings['services_list'] as $service) { 
                                    if ($service_i > 0) {
                                        $item_margin = 'mt-3 mt-md-4';
                                    } ?>
                                    <div class="pxp-services-h-item <?php echo esc_attr($item_margin); ?>">
                                        <div class="media">
                                            <?php if (is_array($service['service_icon']['value'])) { ?>
                                                <img src="<?php echo esc_url($service['service_icon']['value']['url']); ?>" class="mr-4" alt="<?php echo esc_html($service['service_title']); ?>">
                                            <?php } else { ?>
                                                <span class="mr-4 <?php echo esc_attr($service['service_icon']['value']); ?>" style="color: <?php echo esc_attr($service['service_icon_color']); ?>"></span>
                                            <?php } ?>
                                            <div class="media-body">
                                                <h5 class="mt-0"><?php echo esc_html($service['service_title']); ?></h5>
                                                <?php echo esc_html($service['service_text']); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $service_i++;
                                }
                                if ($settings['cta_link']['url'] != '') { 
                                    $target = $settings['cta_link']['is_external'] ? ' target="_blank"' : '';
                                    $nofollow = $settings['cta_link']['nofollow'] ? ' rel="nofollow"' : ''; ?>
                                    <a href="<?php echo esc_url($settings['cta_link']['url']); ?>" class="pxp-primary-cta text-uppercase mt-4 mt-md-5 pxp-animate pxp-animate-in" <?php echo $target; ?> <?php echo $nofollow; ?>><?php echo esc_html($settings['cta_label']); ?></a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php break;
            case '3': ?>
                <div class="pt-100 pb-100 position-relative <?php echo esc_attr($margin_class); ?>">
                    <div class="pxp-services-c pxp-cover" style="background-image: url(<?php echo esc_url($bg_image_src); ?>);"></div>
                    <div class="pxp-services-c-content">
                        <div class="pxp-services-c-intro">
                            <h2 class="pxp-section-h2"><?php echo esc_html($settings['title']); ?></h2>
                            <p class="pxp-text-light"><?php echo esc_html($settings['subtitle']); ?></p>
                            <?php if ($settings['cta_link']['url'] != '') { 
                                $target = $settings['cta_link']['is_external'] ? ' target="_blank"' : '';
                                $nofollow = $settings['cta_link']['nofollow'] ? ' rel="nofollow"' : ''; ?>
                                <a href="<?php echo esc_url($settings['cta_link']['url']); ?>" class="pxp-primary-cta text-uppercase mt-2 mt-md-3 mt-lg-5 pxp-animate" <?php echo $target; ?> <?php echo $nofollow; ?>><?php echo esc_html($settings['cta_label']); ?></a>
                            <?php } ?>
                        </div>
                        <div class="pxp-services-c-container mt-4 mt-md-5 mt-lg-0">
                            <div class="owl-carousel pxp-services-c-stage">
                                <?php foreach ($settings['services_list'] as $service) { ?>
                                    <div>
                                        <?php $target = $service['service_link']['is_external'] ? ' target="_blank"' : '';
                                        $nofollow = $service['service_link']['nofollow'] ? ' rel="nofollow"' : '';

                                        if ($service['service_link']['url'] != '') { ?>
                                            <a href="<?php echo esc_url($service['service_link']['url']); ?>" class="pxp-services-c-item" <?php echo $target; ?> <?php echo $nofollow; ?>>
                                        <?php } else { ?>
                                            <div class="pxp-services-c-item">
                                        <?php } ?>
                                                <div class="pxp-services-c-item-fig">
                                                    <?php if (is_array($service['service_icon']['value'])) { ?>
                                                        <img src="<?php echo esc_url($service['service_icon']['value']['url']); ?>" class="mr-4" alt="<?php echo esc_html($service['service _title']); ?>">
                                                    <?php } else { ?>
                                                        <span class="mr-4 <?php echo esc_attr($service['service_icon']['value']); ?>" style="color: <?php echo esc_attr($service['service_icon_color']); ?>"></span>
                                                    <?php } ?>
                                                </div>
                                                <div class="pxp-services-c-item-text text-center">
                                                    <div class="pxp-services-c-item-text-title"><?php echo esc_html($service['service_title']); ?></div>
                                                    <div class="pxp-services-c-item-text-sub"><?php echo esc_html($service['service_text']); ?></div>
                                                </div>
                                                <div class="pxp-services-c-item-cta text-uppercase text-center" style="color: <?php echo esc_attr($service['service_cta_color']); ?>"><?php echo esc_html($service['service_cta_label']); ?></div>
                                        <?php if ($service['service_link']['url'] != '') { ?>
                                            </a>
                                        <?php } else { ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php break;
            case '4': ?>
                <div class="pxp-services-columns <?php echo esc_attr($margin_class); ?>">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <h2 class="pxp-section-h2"><?php echo esc_html($settings['title']); ?></h2>
                                <p class="pxp-text-light"><?php echo esc_html($settings['subtitle']); ?></p>
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-6">
                                <div class="row">
                                    <?php foreach ($settings['services_list'] as $service) { ?>
                                        <div class="col-sm-6">
                                            <div class="pxp-services-columns-item mb-3 mb-md-4">
                                                <div class="pxp-services-columns-item-fig">
                                                    <?php if (is_array($service['service_icon']['value'])) { ?>
                                                        <img src="<?php echo esc_url($service['service_icon']['value']['url']); ?>" alt="<?php echo esc_html($service['service_title']); ?>">
                                                    <?php } else { ?>
                                                        <span class="<?php echo esc_attr($service['service_icon']['value']); ?>" style="color: <?php echo esc_attr($service['service_icon_color']); ?>"></span>
                                                    <?php } ?>
                                                </div>
                                                <h3 class="mt-3"><?php echo esc_html($service['service_title']); ?></h3>
                                                <p class="pxp-text-light"><?php echo esc_html($service['service_text']); ?></p>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php break;
            case '5': 
                $acc_id = uniqid();
                if ($bg_image_src == '') { ?>
                    <div class="pxp-services-accordion <?php echo esc_attr($margin_class); ?>">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4">
                                    <h2 class="pxp-section-h2"><?php echo esc_html($settings['title']); ?></h2>
                                    <p class="pxp-text-light"><?php echo esc_html($settings['subtitle']); ?></p>
                                </div>
                                <div class="col-md-2"></div>
                                <div class="col-md-6">
                                    <div class="accordion" id="pxpServicesAccordion<?php echo esc_attr($acc_id); ?>">
                                        <?php $count = 0;
                                        foreach ($settings['services_list'] as $service) {
                                            $item_class = '';
                                            $collapsed = '';
                                            $show = 'show';
                                            if ($count > 0) {
                                                $item_class = 'mt-2 mt-md-3';
                                                $collapsed = 'collapsed';
                                                $show = '';
                                            } ?>
                                            <div class="pxp-services-accordion-item <?php echo esc_attr($item_class); ?>">
                                                <div class="pxp-services-accordion-item-header" id="pxpServicesAccordionHeading<?php echo esc_attr($acc_id); ?>-<?php echo esc_attr($count); ?>">
                                                    <h4 class="mb-0">
                                                        <button class="btn btn-link btn-block text-left <?php echo esc_attr($collapsed); ?>" type="button" data-toggle="collapse" data-target="#pxpServicesAccordionCollapse<?php echo esc_attr($acc_id); ?>-<?php echo esc_attr($count); ?>" aria-expanded="true" aria-controls="pxpServicesAccordionCollapse<?php echo esc_attr($acc_id); ?>-<?php echo esc_attr($count); ?>">
                                                            <span class="pxp-services-accordion-item-icon"></span> <?php echo esc_html($service['service_title']); ?>
                                                        </button>
                                                    </h4>
                                                </div>
                                                <div id="pxpServicesAccordionCollapse<?php echo esc_attr($acc_id); ?>-<?php echo esc_attr($count); ?>" class="collapse <?php echo esc_attr($show); ?>" aria-labelledby="pxpServicesAccordionHeading<?php echo esc_attr($acc_id); ?>-<?php echo esc_attr($count); ?>" data-parent="#pxpServicesAccordion<?php echo esc_attr($acc_id); ?>">
                                                    <div class="pxp-services-accordion-item-body pxp-text-light"><?php echo esc_html($service['service_text']); ?></div>
                                                </div>
                                            </div>
                                            <?php $count++;
                                        } ?>
                                    </div>
                                    <?php if ($settings['cta_link']['url'] != '') { 
                                        $target = $settings['cta_link']['is_external'] ? ' target="_blank"' : '';
                                        $nofollow = $settings['cta_link']['nofollow'] ? ' rel="nofollow"' : ''; ?>
                                        <a href="<?php echo esc_url($settings['cta_link']['url']); ?>" class="pxp-primary-cta text-uppercase mt-4 mt-md-5 pxp-animate" <?php echo $target; ?> <?php echo $nofollow; ?>><?php echo esc_html($settings['cta_label']); ?></a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="pxp-services-accordion <?php echo esc_attr($margin_class); ?>">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-5">
                                    <h2 class="pxp-section-h2"><?php echo esc_html($settings['title']); ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-6">
                                <div class="pxp-services-accordion-fig pxp-cover" style="background-image: url(<?php echo esc_url($bg_image_src); ?>);"></div>
                            </div>
                            <div class="col-md-6 pxp-services-accordion-right">
                                <div class="pxp-services-accordion-right-container">
                                    <div class="row">
                                        <div class="col-xl-10 col-xxl-6">
                                            <h3><?php echo esc_html($settings['subtitle']); ?></h3>
                                            <div class="accordion mt-4 mt-md-5" id="pxpServicesAccordionFig<?php echo esc_attr($acc_id); ?>">
                                                <?php $count = 0;
                                                foreach ($settings['services_list'] as $service) {
                                                    $item_class = '';
                                                    $collapsed = '';
                                                    $show = 'show';
                                                    if ($count > 0) {
                                                        $item_class = 'mt-2 mt-md-3';
                                                        $collapsed = 'collapsed';
                                                        $show = '';
                                                    } ?>
                                                    <div class="pxp-services-accordion-item <?php echo esc_attr($item_class); ?>">
                                                        <div class="pxp-services-accordion-item-header" id="pxpServicesAccordionFigHeading<?php echo esc_attr($acc_id); ?>-<?php echo esc_attr($count); ?>">
                                                            <h4 class="mb-0">
                                                                <button class="btn btn-link btn-block text-left <?php echo esc_attr($collapsed); ?>" type="button" data-toggle="collapse" data-target="#pxpServicesAccordionFigCollapse<?php echo esc_attr($acc_id); ?>-<?php echo esc_attr($count); ?>" aria-expanded="true" aria-controls="pxpServicesAccordionFigCollapse<?php echo esc_attr($acc_id); ?>-<?php echo esc_attr($count); ?>">
                                                                    <span class="pxp-services-accordion-item-icon"></span> <?php echo esc_html($service['service_title']); ?>
                                                                </button>
                                                            </h4>
                                                        </div>
                                                        <div id="pxpServicesAccordionFigCollapse<?php echo esc_attr($acc_id); ?>-<?php echo esc_attr($count); ?>" class="collapse <?php echo esc_attr($show); ?>" aria-labelledby="pxpServicesAccordionFigHeading<?php echo esc_attr($acc_id); ?>-<?php echo esc_attr($count); ?>" data-parent="#pxpServicesAccordionFig<?php echo esc_attr($acc_id); ?>">
                                                            <div class="pxp-services-accordion-item-body pxp-text-light"><?php echo esc_html($service['service_text']); ?></div>
                                                        </div>
                                                    </div>
                                                    <?php $count++;
                                                } ?>
                                            </div>
                                            <?php if ($settings['cta_link']['url'] != '') { 
                                                $target = $settings['cta_link']['is_external'] ? ' target="_blank"' : '';
                                                $nofollow = $settings['cta_link']['nofollow'] ? ' rel="nofollow"' : ''; ?>
                                                <a href="<?php echo esc_url($settings['cta_link']['url']); ?>" class="pxp-primary-cta text-uppercase mt-4 mt-md-5 pxp-animate" <?php echo $target; ?> <?php echo $nofollow; ?>><?php echo esc_html($settings['cta_label']); ?></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
            break;
            default: ?>
                <div class="pxp-services pxp-cover pt-100 mb-200 <?php echo esc_attr($margin_class); ?>" style="background-image: url(<?php echo esc_url($bg_image_src); ?>);">
                    <h2 class="text-center pxp-section-h2"><?php echo esc_html($settings['title']); ?></h2>
                    <p class="pxp-text-light text-center"><?php echo esc_html($settings['subtitle']); ?></p>

                    <div class="container">
                        <div class="pxp-services-container rounded-lg mt-4 mt-md-5">
                            <?php foreach ($settings['services_list'] as $service) {
                                $target = $service['service_link']['is_external'] ? ' target="_blank"' : '';
                                $nofollow = $service['service_link']['nofollow'] ? ' rel="nofollow"' : '';

                                if ($service['service_link']['url'] != '') { ?>
                                    <a href="<?php echo esc_url($service['service_link']['url']); ?>" class="pxp-services-item" <?php echo $target; ?> <?php echo $nofollow; ?>>
                                <?php } else { ?>
                                    <div class="pxp-services-item">
                                <?php } ?>

                                <div class="pxp-services-item-fig">
                                    <?php if (is_array($service['service_icon']['value'])) { ?>
                                        <img src="<?php echo esc_url($service['service_icon']['value']['url']); ?>" alt="<?php echo esc_html($service['service_title']); ?>">
                                    <?php } else { ?>
                                        <span class="<?php echo esc_attr($service['service_icon']['value']); ?>" style="color: <?php echo esc_attr($service['service_icon_color']); ?>"></span>
                                    <?php } ?>
                                </div>

                                <div class="pxp-services-item-text text-center">
                                    <div class="pxp-services-item-text-title"><?php echo esc_html($service['service_title']); ?></div>
                                    <div class="pxp-services-item-text-sub"><?php echo esc_html($service['service_text']); ?></div>
                                </div>

                                <div class="pxp-services-item-cta text-uppercase text-center" style="color: <?php echo esc_attr($service['service_cta_color']); ?>"><?php echo esc_html($service['service_cta_label']); ?></div>

                                <?php if ($service['service_link']['url'] != '') { ?>
                                    </a>
                                <?php } else { ?>
                                    </div>
                                <?php }
                            } ?>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            <?php break;
        } 
    }
}
?>