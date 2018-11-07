$(document).ready(function(){


    // $(function () {
    //     $(window).scroll(function () {
    //         if ($(this).scrollTop() > 200) {
    //             $('#acoes').css({
    //               'position':'fixed',
    //               'top':'20px',
    //               'margin-rigth':'4px'
    //             });
    //         } else {
    //            $('#acoes').css({

    //             });
    //         }
    //     });
    // }); 


    $(function(){
        $("#info-icon").click(function(e){
            e.preventDefault();
            el = $(this).data('element');
            $(el).toggle();
        });
    });
    
    
    $(function(){
        $('#imagens ul').cycle({
            fx: 'fade', //ou scrollRight
            speed: 1000,
            timeout: 0,
            next: '#prox',
            prev: '#ant',
            pager: '#pager'
        })
    })


});