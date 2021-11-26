(function($) {
    "use strict";

    tinymce.PluginManager.add('res_promo', function(editor, url) {
        var shortcodeTag = 'res_promo';
        var toolbar;
        var content;

        function getAttr(s, n) {
            n = new RegExp(n + '=\"([^\"]+)\"', 'g').exec(s);
            return n ? window.decodeURIComponent(n[1]) : '';
        };

        function getHTML(cls, data ,con) {
            var placeholder = url + '/../images/bg.png';
            data = window.encodeURIComponent(data);
            content = window.encodeURIComponent(con);

            return '<img src="' + placeholder + '" class="mceItem res-promo-module sc-module ' + cls + '" ' + 'data-sh-attr="' + data + '" data-sh-content="'+ con+'" data-mce-resize="false" data-mce-placeholder="1" />';
        }

        function replaceShortcodes(content) {
            return content.replace(/\[res_promo([^\]]*)\]([^\]]*)\[\/res_promo\]/g, function(all, attr, con) {
                return getHTML('wp-res_promo', attr , con);
            });
        }

        function restoreShortcodes(content) {
            return content.replace(/(?:<p(?: [^>]+)?>)*(<img class="mceItem res-promo-module [^>]+>)(?:<\/p>)*/g, function(match, image) {
                var data = getAttr(image, 'data-sh-attr');
                var con = getAttr(image, 'data-sh-content');

                if (data) {
                    return '<p>[' + shortcodeTag + data + ']' + con + '[/' + shortcodeTag + ']</p>';
                }
                return match;
            });
        }

        function removeShortcode() {
            var img = editor.selection.getNode();

            toolbar.hide();

            editor.windowManager.confirm(sh_vars.sh_delete_confirmation, function(s) {
                if (s) {
                    editor.dom.remove(img);
                    editor.nodeChanged();
                } else {
                    toolbar.show();
                }
            });
        }

        function editShortcode() {
            var img = editor.selection.getNode();
            var data = img.attributes['data-sh-attr'].value;
            data = window.decodeURIComponent(data);
            var content = img.attributes['data-sh-content'].value;

            editor.execCommand('res_promo_panel_popup', '', {
                data_content : getAttr(data, 'data_content'),
            });
        }

        function getObjectProperty(obj, prop) {
            var prop = typeof prop !== 'undefined' ? prop : '';
            var obj = typeof obj !== 'undefined' ? obj : '';

            if (!prop || !obj) {
                return '';
            }

            var ret = obj.hasOwnProperty(prop) ? ( String(obj[prop]) !== ''? obj[prop] : '') : '';

            return ret;
        }

        // Open shortcode modal
        function openShortcodeModal(obj) {
            var short = $.parseJSON(obj);

            var modalContent = 
                '<div tabindex="0" role="dialog" id="shortcode-modal" style="position: relative;">' + 
                    '<div class="media-modal wp-core-ui">' + 
                        '<button type="button" class="media-modal-close"><span class="media-modal-icon"><span class="screen-reader-text">Close media panel</span></span></button>' + 
                        '<div class="media-modal-content">' + 
                            '<div class="media-frame mode-select wp-core-ui" id="">' + 
                                '<div class="media-frame-title">' + 
                                    '<h1>' + sh_vars.promo_title + '</h1>' + 
                                '</div>' + 
                                '<div class="media-frame-content">' + 
                                    '<div style="padding: 20px;" id="sh-promo">' + 
                                        '<div class="row">' + 
                                            '<div class="col-xs-12 col-md-6 rtl-pull-right">' + 
                                                '<div class="form-group">' + 
                                                    '<label for="sh-promo-title">' + sh_vars.title_label + '</label>' + 
                                                    '<input type="text" id="sh-promo-title" class="form-control" value="' + getObjectProperty(short, "title") + '" placeholder="' + sh_vars.title_placeholder + '">' + 
                                                '</div>'+ 
                                            '</div>'+ 
                                        '</div>' + 
                                        '<div class="row">' + 
                                            '<div class="col-xs-12">' + 
                                                '<div class="form-group">' + 
                                                    '<label for="sh-promo-text">' + sh_vars.text_label + '</label>' + 
                                                    '<textarea id="sh-promo-text" class="form-control" rows="3" placeholder="' + sh_vars.text_placeholder + '">' + getObjectProperty(short, "text") + '</textarea>' + 
                                                '</div>'+ 
                                            '</div>'+ 
                                        '</div>' + 
                                        '<div class="row">' + 
                                            '<div class="col-xs-12 col-md-6 rtl-pull-right">' + 
                                                '<div class="form-group">' + 
                                                    '<label for="sh-promo-cta-text">' + sh_vars.cta_text_label + '</label>' + 
                                                    '<input type="text" id="sh-promo-cta-text" class="form-control" value="' + getObjectProperty(short, "cta_text") + '" placeholder="' + sh_vars.cta_text_placeholder + '">' + 
                                                '</div>'+ 
                                            '</div>'+ 
                                            '<div class="col-xs-12 col-md-4 rtl-pull-right">' + 
                                                '<div class="form-group">' + 
                                                    '<label for="sh-promo-cta-link">' + sh_vars.cta_link_label + '</label>' + 
                                                    '<input type="text" id="sh-promo-cta-link" class="form-control" value="' + getObjectProperty(short, "cta_link") + '" placeholder="' + sh_vars.cta_link_placeholder + '">' + 
                                                '</div>'+ 
                                            '</div>'+ 
                                            '<div class="col-xs-12 col-md-2 rtl-pull-right">' + 
                                                '<div class="form-group">' + 
                                                    '<label for="sh-promo-cta-color" style="display:block;margin-bottom:2px;">' + sh_vars.cta_button_color + '</label>' + 
                                                    '<input type="text" id="sh-promo-cta-color" class="color-field" value="' + getObjectProperty(short, "cta_color") + '">' + 
                                                '</div>' + 
                                            '</div>' + 
                                        '</div>' + 
                                        '<div class="row">' + 
                                            '<div class="col-xs-12 col-md-6 rtl-pull-right">' + 
                                                '<div class="row">' + 
                                                    '<div class="col-xs-12 col-md-6 rtl-pull-right">' + 
                                                        '<div class="form-group">' + 
                                                            '<label style="display: block; padding-bottom: 3px;">' + sh_vars.promo_img_label + '</label>' + 
                                                            '<input type="hidden" id="sh-promo-image" name="sh-promo-image" data-src="' + getObjectProperty(short, "image_src") + '" value="' + getObjectProperty(short, "image") + '">' + 
                                                            '<div class="sh-promo-image-placeholder-container';
        if (getObjectProperty(short, "image_src") != '') { 
            modalContent += 
                                                                ' has-image'; 
        }
        modalContent += 
                                                                '"><div id="sh-promo-image-placeholder" style="background-image: url(';
        if (getObjectProperty(short, "image_src") != '') { 
            modalContent += 
                                                                    getObjectProperty(short, "image_src");
        } else { 
            modalContent += 
                                                                    sh_vars.plugin_url + 'images/image-placeholder.png';
        }
        modalContent += 
                                                                ');"></div>'+
                                                                '<div id="delete-promo-image"><span class="fa fa-trash-o"></span></div>' +
                                                            '</div>' +
                                                        '</div>' + 
                                                    '</div>' + 
                                                '</div>' + 
                                            '</div>' + 
                                            '<div class="col-xs-12 col-md-6 rtl-pull-right">' + 
                                                '<div class="row">' + 
                                                    '<div class="col-xs-12 col-md-6 rtl-pull-right">' + 
                                                        '<div class="form-group">' + 
                                                            '<label for="sh-promo-position">' + sh_vars.caption_position_label + '</label>' + 
                                                            '<select id="sh-promo-position" class="form-control">';
        var position = [
            {id : 'topLeft', label : sh_vars.top_left_label}, 
            {id : 'topRight', label : sh_vars.top_right_label}, 
            {id : 'centerLeft', label : sh_vars.center_left_label}, 
            {id : 'center', label : sh_vars.center_label}, 
            {id : 'centerRight', label : sh_vars.center_right_label}, 
            {id : 'bottomLeft', label : sh_vars.bottom_left_label}, 
            {id : 'bottomRight', label : sh_vars.bottom_right_label}
        ];
        $.each(position, function(index, value) {
            modalContent += 
                                                                '<option value="' + value.id + '"';
            if (getObjectProperty(short, "position") == value.id) {
                modalContent += 
                                                                    ' selected="selected"';
            }
            modalContent += 
                                                                '>' + value.label + '</option>';
        });
        modalContent +=
                                                            '</select>' + 
                                                        '</div>' + 
                                                    '</div>' + 
                                                    '<div class="col-xs-12 col-md-6 rtl-pull-right">' + 
                                                        '<div class="form-group">' + 
                                                            '<label for="sh-promo-margin">' + sh_vars.margin_label + '</label>';

        var margin_is_no = '';
        var margin_is_yes = '';
        if (getObjectProperty(short, "margin") == 'no') {
            margin_is_no = ' selected="selected"';
        }
        if (getObjectProperty(short, "margin") == 'yes') {
            margin_is_yes = ' selected="selected"';
        }
        modalContent += 
                                                            '<select class="form-control" id="sh-promo-margin">' + 
                                                                '<option value="no"' + margin_is_no + '>' + sh_vars.margin_no + '</option>' + 
                                                                '<option value="yes"' + margin_is_yes + '>' + sh_vars.margin_yes + '</option>' + 
                                                            '</select>' + 
                                                        '</div>'+ 
                                                    '</div>' + 
                                                '</div>'+ 
                                            '</div>' + 
                                        '</div>' + 
                                    '</div>' + 
                                '</div>' + 
                                '<div class="media-frame-toolbar" style="left: 0;">' + 
                                    '<div class="media-toolbar">' + 
                                        '<div class="media-toolbar-primary search-form">' + 
                                            '<button type="button" id="cancel-button" class="button media-button button-default button-large">' + sh_vars.cancel_btn + '</button>' + 
                                            '<button type="button" id="insert-button" class="button media-button button-primary button-large">' + sh_vars.insert_btn + '</button>' + 
                                        '</div>' + 
                                    '</div>' + 
                                '</div>' + 
                            '</div>' + 
                        '</div>' + 
                    '</div>' + 
                    '<div class="media-modal-backdrop"></div>' + 
                '</div>';

            $('body').append(modalContent);

            $('#shortcode-modal .media-modal-close').on('click', function(e) {
                setTimeout(function() {
                    $('#shortcode-modal').remove();
                }, 100);
                e.preventDefault();
            });
            $('#shortcode-modal #cancel-button').on('click', function(e) {
                setTimeout(function() {
                    $('#shortcode-modal').remove();
                }, 100);
                e.preventDefault();
            });
            $('#shortcode-modal').on('keyup',function(e) {
                var _self = $(this);
                if (e.keyCode == 27) {
                   setTimeout(function() {
                        _self.remove();
                    }, 100);
                   e.preventDefault();
                }
            });

            $('.color-field').wpColorPicker({
                defaultColor: '#333333',
            });

            $('#shortcode-modal #insert-button').on('click', function(e) {
                var shortVal = {
                    'title'    : $('#sh-promo-title').val(),
                    'text'     : $('#sh-promo-text').val(),
                    'cta_text' : $('#sh-promo-cta-text').val(),
                    'cta_link' : $('#sh-promo-cta-link').val(),
                    'cta_color': $('#sh-promo-cta-color').val(),
                    'image'    : $('#sh-promo-image').val(),
                    'image_src': $('#sh-promo-image').attr('data-src'),
                    'position' : $('#sh-promo-position').val(),
                    'margin'   : $('#sh-promo-margin').val(),
                }
                var shortcodeStr = '[' + shortcodeTag + ' data_content="' + encodeURIComponent(JSON.stringify(shortVal)) + '"' + '][/' + shortcodeTag + ']';

                editor.insertContent(shortcodeStr);

                setTimeout(function() {
                    $('#shortcode-modal').remove();
                }, 100);
                e.preventDefault();
            });

            $('#sh-promo-image-placeholder').on('click', function(event) {
                event.preventDefault();

                var frame = wp.media({
                    title: sh_vars.media_promo_image_title,
                    button: {
                        text: sh_vars.media_promo_image_btn
                    },
                    multiple: false
                });

                frame.on('select', function() {
                    var attachment = frame.state().get('selection').toJSON();
                    $.each(attachment, function(index, value) {
                        $('#sh-promo-image').val(value.id).attr('data-src', value.url);
                        $('#sh-promo-image-placeholder').css('background-image', 'url(' + value.url + ')');
                        $('.sh-promo-image-placeholder-container').addClass('has-image');
                    });
                });

                frame.open();
            });

            $('#delete-promo-image').on('click', function() {
                $('#sh-promo-image').val('').attr('data-src', '');
                $('#sh-promo-image-placeholder').css('background-image', 'url(' + sh_vars.plugin_url + 'images/image-placeholder.png)');
                $('.sh-promo-image-placeholder-container').removeClass('has-image');
            });
        }

        // Open modal
        editor.addCommand('res_promo_panel_popup', function(ui, v) {
            var data_content = '';

            if (v.data_content) {
                data_content = v.data_content;
            }

            openShortcodeModal(data_content);
        });

        editor.addCommand('res_promo_remove', function() {
            removeShortcode();
        });

        editor.addCommand('res_promo_edit', function() {
            editShortcode();
        });

        // Add button
        editor.addButton('res_promo', {
            image: url + '/../images/text-image-btn.png',
            tooltip: sh_vars.promo_title,
            onclick: function() {
                editor.execCommand('res_promo_panel_popup', '', {
                    data_content : '{ "title": "", "text": "", "cta_text": "", "cta_link": "", "cta_color": "#333333", "image": "", "image_src": "", "position": "", "margin": "no" }',
                });
            }
        });

        // Register remove shortcode button
        editor.addButton('remove_promo_shortcode', {
            text  : sh_vars.remove_btn,
            icon  : 'mce-ico mce-i-dashicon dashicons-no',
            cmd   : 'res_promo_remove',
        });

        // Register edit shortcode button
        editor.addButton('edit_promo_shortcode', {
            text  : sh_vars.edit_btn,
            icon  : 'mce-ico mce-i-dashicon dashicons-edit',
            cmd   : 'res_promo_edit',
        });

        // Add toolbar on image placeholder
        editor.once('preinit', function() {
            if (editor.wp && editor.wp._createToolbar) {
                toolbar = editor.wp._createToolbar([
                    'remove_promo_shortcode',
                    'edit_promo_shortcode',
                ]);
            }
        });

        editor.on('wptoolbar', function(e) {
            if (e.element.nodeName == 'IMG' && e.element.className.indexOf('wp-res_promo') > -1) {
                e.toolbar = toolbar;
            }
        });

        // Replace shortcode with an image placeholder
        editor.on('BeforeSetcontent', function(e) { 
            e.content = replaceShortcodes(e.content);
        });

        // Replace image placeholder with shortcode
        editor.on('GetContent', function(e) {
            e.content = restoreShortcodes(e.content);
        });

        // Open popup when double click on placeholder
        editor.on('DblClick', function(e) {
            var cls = e.target.className.indexOf('wp-res_promo');

            if (e.target.nodeName == 'IMG' && e.target.className.indexOf('wp-res_promo') > -1) {
                var data = e.target.attributes['data-sh-attr'].value;
                data = window.decodeURIComponent(data);
                var content = e.target.attributes['data-sh-content'].value;
                editor.execCommand('res_promo_panel_popup', '', {
                    data_content : getAttr(data, 'data_content')
                });
            }
        });
    });

})(jQuery);