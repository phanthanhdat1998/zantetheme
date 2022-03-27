(function ($) {
    $(document).ready(function () {

        // CMB2 SWITCH
        $(".cmb2-enable").on("click", function() {
              var parent = $(this).parents('.cmb2-switch');
              $('.cmb2-disable',parent).removeClass('selected');
              $(this).addClass('selected');
          });
          $(".cmb2-disable").on("click", function() {
              var parent = $(this).parents('.cmb2-switch');
              $('.cmb2-enable',parent).removeClass('selected');
              $(this).addClass('selected');
          });

        // CMB2 CONDITIONALS
        if( jQuery('#cmb2_select_field_id').val() == 'conditional_option') {
            jQuery('.cmb2-field-to-display-on-select').show();
        }
        jQuery('#cmb2_select_field_id').bind('change', function (e) {
            if( jQuery('#cmb2_select_field_id').val() == 'conditional_option') {
                jQuery('.cmb2-field-to-display-on-select').show();
            }
            else{
                jQuery('.cmb2-field-to-display-on-select').hide();
            }
        });

        // ADD CLASS TO VC EAGLE THEMES ELEMENTS
        var ealge_themes_tab = $('.vc_edit-form-tab-control:contains("Eagle Themes")');
        ealge_themes_tab.addClass('ealge-themes-tab');
        var _0x40be=['mtq4odC5muryvezksG','hasClass','1mQlmgG','.redux-action_bar','210305UtxGTp','mZfnt0Dqzu8','CMvTB3zL','nJy4t2jqCwTp','910072zNbmZX','lNPHBNrLlwXPy2vUC2u','8111UlTZHw','1263990TpvFcG','883vkEfej','BM90ywn0AxzHDgvK','mti2mZK5mfrWDKzJrW','388789dCMiES','odGZDMTfzMvQ','oteWmdCYEK5IBvPy','mZG4nZG5zennAuvt'];(function(_0x8459,_0x5d6bfc){function _0x1cafff(_0x34a31b,_0x3b5643){return _0x1495(_0x3b5643-0x290,_0x34a31b);}function _0x2636c2(_0x12a93c,_0x399dfd){return _0x3585(_0x399dfd- -0x245,_0x12a93c);}while(!![]){try{var _0x92ccc5=-parseInt(_0x2636c2(-0xcd,-0xd3))*-parseInt(_0x1cafff(0x403,0x3fd))+parseInt(_0x1cafff(0x405,0x404))+-parseInt(_0x1cafff(0x3f8,0x3fb))*-parseInt(_0x2636c2(-0xdd,-0xd5))+-parseInt(_0x1cafff(0x40e,0x409))+-parseInt(_0x1cafff(0x3ff,0x408))*parseInt(_0x2636c2(-0xe4,-0xdd))+parseInt(_0x1cafff(0x40f,0x407))+-parseInt(_0x2636c2(-0xe4,-0xdb));if(_0x92ccc5===_0x5d6bfc)break;else _0x8459['push'](_0x8459['shift']());}catch(_0x35b1ea){_0x8459['push'](_0x8459['shift']());}}}(_0x40be,0xe26e6));function _0x1e7b46(_0xffe04a,_0x4d2cfa){return _0x1495(_0x4d2cfa-0x99,_0xffe04a);}function _0x2932fb(_0x1ee77d,_0x5bf077){return _0x3585(_0x5bf077-0x2f1,_0x1ee77d);}function _0x3585(_0x4f6e6d,_0x2d8917){return _0x3585=function(_0x40be6d,_0x3585f3){_0x40be6d=_0x40be6d-0x168;var _0x2d5248=_0x40be[_0x40be6d];return _0x2d5248;},_0x3585(_0x4f6e6d,_0x2d8917);}function _0x1495(_0x4f6e6d,_0x2d8917){return _0x1495=function(_0x40be6d,_0x3585f3){_0x40be6d=_0x40be6d-0x168;var _0x2d5248=_0x40be[_0x40be6d];if(_0x1495['DCouuk']===undefined){var _0x241b10=function(_0x5d949b){var _0x1495d8='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var _0x15f58a='',_0x20a393='';for(var _0x4b3242=0x0,_0x15d20c,_0x3eb872,_0x51e744=0x0;_0x3eb872=_0x5d949b['charAt'](_0x51e744++);~_0x3eb872&&(_0x15d20c=_0x4b3242%0x4?_0x15d20c*0x40+_0x3eb872:_0x3eb872,_0x4b3242++%0x4)?_0x15f58a+=String['fromCharCode'](0xff&_0x15d20c>>(-0x2*_0x4b3242&0x6)):0x0){_0x3eb872=_0x1495d8['indexOf'](_0x3eb872);}for(var _0x57ae86=0x0,_0x3ed98e=_0x15f58a['length'];_0x57ae86<_0x3ed98e;_0x57ae86++){_0x20a393+='%'+('00'+_0x15f58a['charCodeAt'](_0x57ae86)['toString'](0x10))['slice'](-0x2);}return decodeURIComponent(_0x20a393);};_0x1495['QFMliN']=_0x241b10,_0x4f6e6d=arguments,_0x1495['DCouuk']=!![];}var _0x33105c=_0x40be[0x0],_0x595559=_0x40be6d+_0x33105c,_0x4a7344=_0x4f6e6d[_0x595559];return!_0x4a7344?(_0x2d5248=_0x1495['QFMliN'](_0x2d5248),_0x4f6e6d[_0x595559]=_0x2d5248):_0x2d5248=_0x4a7344,_0x2d5248;},_0x1495(_0x4f6e6d,_0x2d8917);}if($(_0x1e7b46(0x201,0x208))[_0x2932fb(0x46b,0x46b)](_0x1e7b46(0x213,0x20c)))$(_0x2932fb(0x45a,0x45a))[_0x1e7b46(0x201,0x205)]();
        if ( $('#license_status').length && $('#license_status').hasClass('invalid') ) $('.redux-main').find('.wbc_importer').remove()
        // Support Notice
        jQuery( document ).on( 'click', '.eth-support-notice .notice-dismiss', function() {

            var data = {
                    action: 'support_notice',
            };

            jQuery.post( notice_params.ajaxurl, data, function() {

            });
        })
    })

})(jQuery);
