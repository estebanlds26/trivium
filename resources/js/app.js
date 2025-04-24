import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('welcomeApp', () => ({
    open: false,
    routes: {
        home: '',
        about: 'acerca-de',
        products: 'productos',
        login: 'iniciar-sesion',
        register: 'registrarse',
    },
    routesInverse: {
        '/': 'home',
        '/acerca-de': 'about',
        '/productos': 'products',
        '/iniciar-sesion': 'login',
        '/registrarse': 'register',
    },
    previousSection: null,
    scrollTop: 0,
    
    init() {
        this.previousSection = document.querySelector("#about.relevant-content");
        this.updateFigure();
        window.addEventListener("resize", this.updateFigure);
        this.$nextTick(() => {
            let section= window.location.pathname;
            let link=`.link#${this.routesInverse[section]}-link`
            document.querySelector(link).click();
        });
        
    },
    toggle() {
        this.open = !this.open;
    },
    handleScroll(content, background) {
        this.scrollTop = content.scrollTop;
        background.style.filter = `blur(${this.scrollTop / 74}px)`;
        this.updateFigure();
        if (this.scrollTop > 230) {
            if (document.querySelector(".link.active")?.id === "home-link") {
                document.querySelector(".link.active").classList.remove("active");
                document.querySelector(`.link#${this.previousSection.id}-link`).classList.add("active");
                document.querySelector(".relevant-content.active")?.classList.remove("active");
                this.previousSection.classList.add("active");
                history.pushState({ page: 1 }, "", `/${this.routes[this.previousSection.id]}`);
            }
        } else {
            this.previousSection = document.querySelector(".relevant-content.active") ?? this.previousSection;
            this.previousSection.classList.remove("active");
            document.querySelector(".link.active")?.classList.remove("active");
            document.querySelector(".link#home-link").classList.add("active");
            history.pushState({ page: 1 }, "", `/${this.routes["home"]}`);
        }
    },
    navigateToSection(link) {
        const section = document.querySelector(`#${link.id.replace("-link", "")}`);
        document.querySelector(".relevant-content.active")?.classList.remove("active");
        document.querySelector(".link.active").classList.remove("active");
        link.classList.add("active");
        section?.classList.add("active");
        if (section) section.scrollTop = 0;
        history.pushState({ page: 1 }, "", `/${this.routes[link.id.replace("-link", "")]}`);
        if (link.id === "home-link") {
            this.autoScrollHeaderBottom();
        } else {
            this.autoScrollHeaderTop();
            this.previousSection = section ?? this.previousSection;
        }
    },
    autoScrollHeaderTop() {
        document.querySelector(".relevant nav").scrollIntoView({ behavior: "smooth", block: "start" });
    },
    autoScrollHeaderBottom(mode) {
        const behavior = mode === "abrupt" ? "auto" : "smooth";
        document.querySelector(".relevant nav").scrollIntoView({ behavior, block: "end" });
    },
    updateFigure() {
        const e = document.querySelector(".content");
        const eScrollTopMax = e.scrollHeight - e.clientHeight;
        const bottom = document.querySelector(".bottom");
        const figureImg = document.querySelector(".content figure img");
        const figure = document.querySelector(".content figure");
        console.log(e.scrollTop, eScrollTopMax);
        if (eScrollTopMax - e.scrollTop < 1) {
            bottom.style.paddingTop = `${eScrollTopMax - e.scrollTop}px`;
            figureImg.style.width = `${85 + eScrollTopMax - e.scrollTop}px`;
            figure.style.paddingTop = eScrollTopMax - e.scrollTop < 5 ? `${5 - (eScrollTopMax - e.scrollTop)}px` : `0px`;
        } else {
            bottom.style.paddingTop = "75px";
            figureImg.style.width = "160px";
        }
    },
    
}));

Alpine.data('productos', () => ({
    slideshowIndex: 0,
    products: [
        {
            id: 0,
            name: "Irish Red Ale",
            image: "/images/welcome/TRIVIUM-25.jpg",
            description: `La Irish Red Ale es una joya en nuestro repertorio en
                        Trivium, una cerveza que tiene profundas raíces en la
                        tradición cervecera irlandesa. Cuando comenzamos
                        nuestra aventura en el mundo de la cerveza artesanal,
                        sabíamos que queríamos capturar la esencia y el
                        carácter únicos de este estilo clásico.

                        Nos enamoramos de la Irish Red Ale por su color rojizo
                        distintivo, que proviene de las maltas tostadas que
                        utilizamos en su elaboración. Estas maltas no solo le
                        dan su apariencia característica, sino que también
                        aportan sabores dulces y notas de caramelo que
                        complementan perfectamente el ligero amargor de
                        los lúpulos utilizados.

                        Cada lote de nuestra Irish Red Ale es una celebración
                        de la rica historia cervecera de Irlanda y de nuestra
                        pasión por la calidad y la artesanía. Es una cerveza que
                        nos conecta con las tradiciones mientras permitimos
                        que nuestro toque personal y creativo brille a través de
                        cada sorbo. Nos enorgullece compartir esta cerveza con
                        nuestros clientes, invitándolos a disfrutar de su
                        complejidad y carácter único, al tiempo que honramos
                        y celebramos la herencia cervecera que inspiró su
                        creación.`,
                price: 9000,
                images: [
                    "/images/welcome/TRIVIUM-25.jpg",
                    "/images/welcome/TRIVIUM-28.jpg",
                    "/images/welcome/TRIVIUM-25.jpg",
                    "/images/welcome/TRIVIUM-28.jpg",
                    "/images/welcome/TRIVIUM-25.jpg",
                    "/images/welcome/TRIVIUM-28.jpg",
                    "/images/welcome/TRIVIUM-25.jpg",
                    "/images/welcome/TRIVIUM-28.jpg",
                    "/images/welcome/TRIVIUM-25.jpg",
                    "/images/welcome/TRIVIUM-28.jpg",
                    "/images/welcome/TRIVIUM-25.jpg",
                    "/images/welcome/TRIVIUM-28.jpg",
                    "/images/welcome/TRIVIUM-25.jpg",
                    "/images/welcome/TRIVIUM-28.jpg",
                ],
        }
    ],
    showProductDetail: false,
    productDetail: null,
    intervalThumbnails: null,
    intervalScroll: null,
    closeProductDetail(){
        this.showProductDetail = false;
        this.productDetail = null;
    },
    setProductDetail(producto){
        this.productDetail = producto;
        this.showProductDetail= true;
    },
    nextSlideshowImage() {
        this.slideshowIndex = (this.slideshowIndex + 1) % this.productDetail.images.length;
        this.updateSlideshow();
    },
    prevSlideshowImage() {
        this.slideshowIndex = (this.slideshowIndex - 1 + this.productDetail.images.length) % this.productDetail.images.length;
        this.updateSlideshow();
    },
    appearControls(){
        const controls = document.querySelector(".controls");
        const scrollRightControls= document.querySelector(".scroll-right-controls")
        const scrollLeftControls= document.querySelector(".scroll-left-controls")
        clearTimeout(this.intervalThumbnails)
        controls.classList.add("visible")
        scrollRightControls.classList.add("visible")
        scrollLeftControls.classList.add("visible")
        this.intervalThumbnails= setTimeout(function(){
            controls.classList.remove("visible")
            scrollRightControls.classList.remove("visible")
            scrollLeftControls.classList.remove("visible")
        }, 984)
    },
    scrollLeft () {
        clearInterval(this.intervalScroll)
        this.intervalScroll= setInterval(function(){
            controls.scrollLeft-= 1
            this.appearControls()

        }, 2)
    },
    scrollRight () {
        clearInterval(this.intervalScroll)
        this.intervalScroll= setInterval(function(){
            controls.scrollLeft+= 1
            this.appearControls()
        }, 2)
    },
    updateSlideshow(index) {
        const slideshowContainer = document.querySelector(".slideshow-container");
        
        const slideshowImgs = slideshowContainer.querySelectorAll(".slideshow img");
        const thumbnails = Array.from(document.querySelectorAll(".controls img"));
        
        
        if(typeof index != "undefined"){
            this.slideshowIndex = index;
            this.appearControls()
        }
        slideshowContainer.setAttribute("data-index", this.slideshowIndex);
        slideshowImgs[this.slideshowIndex].scrollIntoView({ behavior: "smooth", inline: "center" });
        document.querySelector(".controls .active").classList.remove("active");
        thumbnails[this.slideshowIndex].classList.add("active");
        thumbnails[this.slideshowIndex].scrollIntoView({ behavior: "smooth", inline: "center" });

        this.appearControls()
    }

}))
Alpine.data('dashboardApp', () => ({
    section: 'home',
    openProfileLink: false,

    routes: {
        home: '',
        store: 'tienda',
        contact: 'contacto',
        settings: 'ajustes',
        help: 'ayuda',
    },
    routesInverse: {
        '/': 'home',
        '/tienda': 'store',
        '/contacto': 'contact',
        '/ajustes': 'settings',
        '/ayuda': 'help',
    },
    init(){
        this.$nextTick(() => {
            let section= window.location.pathname;
            let link=`.link#${this.routesInverse[section]}-link`
            document.querySelector(link).click();
        });
    },
    triggerProfileLink(target){
        if(target.closest(".profile")!= null)return
        this.openProfileLink = !this.openProfileLink;
    },
    closeProfileLink(target){
        if(target.closest(".profile")!= null)return
        this.openProfileLink = false;
    },
    navigateToSection(target) {
        let link= target.closest(".link")
        this.section = link.id.replace("-link", "");
        console.log(this.section, document.querySelector(`.link.active`), link);
        document.querySelector(".link.active").classList.remove("active");
        link.classList.add("active");
        history.pushState({ page: 1 }, "", `/${this.routes[this.section]}`);
    },
}))
Alpine.data('producto', () => ({
    quantity: 0
}))

//Accordion which only one item can be open at a time
Alpine.data('accordionItem', () => ({
    open: false,
    toggle() {
        this.open = !this.open;
        if (this.open) {
            this.$dispatch('accordion:open', { item: this });
        } else {
            this.$dispatch('accordion:close', { item: this });
        }
    },
}))
Alpine.data('accordion', () => ({
    openItem: null,
    toggleItem(index){
        this.openItem= this.openItem== index? null: index;
    },
    isOpen(index) {
        return this.openItem == index;
    }
}))
Alpine.start();
