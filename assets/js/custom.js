AOS.init({

    once: true,

    duration: 800,

    disable: function() {

        var maxWidth = 800;

        return window.innerWidth < maxWidth;

    }

});



const width = window.innerWidth;

feather.replace();

gsap.registerPlugin(ScrollTrigger, ScrollSmoother);

ScrollSmoother.create({

    smooth: 1,

    effects: true,

});



let scrollY = document.querySelectorAll('.scrollY');

scrollY.forEach((item)=>{

    let speedY = item.getAttribute('speedY');

    let y = item.getAttribute('y');

    gsap.to(item,{

        y: y / speedY,

        scrollTrigger:{

            trigger:item,

            start:'top bottom',

            end:'bottom top',

            scrub:true

        }

    });

});



let scrollX = document.querySelectorAll('.scrollX');

scrollX.forEach((item)=>{

    let x = item.getAttribute('x');

    gsap.to(item,{

        x:x,

        scrollTrigger:{

            trigger:item,

            start:'top bottom',

            end:'bottom top',

            scrub:true

        }

    });

});



let spin = document.querySelectorAll('.spin');

spin.forEach((item) => {

    let speed = item.getAttribute('speed');

    let spin = item.getAttribute('spin');

    gsap.to(item, {

        rotation: spin / speed,

        ease: "none",

        scrollTrigger: {

            trigger: item,

            start: "top bottom",

            end: "bottom top",

            scrub: 1,

        },

    });

});



const topHeader = gsap.utils.toArray('header');

topHeader.forEach((header) => {

    gsap.from(header, {

        scrollTrigger: {

            start: 'top bottom',

            end: 'bottom top',

            trigger: header,

            onEnter() {

                header.classList.remove('sticky');

            },

            onLeave() {

                header.classList.add('sticky');

            },

            onEnterBack() {

                header.classList.remove('sticky');

            },

            onLeaveBack() {

                header.classList.add('sticky');

            }

        }

    });

});







if(width < 992) {

    let slider_in_resp = document.querySelector('.slider_in_resp');

    if (slider_in_resp) {

        slider_in_resp.classList.add('owl-carousel','owl-theme','services_slider');

        jQuery(".services_slider").owlCarousel({

            autoplay: true,

            rewind: false, /* use rewind if you don't want loop */

            margin: 20,

            rewindesponsiveClass: true,

            autoHeight: true,

            autoplayTimeout: 7000,

            smartSpeed: 800,

            nav: false,

            dots: true,

            responsive: {

                0: {

                    items: 1

                },



                575: {

                    items: 1

                },



                767: {

                    items: 1

                },



                991: {

                    items: 2

                }

            }

        });

    }

}






let counter = document.querySelector('#counter');

if (counter) {

    var a = 0;

    $(window).scroll(function() {

        var oTop = $(counter).offset().top - window.innerHeight;

        if (a == 0 && $(window).scrollTop() > oTop) {

            $('.counter-value').each(function() {

                var $this = $(this),countTo = $this.attr('data-count');

                $({

                    countNum: $this.text()

                }).animate({

                    countNum: countTo

                },

                {

                    duration: 2000,

                    easing: 'swing',

                    step: function() {

                        $this.text(Math.floor(this.countNum));

                    },

                    complete: function() {

                        $this.text(this.countNum);

                        //alert('finished');

                    }

                });

            });

        a = 0;

        }

    });

}

let hasDrop = document.querySelectorAll('.hasDrop');

let megaMenu = document.querySelectorAll('.megaMenu');

let cls_menu = document.querySelectorAll('.cls_menu');

hasDrop.forEach((hasDropItem)=>{

    hasDropItem.addEventListener('click',()=>{

        let targetFrom = hasDropItem.getAttribute('targetFrom');

        megaMenu.forEach((item)=>{

            let targetTo = item.getAttribute('targetTo');

            if (targetFrom === targetTo) {

                item.classList.add('activeDrop')

            }

            // else{

            //     item.classList.remove('activeDrop');

            // }

            cls_menu.forEach((clsBtn)=>{

                clsBtn.addEventListener('click',()=>{

                    // item.classList.remove('activeDrop');

                    clsBtn.parentElement.classList.remove('activeDrop');

                });

            });

        });

    });

});



////////////////SCROLL EFFECTS

let scrl_img = document.querySelectorAll('.scrl_img');

let srcl_right = document.querySelectorAll('.srcl_right');

let srcl_left = document.querySelectorAll('.srcl_left');

let bgScroll_top = document.querySelectorAll('.bgScroll_top');

let section = document.querySelectorAll('section');

let footer = document.querySelector('footer');

// let offering_img = document.querySelectorAll('.offering_img');



var X = 0;

window.addEventListener('scroll',()=>{

    let scrl = window.scrollY;

    if (bgScroll_top) {

        bgScroll_top.forEach((bg)=>{

            bg.style.backgroundPositionY=`-${scrl/2}px`;

        });

    }

    if (scrl_img) {

        scrl_img.forEach((item)=>{

            let speed = item.getAttribute('speed');

            item.style.transform=`translate(0px, -${scrl/speed}px)`;

        });

    }

    

    if (srcl_right) {

        srcl_right.forEach((item)=>{

            let speed = item.getAttribute('speed');

            item.style.transform=`translate(${scrl/speed}px)`;

        });

    }

    if (srcl_left) {

        srcl_left.forEach((item)=>{

            let speed = item.getAttribute('speed');

            item.style.transform=`translate(-${scrl/speed}px)`;

        });

    }

    // if (offering_img) {

    //     offering_img.forEach((item)=>{

    //         let speed = item.getAttribute('speed');

    //         item.style.transform=`rotate(-${scrl/speed}deg)`;

    //     });

    // }

    section.forEach((item)=>{

        var oTop = item.offsetTop - window.innerHeight + 500;

        if (X == 0 && scrl > oTop ) {

            item.classList.add('rvl_start');

            setTimeout(()=>{

                // item.classList.remove('rvl_start');

                item.classList.add('rvl_start');

            },500);

        }

        // else{

        //     item.classList.remove('rvl_start');

        // }

    });

    if (footer) {

        var oTop = footer.offsetTop - window.innerHeight + 500;

        if (X == 0 && scrl > oTop) {

            footer.classList.add('rvl_start');

        }

        // else {

        //     footer.classList.remove('rvl_start');

        // }

    }

}); 



let mainBanner = document.querySelector('.mainBanner');

setTimeout(()=>{

    mainBanner.classList.add('rvl_start');

},500);

// setTimeout(()=>{

//     mainBanner.classList.remove('rvl_start');

//     mainBanner.classList.add('rvl_finish');

// },3500);

////////////////SCROLL EFFECTS













////////////////HAMBURGER JS

var hamBurger = document.querySelector('.hamBurger')

var hamAnchors = document.querySelectorAll('.mainAnchor')

var layer = document.querySelectorAll('.layer');

var responsive_menu = document.querySelector('.responsive_menu');

hamBurger.addEventListener('click', ()=>{

    hamBurger.classList.toggle('active');

    responsive_menu.classList.toggle('openMenu');

    setTimeout(()=>{

        closeBtn.style.top="-10px";

    },500);

    layer.forEach((item)=>{

        item.classList.toggle('activeLayer');

    });

    hamAnchors.forEach((anchor,index)=>{

        setTimeout(()=>{

            anchor.classList.add('active_anchor');

            anchor.style.transitionDelay=`.${index}s`;

        },500);

    });

});



var closeBtn = document.querySelector('.closeBtn');

var responsive_menu = document.querySelector('.responsive_menu');

closeBtn.addEventListener('click', ()=>{

    setTimeout(()=>{

        responsive_menu.classList.remove('openMenu');

    },800);

    closeBtn.style.top="-70px";

    layer.forEach((item)=>{

        setTimeout(()=>{

            item.classList.remove('activeLayer');

        },500);

    });

    hamAnchors.forEach((anchor)=>{

        setTimeout(()=>{

            anchor.classList.remove('active_anchor');

        },0);

    });

    megaMenu.forEach((item)=>{

        item.classList.remove('activeDrop');

    });

});

////////////////HAMBURGER JS









    








////////////////ADD ACTIVE CLASS ON NAVIGATION TAB JS

$(function () {

    var url = window.location.pathname; //sets the variable "url" to the pathname of the current window

    var activePage = url.substring(url.lastIndexOf('/') + 1); //sets the variable "activePage" as the substring after the last "/" in the "url" variable

    $('.navigation li a, .sidebar__list li a').each(function () { //looks in each link item within the primary-nav list

        var linkPage = this.href.substring(this.href.lastIndexOf('/') + 1); //sets the variable "linkPage" as the substring of the url path in each &lt;a&gt;



        if (activePage == linkPage) { //compares the path of the current window to the path of the linked page in the nav item

            $(this).parent().addClass('active'); //if the above is true, add the "active" class to the parent of the &lt;a&gt; which is the &lt;li&gt; in the nav list

        }

    });

});

////////////////ADD ACTIVE CLASS ON NAVIGATION TAB JS























//////////////// OWL SCRIPTS

jQuery(".wwd_slider").owlCarousel({

  autoplay: true,

  rewind: false, /* use rewind if you don't want loop */

  margin: 20,

  responsiveClass: true,

  autoHeight: true,

  autoplayTimeout: 7000,

  smartSpeed: 800,

  nav: true,

  dots: false,

  responsive: {

    0: {

      items: 1

    },

    768: {

      items: 2

    },

    1030: {

      items: 3

    },



    1200: {

      items: 4

    }

  }

});

jQuery(".whyChoose_sldier").owlCarousel({

    loop:true,

    autoplay: true,

    rewind: false, /* use rewind if you don't want loop */

    margin: 20,

  responsiveClass: true,

  autoHeight: true,

  autoplayTimeout: 7000,

  smartSpeed: 800,

  nav: false,

  dots: true,

  responsive: {

    0: {

      items: 1

    },



    600: {

      items: 2

    },



    768: {

      items: 3

    },



    1200: {

      items: 4

    }

  }

});



jQuery(".app_slider").owlCarousel({

    loop:true,

    autoplay: true,

    rewind: false, /* use rewind if you don't want loop */

    margin: 20,

  responsiveClass: true,

  autoHeight: true,

  autoplayTimeout: 5000,

  smartSpeed: 800,

  nav: false,

  dots: true,

  responsive: {

    0: {

      items: 1

    },



    768: {

      items: 2

    },



    1024: {

      items: 3

    }

  }

});



jQuery(".testi_slider").owlCarousel({

    autoplay: true,

    stagePadding: 50,

    rewind: false, /* use rewind if you don't want loop */

    margin: 20,

    center:true,

    loop: true,

    rewindesponsiveClass: true,

    autoHeight: true,

    autoplayTimeout: 7000,

    smartSpeed: 800,

    nav: false,

    dots: true,

    responsive: {

        0: {

            items: 1

        },



        575: {

            items: 1

        },

        767: {

            items: 2

        },



        1024: {

            items: 2

        },



        1366: {

            items: 3

        }

    }

});



jQuery(".elivate_slider").owlCarousel({

    autoplay: true,

    stagePadding: 0,

    rewind: false, /* use rewind if you don't want loop */

    margin: 20,

    center:true,

    loop: true,

    rewindesponsiveClass: true,

    autoHeight: true,

    autoplayTimeout: 7000,

    smartSpeed: 800,

    nav: false,

    dots: true,

    responsive: {

        0: {

            items: 1

        },



        575: {

            items: 1

        },

        767: {

            items: 2

        },



        1024: {

            items: 2

        },



        1280: {

            items: 3

        }

    }

});



jQuery(".proficient_slider").owlCarousel({

    autoplay: false,

    stagePadding: 0,

    rewind: false, /* use rewind if you don't want loop */

    margin: 20,

    center:false,

    loop: true,

    rewindesponsiveClass: true,

    autoHeight: true,

    autoplayTimeout: 7000,

    smartSpeed: 800,

    nav: false,

    dots: true,

    responsive: {

        0: {

            items: 1

        },



        575: {

            items: 1

        },

        767: {

            items: 2

        },



        991: {

            items: 3

        },



        1280: {

            items: 4

        }

    }

});



jQuery(".screen_slider").owlCarousel({

    autoplay: false,

    stagePadding: 0,

    rewind: false,

    margin: 20,

    center:false,

    loop: true,

    rewindesponsiveClass: true,

    autoHeight: true,

    autoplayTimeout: 3000,

    smartSpeed: 800,

    nav: false,

    dots: true,

    responsive: {

        0: {

            items: 3

        },



        575: {

            items: 3

        },

        766: {

            items: 3

        },



        1280: {

            items: 5

        }

    }

});



var owl = $('.industries_slider');

owl.owlCarousel({

    autoplay: true,

    autoplayTimeout: 3000,

    loop:true,

    nav:true,

    margin:10,

    smartSpeed: 800,

    responsive:{

        0:{

            items:1

        },

        600:{

            items:2

        },            

        960:{

            items:3

        },

        1200:{

            items:4

        }

    }

});

owl.on('mousewheel', '.owl-stage', function (e) {

    if (e.deltaY>0) {

        owl.trigger('next.owl');

    } else {

        owl.trigger('prev.owl');

    }

    e.preventDefault();

});



//////////////// OWL SCRIPTS



//////////////// SLICK SCRIPTS



const slider = $(".bor_slider");

slider.slick({

    dots: false,

    nav:false,

    vertical: true,

    verticalSwiping: true,

  });

slider.on('wheel', (function(e) {

  e.preventDefault();



  if (e.originalEvent.deltaY < 0) {

    $(this).slick('slickNext');

  } else {

    $(this).slick('slickPrev');

  }

}));



$('.awards_slider').slick({

    dots: false,

    lazy: true,

    preloadImages: false,

    infinite: true,

    arrows: false,

    autoplay: true,

    autoplaySpeed: 0,

    speed: 5000,

    cssEase: 'linear',

    slidesToShow: 6,

    slidesToScroll: 1,

    responsive: [

        {

            breakpoint: 1030,

            settings: {

                slidesToShow: 5,

            }

        },

        {

            breakpoint: 768,

            settings: {

                slidesToShow: 4,

            }

        },

        {

            breakpoint: 576,

            settings: {

                slidesToShow: 3,

            }

        },
        {

            breakpoint: 490,

            settings: {

                slidesToShow: 2,

            }

        },

        

        

    ]

});



//////////////// SLICK SCRIPTS



