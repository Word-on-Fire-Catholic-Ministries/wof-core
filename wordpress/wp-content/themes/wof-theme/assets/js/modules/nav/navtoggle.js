
(function ($) {
    $('.slide-menu__open').on('click', function (e) {
        $('.slide-menu__open').toggleClass('header__open-btn--opened')
        $('.header__bar').toggleClass('header__bar--opened')

        const topSlide = $('.slide-menu')
        const subSlide = $('.sub-menus-list > .menu-item.menu-item-has-children')

        if (subSlide.hasClass('slide-right--opened')) {
            subSlide.removeClass('slide-right--opened')
        } else {
            topSlide.toggleClass('slide-menu--opened')
        }
        e.preventDefault()
    })

    $('.top-menu .menu-item.menu-item-has-children').on('click', function (e) {
        $(`.sub-menus-list > .${e.delegateTarget.id}`).toggleClass('slide-right--opened')
        $('.slide-menu').toggleClass('slide-menu--opened')
        e.preventDefault()
    })

})(jQuery)
