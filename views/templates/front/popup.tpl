<script type="text/javascript">//&lt;![CDATA[

$(function(){

    $(".o").fancybox();

    $('.merge').click(function() {
        $.fancybox.close();
    });

    $('.submit').click(function() {
        $.fancybox.close();
    });

    $('.cancel').click(function() {
        $.fancybox.close();
    });

    $('.close').click(function() {
        $.fancybox.close();
    });
    $('.auth').click(function() {
        $.fancybox.close();
        window.open("/index.php?controller=authentication&back=my-account");
    });
});//]]&gt;


$(document).ready(function() {
    setTimeout( function() {
    $(".o").fancybox({

        modal: true,
        closeClick  : true,
        helpers:{ overlay:{ css: {  'background': '#{$template->bgColor}' ,
                                    'opacity': '{$template->opacity}',
                                    'padding' : '{$template->padding}px',
                                    'border': '{$template->borderSize}px solid #{$template->borderColor}' }}},
          openMethod : 'dropIn',
          openSpeed : 500,
          closeMethod : 'dropOut',
          closeSpeed : 100
    }).trigger('click');}, {$popup->timer});
});


(function ($, F) {

    F.transitions.dropIn = function() {
        var endPos = F._getPosition(true);

        endPos.top = (parseInt(endPos.top, 10) - 200) + 'px';
        endPos.opacity = 0;

        F.wrap.css(endPos).show().animate({
            top: '+=200px',
            opacity: 1
        }, {
            duration: F.current.openSpeed,
            complete: F._afterZoomIn
        });
    };

    F.transitions.dropOut = function() {
        F.wrap.removeClass('fancybox-opened').animate({
            top: '-=200px',
            opacity: 0
        }, {
            duration: F.current.closeSpeed,
            complete: F._afterZoomOut
        });
    };

    F.transitions.slideIn = function() {
        var endPos = F._getPosition(true);

        endPos.left = (parseInt(endPos.left, 10) - 200) + 'px';
        endPos.opacity = 0;

        F.wrap.css(endPos).show().animate({
            left: '+=200px',
            opacity: 1
        }, {
            duration: F.current.nextSpeed,
            complete: F._afterZoomIn
        });
    };

    F.transitions.slideOut = function() {
        F.wrap.removeClass('fancybox-opened').animate({
            left: '+=200px',
            opacity: 0
        }, {
            duration: F.current.prevSpeed,
            complete: function () {
                $(this).trigger('onReset').remove();
            }
        });
    };

}(jQuery, jQuery.fancybox));



</script>

<style type="text/css">

{$popup->css}

button.close {
    position: absolute;
    right: 0;
}

</style>



<div class="o" href="#open" style="display:none;" >
  <div id="open" style="display:none;">
    <div class='fancybox-body'>

{$popup->long_content}

    </div>
  </div> 
</div>