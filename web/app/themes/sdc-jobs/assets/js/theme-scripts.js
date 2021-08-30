jQuery('document').ready(function($){
    console.log('ready');

    $('.tab__link a').on('click', function(e){
        e.preventDefault();
        let _link = $(this);
        $('.tab__link a').removeClass('active');
        let _target_id = _link.attr('href');
        $(this).addClass('active');


        $('.tab__content').removeClass('active');
        $(_target_id).addClass('active');


    });
});