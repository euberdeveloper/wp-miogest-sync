(function(wp) {
    var registerBlockType = wp.blocks.registerBlockType;

    var TextControl   = wp.components.TextControl;
    var SelectControl = wp.components.SelectControl;
    var Button        = wp.components.Button;

    var el = wp.element.createElement;

    var MediaUpload = wp.blockEditor.MediaUpload;

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

    function SubscribeControl(props) {
        var attributes    = props.attributes;
        var setAttributes = props.setAttributes;
        var setState      = props.setState;
        var className     = props.className;
        var isSelected    = props.isSelected;

        var data_content = attributes.data_content;
        var data         = window.decodeURIComponent(data_content);
        var data_json    = jQuery.parseJSON(data);

        var title     = getObjectProperty(data_json, 'title');
        var subtitle  = getObjectProperty(data_json, 'subtitle');
        var image     = getObjectProperty(data_json, 'image');
        var image_src = getObjectProperty(data_json, 'image_src');
        var margin    = getObjectProperty(data_json, 'margin');

        var subscribeOptions = [
            el('div', 
                {
                    className: 'row'
                },
                el('div',
                    {
                        className: 'col-xs-12 col-sm-6'
                    },
                    el(TextControl, 
                        {
                            label: __('Title', 'resideo'),
                            value: title,
                            placeholder: __('Enter title', 'resideo'),
                            onChange: function(value) {
                                data_json.title = value;
                                setAttributes({ data_content: encodeURIComponent(JSON.stringify(data_json)) });
                            }
                        }
                    )
                ),
                el('div',
                    {
                        className: 'col-xs-12 col-sm-6'
                    },
                    el(TextControl, 
                        {
                            label: __('Subtitle', 'resideo'),
                            value: subtitle,
                            placeholder: __('Enter subtitle', 'resideo'),
                            onChange: function(value) {
                                data_json.subtitle = value;
                                setAttributes({ data_content: encodeURIComponent(JSON.stringify(data_json)) });
                            }
                        }
                    )
                )
            ),
            el('div',
                {
                    className: 'row'
                },
                el('div',
                    {
                        className: 'col-xs-12 col-sm-6'
                    },
                    el(MediaUpload,
                        {
                            onSelect: function(media) {
                                jQuery('.pxp-block-subscribe-bg-image-btn')
                                    .css('background-image', 'url(' + media.url + ')')
                                    .text('')
                                    .attr({
                                        'data-src': media.url,
                                        'data-id': media.id
                                    });
                                data_json.image_src = media.url;
                                data_json.image = media.id;
                                setAttributes({ data_content: encodeURIComponent(JSON.stringify(data_json)) });
                            },
                            type: 'image',
                            render: function(obj) {
                                return el(Button,
                                    {
                                        className: 'pxp-block-subscribe-bg-image-btn',
                                        'data-src': image_src,
                                        'data-id': image,
                                        style: {
                                            backgroundImage: 'url(' + image_src + ')',
                                        },
                                        onClick: obj.open
                                    },
                                    __('Background Image', 'resideo')
                                );
                            }
                        }
                    )
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
            )
        ];

        if (isSelected) {
            return el('div', 
                {
                    className: className
                },
                el('h3', 
                    {
                        className: 'subscribe-placeholder-header'
                    },
                    title
                ),
                el('h4', 
                    {
                        className: 'subscribe-placeholder-subheader'
                    },
                    subtitle
                ),
                subscribeOptions
            );
        } else {
            return el('div', 
                {
                    className: className
                },
                el('h3', 
                    {
                        className: 'subscribe-placeholder-header'
                    },
                    title
                ),
                el('h4', 
                    {
                        className: 'subscribe-placeholder-subheader'
                    },
                    subtitle
                ),
                el('div', 
                    {
                        className: 'subscribe-placeholder-img'
                    }
                )
            );
        }
    }

    registerBlockType('resideo-plugin/subscribe', {
        title: __('Subscribe', 'resideo'),
        description: __('Resideo subscribe block.', 'resideo'),
        icon: {
            src: 'email',
            foreground: '#007cba',
        },
        category: 'widgets',
        keywords: [
            __('subscribe', 'resideo'),
            __('subscription', 'resideo'),
            __('newsletter', 'resideo')
        ],
        attributes: {
            data_content: {
                type: 'string',
                default: '%7B%22title%22%3A%22%22%2C%22subtitle%22%3A%22%22%2C%22image%22%3A%22%22%2C%22image_src%22%3A%22%22%2C%22margin%22%3A%22no%22%7D'
            }
        },
        edit: withState({})(SubscribeControl),
        save: function(props) {
            return null;
        },
    });
})(window.wp);