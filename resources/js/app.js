import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;


Alpine.data('elemento', () => ({
    open: false,
    
    toggle() {
        this.open = !this.open
    }
}))
Alpine.data('elemento1', () => ({    
}))

Alpine.start();

document.addEventListener("DOMContentLoaded", function(){
    //Efecto de desenfoque al hacer scroll
    
    const container = document.querySelector(".relevant");
    const content = document.querySelector(".content");
    const background = document.querySelector(".background");
    
    let routes = {
        'home': '',
        'about': 'acerca-de',
        'products': 'productos',
        'login': 'iniciar-sesion',
        'register': 'registrarse',
    };
    let routesInverse = {
        '/': 'home',
        '/acerca-de': 'about',
        '/productos': 'products',
        '/iniciar-sesion': 'login',
        '/registrarse': 'register',
    };
    
    let previousSection = document.querySelector("#about.relevant-content");
    
    content.addEventListener("scroll", () => {
        const scrollTop = content.scrollTop;
        background.style.filter = `blur(${scrollTop / 74}px)`;
        updateFigure();
        if (content.scrollTop > 230) {
            if (document.querySelector(".link.active")?.id == "home-link") {
                document.querySelector(".link.active").classList.remove("active");
                document.querySelector(`.link#${previousSection.id}-link`).classList.add("active");
                document.querySelector(".relevant-content.active")?.classList.remove("active");
                previousSection.classList.add("active");
                history.pushState({ page: 1 }, "", `/${routes[previousSection.id]}`);
            }
        } else {
            previousSection = document.querySelector(".relevant-content.active") ?? previousSection;
            previousSection.classList.remove("active");
            document.querySelector(".link.active")?.classList.remove("active");
            document.querySelector(".link#home-link").classList.add("active");
            history.pushState({ page: 1 }, "", `/${routes["home"]}`);
        }
    });
    
    //Links de navegación
    const links = document.querySelectorAll(".link");
    links.forEach(link => {
        link.addEventListener("click", function(ev) {
            ev.preventDefault();
            const section = document.querySelector(`#${this.id.replace("-link", "")}`);
            autoScrollHeaderTop();
            document.querySelector(".relevant-content.active")?.classList.remove("active");
            document.querySelector(".link.active").classList.remove("active");
            this.classList.add("active");
            section?.classList.add("active");
            if (section) section.scrollTop = 0;
            history.pushState({ page: 1 }, "", `/${routes[this.id.replace("-link", "")]}`);
            if (this.id == "home-link") {
                autoScrollHeaderBottom();
            } else {
                previousSection = section ?? previousSection;
            }  
        });  
    });
    
    if (!(window.location.pathname == "/" || window.location.pathname == "" || window.location.pathname == "/index.html")) {
        let section = window.location.pathname.replace(".html", "");
        document.querySelector(`.link#${routesInverse[section]}-link`).click();
    }
    //Auto scroll del contenido para mayor visibilidad
    function autoScrollHeaderTop() {
        container.querySelector("nav").scrollIntoView({ "behavior": "smooth", inline: "center", block: "start" }); 
    }
    function autoScrollHeaderBottom(mode) {
        if (typeof mode != "undefined") {
            if (mode == "abrupt") {
                container.querySelector("nav").scrollIntoView({ "behavior": "auto", inline: "center", block: "end" });
                return;
            }
        }
        container.querySelector("nav").scrollIntoView({ "behavior": "smooth", inline: "center", block: "end" }); 
    }
    
    if (["/", ""].includes(window.location.pathname)) autoScrollHeaderBottom("abrupt");
    
    document.querySelector(".relevant-content").addEventListener("scroll", function() {
        autoScrollHeaderTop();
    }); 

    let landingPages = {
        about: `<section class="bottom">...</section>`
    };

    function updateFigure() {
        let e = document.querySelector(".content");
        let eScrollTopMax = e.scrollHeight - e.clientHeight;
        if (eScrollTopMax - e.scrollTop < 75) {
            document.querySelector(".bottom").style.paddingTop = `${eScrollTopMax - e.scrollTop}px`;
            document.querySelector(".content figure img").style.width = `${85 + eScrollTopMax - e.scrollTop}px`;
            if (eScrollTopMax - e.scrollTop < 5) {
                document.querySelector(".content figure").style.paddingTop = `${5 - (eScrollTopMax - e.scrollTop)}px`;
            } else {
                document.querySelector(".content figure").style.paddingTop = `0px`;
            }
        } else {
            document.querySelector(".bottom").style.paddingTop = "75px";
            document.querySelector(".content figure img").style.width = "160px";
        }
    }

    window.addEventListener("resize", updateFigure);
    const productDetailClose = document.querySelector(".product-detail .close");
    const products = document.querySelector("#products");
    const productCards = document.querySelectorAll(".product");

    productDetailClose.addEventListener("click", () => {
        products.classList.remove("details");
    });
    productCards.forEach((card) => {
        card.addEventListener("click", () => {
            products.classList.add("details");
        });
    });

    const nextImage = document.querySelector(".next-image");
    const slideshowContainer = document.querySelector(".slideshow-container");
    const slideshowImages = slideshowContainer.querySelectorAll(".slideshow img");
    const controls = document.querySelector(".controls");
    const slideshowThumbnailImages = controls.querySelectorAll("img");
    const slideshowThumbnailsFiltered = Array.from(slideshowThumbnailImages);
    let intervalScroll = null;
    let intervalThumbnails = null;

    nextImage.addEventListener("mouseup", function () {
        let index = slideshowContainer.getAttribute("data-index");
        index++;
        if (index > slideshowImages.length - 1) {
            index = 0;
        }
        slideshowContainer.setAttribute("data-index", index);
        slideshowImages[index].scrollIntoView({ "behavior": "smooth", inline: "center" });
        controls.querySelector(".active").classList.remove("active");
        slideshowThumbnailImages[index].classList.add("active");
        slideshowThumbnailImages[index].scrollIntoView({ "behavior": "smooth", inline: "center" });

        clearTimeout(intervalThumbnails);
        controls.classList.add("visible");
        scrollRightControls.classList.add("visible");
        scrollLeftControls.classList.add("visible");
        intervalThumbnails = setTimeout(function() {
            controls.classList.remove("visible");
            scrollRightControls.classList.remove("visible");
            scrollLeftControls.classList.remove("visible");
        }, 523);
    });

    const prevImage = document.querySelector(".prev-image");
    prevImage.addEventListener("mouseup", function () {
        let index = slideshowContainer.getAttribute("data-index");
        index--;
        if (index < 0) {
            index = slideshowImages.length - 1;
        }
        slideshowContainer.setAttribute("data-index", index);
        slideshowImages[index].scrollIntoView({ "behavior": "smooth", inline: "center" });
        controls.querySelector(".active").classList.remove("active");
        slideshowThumbnailImages[index].classList.add("active");
        slideshowThumbnailImages[index].scrollIntoView({ "behavior": "smooth", inline: "center" });

        clearTimeout(intervalThumbnails);
        controls.classList.add("visible");
        scrollRightControls.classList.add("visible");
        scrollLeftControls.classList.add("visible");
        intervalThumbnails = setTimeout(function() {
            controls.classList.remove("visible");
            scrollRightControls.classList.remove("visible");
            scrollLeftControls.classList.remove("visible");
        }, 523);
    });

    slideshowThumbnailImages.forEach(im => {
        im.addEventListener("click", function(ev) {
            let index = Array.prototype.indexOf.call(ev.target.parentNode.children, ev.target);
            slideshowContainer.setAttribute("data-index", index);
            slideshowImages[index].scrollIntoView({ "behavior": "smooth", inline: "center" });
            controls.querySelector(".active").classList.remove("active");
            slideshowThumbnailImages[index].classList.add("active");
            slideshowThumbnailImages[index].scrollIntoView({ "behavior": "smooth", inline: "center" });

            clearTimeout(intervalThumbnails);
            controls.classList.add("visible");
            scrollRightControls.classList.add("visible");
            scrollLeftControls.classList.add("visible");
            intervalThumbnails = setTimeout(function() {
                controls.classList.remove("visible");
                scrollRightControls.classList.remove("visible");
                scrollLeftControls.classList.remove("visible");
            }, 984);
        });
    });

    const scrollRightControls = document.querySelector(".scroll-right-controls");
    const scrollLeftControls = document.querySelector(".scroll-left-controls");

    scrollLeftControls.addEventListener("mouseenter", function () {
        clearInterval(intervalScroll);
        intervalScroll = setInterval(function() {
            controls.scrollLeft -= 1;
            clearTimeout(intervalThumbnails);
            controls.classList.add("visible");
            scrollRightControls.classList.add("visible");
            scrollLeftControls.classList.add("visible");
            intervalThumbnails = setTimeout(function() {
                controls.classList.remove("visible");
                scrollRightControls.classList.remove("visible");
                scrollLeftControls.classList.remove("visible");
            }, 984);
        }, 2);
    });

    scrollRightControls.addEventListener("mouseenter", function () {
        clearInterval(intervalScroll);
        intervalScroll = setInterval(function() {
            controls.scrollLeft += 1;
            clearTimeout(intervalThumbnails);
            controls.classList.add("visible");
            scrollRightControls.classList.add("visible");
            scrollLeftControls.classList.add("visible");
            intervalThumbnails = setTimeout(function() {
                controls.classList.remove("visible");
                scrollRightControls.classList.remove("visible");
                scrollLeftControls.classList.remove("visible");
            }, 984);
        }, 2);
    });

    scrollLeftControls.addEventListener("mouseleave", function () {
        clearInterval(intervalScroll);
    });

    scrollRightControls.addEventListener("mouseleave", function () {
        clearInterval(intervalScroll);
    });

    slideshowContainer.addEventListener("mousemove", function() {
        clearTimeout(intervalThumbnails);
        controls.classList.add("visible");
        scrollRightControls.classList.add("visible");
        scrollLeftControls.classList.add("visible");
        intervalThumbnails = setTimeout(function() {
            controls.classList.remove("visible");
            scrollRightControls.classList.remove("visible");
            scrollLeftControls.classList.remove("visible");
        }, 984);
    });
});
