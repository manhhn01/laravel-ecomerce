//===== ajax setup csrf
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//===== jquery code for sidebar menu
$('.menu-item.has-submenu .menu-link').on('click', function (e) {
    e.preventDefault();
    if ($(this).next('.submenu').is(':hidden')) {
        $(this).parent('.has-submenu').siblings().find('.submenu').slideUp(200);
    }
    $(this).next('.submenu').slideToggle(200);
});

//===== mobile offnavas triggerer for generic use
$("[data-trigger]").on("click", function (e) {
    e.preventDefault();
    e.stopPropagation();
    var offcanvas_id = $(this).attr('data-trigger');
    $(offcanvas_id).toggleClass("show");
    $('body').toggleClass("offcanvas-active");
    $(".screen-overlay").toggleClass("show");

});

$(".screen-overlay, .btn-close").click(function (e) {
    $(".screen-overlay").removeClass("show");
    $(".mobile-offcanvas, .show").removeClass("show");
    $("body").removeClass("offcanvas-active");
});

//===== minimize sidebar on desktop

$('.btn-aside-minimize').on('click', function () {
    if (window.innerWidth < 768) {
        $('body').removeClass('aside-mini');
        $(".screen-overlay").removeClass("show");
        $(".navbar-aside").removeClass("show");
        $("body").removeClass("offcanvas-active");
    } else {
        // minimize sideber on desktop
        $('body').toggleClass('aside-mini');
    }
});

//==== auto submit on status filter
//disable blank search input
$(".form-filter").on("submit", function (e) {
    $(this)
        .find(":input")
        .filter(function () {
            return !this.value;
        })
        .attr("disabled", "disabled");
    return true;
});
//submit on change
$(".status-select").on("change", function () {
    $(".form-filter").submit();
});

//===== debounce input ajax
const debounce = function (callback, wait) {
    let timeout;
    return function (...args) {
        const context = this;
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            callback.apply(context, args);
        }, wait);
    };
};
