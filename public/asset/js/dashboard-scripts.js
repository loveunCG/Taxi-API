$(document).ready(function () {
    var trigger = $('.hamburger'),
    overlay = $('.overlay'),
    isClosed = false;
    
    trigger.click(function () {
        hamburger_cross();      
    });

    overlay.click(function () {
        hamburger_cross();
    });

    function hamburger_cross() {
        if (isClosed == true) {
            overlay.hide();
            trigger.removeClass('is-open');
            trigger.addClass('is-closed');
            isClosed = false;
        } else {   
            overlay.show();
            trigger.removeClass('is-closed');
            trigger.addClass('is-open');
            isClosed = true;
        }
    }
    
    $('[data-toggle="offcanvas"]').click(function () {
       $('#wrapper').toggleClass('toggled');
   });  
});

function setCSS() {
    var $window = $(window);
    var windowHeight = $(window).height();
    var windowWidth = $(window).width();
    $('.full-page-bg').css('min-height', windowHeight);
}

$(document).ready(function() {
    setCSS();
    $(window).resize(function() {
        setCSS();
    });
});

function setCSS() {
    var $window = $(window);
    var windowHeight = $(window).height();
    var windowWidth = $(window).width();
    $('.dashboard-page').css('min-height', (windowHeight - 55) );
}

$(document).ready(function() {
    setCSS();
    $(window).resize(function() {
        setCSS();
    });
});

$(function(){
    $(".dropdown").hover(function() {
        $('.dropdown-menu', this).stop( true, true ).fadeIn("fast");
        $(this).toggleClass('open');
    }, function() {
        $('.dropdown-menu', this).stop( true, true ).fadeOut("fast");
        $(this).toggleClass('open');
    });
});

$('.car-detail').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: false,
    swipeToSlide: true,
    infinite: false
})

.on("mousewheel", function (event) {
    event.preventDefault();
    if (event.deltaX > 0 || event.deltaY < 0) {
        $('.slick-next').click();
    } else if (event.deltaX < 0 || event.deltaY > 0) {
        $('.slick-prev').click();
    }
});

$('#collapseDiv').on('shown.bs.collapse', function () {
    $(".glyphicon").removeClass("glyphicon-folder-close").addClass("glyphicon-folder-open");
});

$('#collapseDiv').on('hidden.bs.collapse', function () {
    $(".glyphicon").removeClass("glyphicon-folder-open").addClass("glyphicon-folder-close");
});

//profile image upload preview
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#profile_image_preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#profile_img_upload_btn").change(function(){
    readURL(this);
});


// banking add-link
$('.add-link').click(function(e){
    $('.banking-form').fadeToggle(500);
    // $(this).hide();
});


// vehicle add
$('#dispaly-vehi-form').click(function(e){
    $('.vehicle-content').fadeToggle(500);
    $(this).hide();
});

// fleet dropdown
function DropDown(el) {
    this.dd = el;
    this.placeholder = this.dd.children('span');
    this.opts = this.dd.find('ul.dropdown > li');
    this.val = '';
    this.index = -1;
    this.initEvents();
}

DropDown.prototype = {
    initEvents : function() {
        var obj = this;

        obj.dd.on('click', function(event){
            $(this).toggleClass('active');
            return false;
        });

        obj.opts.on('click',function(){
            var opt = $(this);
            obj.val = opt.text();
            obj.index = opt.index();
            obj.placeholder.text(obj.val);
        });
    },
    getValue : function() {
        return this.val;
    },
    getIndex : function() {
        return this.index;
    }
}

// 
$('.view-icon.list-btn').click( function(){
    $('.grid-view').hide();
    $('.list-view').fadeIn(300);
    $('.view-icon.list-btn').addClass('active');
    $('.view-icon.grid-btn').removeClass('active');
});

$('.view-icon.grid-btn').click( function(){
    $('.list-view').hide();
    $('.grid-view').fadeIn(300);
    $('.view-icon.list-btn').removeClass('active');
    $('.view-icon.grid-btn').addClass('active');

});