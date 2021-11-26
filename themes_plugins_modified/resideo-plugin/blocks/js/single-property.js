(function(wp) {
    var registerBlockType = wp.blocks.registerBlockType;

    var SelectControl = wp.components.SelectControl;
    var ColorPalette  = wp.components.ColorPalette;

    var el = wp.element.createElement;

    var withState = wp.compose.withState;

    var __ = wp.i18n.__;

    function getObjectProperty(obj, prop) {
        var prop = typeof prop !== 'undefined' ? prop : '';
        var obj = typeof obj !== 'undefined' ? obj : '';

        if(!prop || !obj) {
            return '';
        }

        var ret = obj.hasOwnProperty(prop) ? ( String(obj[prop]) !== ''? obj[prop] : '') : '';

        return ret;
    }

    function getAttr(s, n) {
        n = new RegExp(n + '=\"([^\"]+)\"', 'g').exec(s);
        return n ? window.decodeURIComponent(n[1]) : '';
    };

    function SinglePropertyControl(props) {
        var attributes    = props.attributes;
        var setAttributes = props.setAttributes;
        var setState      = props.setState;
        var className     = props.className;
        var isSelected    = props.isSelected;

        var data_content = attributes.data_content;
        var data         = window.decodeURIComponent(data_content);
        var data_json    = jQuery.parseJSON(data);

        var name      = getObjectProperty(data_json, 'name');
        var id        = getObjectProperty(data_json, 'id');
        var position  = getObjectProperty(data_json, 'position');
        var margin    = getObjectProperty(data_json, 'margin');
        var cta_color = getObjectProperty(data_json, 'cta_color');

        var properties_list = sh_vars.single_property_list.replace(/\+/g, '%20');
        properties_list = properties_list != '' ? jQuery.parseJSON(decodeURIComponent(properties_list)) : [];

        var renderPropertyField = function() {
            var propertiesList = [
                { label: __('Select a property', 'resideo'), value: '' }
            ];

            jQuery.each(properties_list, function(index, value) {
                propertiesList.push({
                    label: value.title,
                    value: value.id
                });
            });

            return el(SelectControl, 
                {
                    label: __('Property', 'resideo'),
                    value: id,
                    options: propertiesList,
                    onChange: function(value) {
                        const foundName = propertiesList.filter(item => item.value == value);

                        data_json.name = foundName[0].label;
                        data_json.id = value;
                        setAttributes({ data_content: encodeURIComponent(JSON.stringify(data_json)) });
                    }
                }
            );
        };

        var renderCTAColorSelector = el('div',
            {
                className: 'components-base-control'
            },
            el('div',
                {
                    className: 'components-base-control__field'
                },
                el('fieldset',
                    {},
                    el('legend',
                        {},
                        el('div',
                            {},
                            el('span',
                                {
                                    className: 'components-base-control__label'
                                },
                                __('CTA Button Color', 'resideo'),
                            )
                        )
                    ),
                    el(ColorPalette,
                        {
                            value: cta_color,
                            colors: [
                                { name: 'Pale pink', color: '#f58fa8' },
                                { name: 'Vivid red', color: '#cd3235' },
                                { name: 'Luminous vivid orange', color: '#fd6a29' },
                                { name: 'Luminous vivid amber', color: '#fcb738' },
                                { name: 'Light green cyan', color: '#80dab7' },
                                { name: 'Vivid green cyan', color: '#2bcd89' },
                                { name: 'Pale cyan blue', color: '#8fd2f9' },
                                { name: 'Vivid cyan blue', color: '#0896df' },
                                { name: 'Vivid purple', color: '#975cdb' },
                                { name: 'Very light gray', color: '#eeeeee' },
                                { name: 'Cyan bluish gray', color: '#abb9c2' },
                                { name: 'Very dark gray', color: '#333333' }
                            ],
                            onChange: function(value) {
                                data_json.cta_color = value;
                                setAttributes({ data_content: encodeURIComponent(JSON.stringify(data_json)) });
                            }
                        }
                    )
                )
            )
        );

        var singlePropertyOptions = [
            renderPropertyField(),
            el('div',
                {
                    className: 'row'
                },
                el('div',
                    {
                        className: 'col-xs-12 col-sm-6'
                    },
                    el(SelectControl, 
                        {
                            label: __('Image Position', 'resideo'),
                            value: position,
                            options: [
                                { label: __('Left', 'resideo'), value: 'left' },
                                { label: __('Right', 'resideo'), value: 'right' }
                            ],
                            onChange: function(value) {
                                data_json.position = value;
                                setAttributes({ data_content: encodeURIComponent(JSON.stringify(data_json)) });
                            }
                        }
                    ),
                ),
                el('div',
                    {
                        className: 'col-xs-12 col-sm-6'
                    },
                    el(SelectControl, 
                        {
                            label: __('Margin', 'resideo'),
                            value: margin,
                            options: [
                                { label: __('No', 'resideo'), value: 'no' },
                                { label: __('Yes', 'resideo'), value: 'yes' }
                            ],
                            onChange: function(value) {
                                data_json.margin = value;
                                setAttributes({ data_content: encodeURIComponent(JSON.stringify(data_json)) });
                            }
                        }
                    )
                )
            ),
            renderCTAColorSelector
        ];

        if (isSelected) {
            return el('div', 
                {
                    className: className
                },
                el('h3', 
                    {
                        className: 'single-property-placeholder-header'
                    },
                    name
                ),
                singlePropertyOptions
            );
        } else {
            return el('div', 
                {
                    className: className
                },
                el('h3', 
                    {
                        className: 'single-property-placeholder-header'
                    },
                    name
                ),
                el('div', 
                    {
                        className: 'single-property-placeholder-img'
                    }
                )
            );
        }
    }

    registerBlockType('resideo-plugin/single-property', {
        title: __('Single Property', 'resideo'),
        description: __('Resideo single property block.', 'resideo'),
        icon: {
            src: 'admin-home',
            foreground: '#007cba',
        },
        category: 'widgets',
        keywords: [
            __('property', 'resideo'),
            __('single', 'resideo'),
            __('listing', 'resideo')
        ],
        attributes: {
            data_content: {
                type: 'string',
                default: '%7B%22name%22%3A%22%22%2C%22id%22%3A%22%22%2C%22position%22%3A%22left%22%2C%22margin%22%3A%22no%22%2C%22cta_color%22%3A%22%23333333%22%7D'
            }
        },
        edit: withState({})(SinglePropertyControl),
        save: function(props) {
            return null;
        },
    });
})(window.wp);