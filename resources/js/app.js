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
    routesInverse: {},
    section: 'home',
    previousSection: "about",
    scrollTop: 0,

    init() {
        this.routesInverse = Object.fromEntries(
            Object.entries(this.routes).map(([key, value]) => [`/${value}`, key])
        );


        console.log(this.routesInverse)
        this.updateFigure();
        window.addEventListener("resize", this.updateFigure);
        this.$nextTick(() => {
            this.section = this.routesInverse[window.location.pathname];
            this.setSection(this.section)
        });

    },
    toggle() {
        this.open = !this.open;
    },
    handleScroll() {
        this.scrollTop = this.$refs.content.scrollTop;
        this.$refs.background.style.filter = `blur(${this.scrollTop / 74}px)`;
        this.updateFigure();
        if (this.scrollTop > 230) {

            this.$nextTick(() => {
                if (this.section == "home") {
                    this.setSection(this.previousSection, "no-auto-scroll")
                }
            })
        } else {
            this.setSection("home", "no-auto-scroll")
        }
    },
    handleInnerScroll(element) {
        if (this.$refs.content.scrollTop == 0) return
        this.autoScrollHeaderTop();
    },
    setSection(section, mode) {
        this.previousSection = this.section == "home" ? this.previousSection : this.section;
        this.section = section;
        this.$nextTick(() => {
            history.pushState({ page: 1 }, "", `/${this.routes[section]?? ''}`);
        })
        if (typeof mode != "undefined" && mode == "no-auto-scroll") return
        section == "home" ?
            this.autoScrollHeaderBottom() :
            this.autoScrollHeaderTop();
    },
    autoScrollHeaderTop() {
        document.querySelector(".relevant nav").scrollIntoView({ behavior: "smooth", block: "start" });
    },
    autoScrollHeaderBottom(mode) {
        const behavior = mode === "abrupt" ? "auto" : "smooth";
        document.querySelector(".relevant nav").scrollIntoView({ behavior, block: "end" });
    },
    updateFigure() {
        const e = this.$refs.content;
        const eScrollTopMax = e.scrollHeight - e.clientHeight;
        const bottom = document.querySelector(".bottom");
        const figureImg = document.querySelector(".content figure img");
        const figure = document.querySelector(".content figure");
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
    products: null,
    init() {
        this.fetchProducts();
    },
    fetchProducts() {
        fetch('http://localhost:8000/api/producto')
            .then(response => response.json())
            .then(data => {
                this.products = data.data
            })
            .catch(error => console.error('Error fetching products:', error));
    },
  
    
    

}))
Alpine.data('produccion', () => ({
    procesos: [],

    async init() {
        await this.loadProducciones();
        document.querySelector(".step.active")?.scrollIntoView({ behavior: "smooth", inline: "center", block: "center" });
    },
    async loadProducciones(){
        const response = await fetch(`http://localhost:8000/api/produccion`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                this.procesos = data.data.map((item, procesoIdx) => {
                    const productionSteps = Array.isArray(item.proceso_steps_copy)
                        ? item.proceso_steps_copy.map((step, stepIdx) => {
                            if (step.type === 'time' && typeof step.duration !== 'undefined' && step.duration !== null) {
                                step.milliseconds = step.duration * 60000;
                            }
                            // Start timer if step is time and has a startTime
                            if (step.type === 'time' && step.startTime) {
                                    this.restartTimer(step, procesoIdx, stepIdx);
                            }
                            return step;
                        })
                        : item.proceso_steps_copy;
                    return {
                        productionSteps,
                        procesoId: item.id,
                        procesoName: "",
                        activeStep: item.active_step,
                        estado: item.estado
                    };
                }).filter(proceso=> proceso.estado != "Completado");
            })
            .catch(error => console.error('Error:', error));
        console.log(this.procesos)
    },
    async updateStepsProduccion(proceso) {
        if (!proceso) {
            console.error('Se necesita un proceso para actualizarlo.');
            return;
        }
        // Send PUT request to backend to update proceso_steps_copy
        try {
            const response = await fetch(`http://localhost:8000/api/produccion/${proceso.procesoId}/steps`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ proceso_steps_copy: proceso.productionSteps }),
            });
            const data = await response.json();
            if (!data.success) {
                console.error('Error updating proceso_steps_copy:', data);
            } else {
            }
        } catch (error) {
            console.error('Error in updateStepsProduccion:', error);
        }
    },
    async updateStatusProduccion(proceso) {
        if (!proceso) {
            console.error('Se necesita un proceso para actualizar su estado.');
            return;
        }
        try {
            const response = await fetch(`http://localhost:8000/api/produccion/${proceso.procesoId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ estado: proceso.estado }),
            });
            const data = await response.json();
            if (!data.success) {
                console.error('Error updating status:', data);
            } else {
            }
        } catch (error) {
            console.error('Error in updateStatusProduccion:', error);
        }
    },
    async updateActiveStepProduccion(proceso) {
        if (!proceso) {
            console.error('Se necesita un proceso para actualizar active_step.');
            return;
        }
        try {
            const response = await fetch(`http://localhost:8000/api/produccion/${proceso.procesoId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ active_step: proceso.activeStep }),
            });
            const data = await response.json();
            if (!data.success) {
                console.error('Error updating active_step:', data);
            } else {
            }
        } catch (error) {
            console.error('Error in updateActiveStepProduccion:', error);
        }
    },
    tituloProceso(proceso){
        if(proceso.activeStep == 0){
            if(proceso.starting){
                return "Iniciando..."
            }
            return "Sin iniciar"
        }
        if(proceso.estado == "Completado"){
            return "Completado"
        }
        return proceso.productionSteps[proceso.activeStep].text 
    },
    async continuar(nextStep, target, step, process) {
        if(nextStep == this.procesos[process].productionSteps.length){
            this.procesos[process].estado= "Completado"
            await this.updateStatusProduccion(this.procesos[process])
            return
        }
        if(nextStep == 1){
            this.procesos[process].estado= "En proceso"
            this.procesos[process].starting= true
            await this.updateStatusProduccion(this.procesos[process])

        }
        switch (step.type) {
            case "checklist":
                if (this.todoChuleado(step)) {
                    this.procesos[process].activeStep = nextStep;
                    target
                        .parentElement
                        .parentElement
                        .parentElement
                        .nextElementSibling
                        .scrollIntoView({ behavior: "smooth", inline: "center", block: "center" });
                }
                break;
            case "simple":
                this.procesos[process].activeStep = nextStep;
                target
                    .parentElement
                    .parentElement
                    .parentElement
                    .nextElementSibling
                    .scrollIntoView({ behavior: "smooth", inline: "center", block: "center" });
                break;
            case "time":
                if (step.milliseconds <= 0) {
                    this.procesos[process].activeStep = nextStep;
                    target
                        .parentElement
                        .parentElement
                        .parentElement
                        .nextElementSibling
                        .scrollIntoView({ behavior: "smooth", inline: "center", block: "center" });
                }
                break;
        }
        this.updateStepsProduccion(this.procesos[process]);
        this.updateActiveStepProduccion(this.procesos[process]);
    },
    todoChuleado(step) {
        let todosChuleados = true;
        step.items.forEach((item) => {
            if (item[1] == false) {
                todosChuleados = false;
            }
        });
        return todosChuleados;
    },
    formatTime(milliseconds) {
        const pad = (num) => String(num).padStart(2, '0');
        const seconds = pad(Math.floor((milliseconds / 1000) % 60));
        const minutes = pad(Math.floor((milliseconds / (1000 * 60)) % 60));
        const hours = pad(Math.floor((milliseconds / (1000 * 60 * 60)) % 24));
        const days = pad(Math.floor(milliseconds / (1000 * 60 * 60 * 24)));
        return `${days}:${hours}:${minutes}:${seconds}`;
    },
    startTimer(step, indexProceso) {
        if (!step.startTime) {
            step.startTime = Date.now();
            step.endTime = step.startTime + step.milliseconds;
            let timer = setInterval(() => {
                const remainingTime = step.endTime - Date.now();
                step.milliseconds = remainingTime > 0 ? remainingTime : 0;
                if (step.milliseconds <= 0) {
                    step.milliseconds = 0;
                    clearInterval(timer);
                }
            }, 1000);
        }
        console.log(indexProceso)
        this.updateStepsProduccion(this.procesos[indexProceso]);
    },
    restartTimer(step, indexProceso, stepIdx) {
        // Always update the step inside the Alpine data array for reactivity
        let timer = setInterval(() => {
            const realStep = this.procesos[indexProceso]?.productionSteps?.[stepIdx];
            console.log(stepIdx)
            if (!realStep) return clearInterval(timer);
            const remainingTime = realStep.endTime - Date.now();
            realStep.milliseconds = remainingTime > 0 ? remainingTime : 0;
            if (realStep.milliseconds <= 0) {
                realStep.milliseconds = 0;
                clearInterval(timer);
            }
        }, 1000);
    },
}))
Alpine.data('dashboardApp', () => ({
    section: 'home',
    openProfileLink: false,
    routes: {
        home: '',
        production: 'produccion',
        store: 'tienda',
        contact: 'contacto',
        settings: 'ajustes',
        help: 'ayuda',
        inventory: 'inventario',
    },
    routesInverse: {},
    init() {
        this.routesInverse = Object.fromEntries(
            Object.entries(this.routes).map(([key, value]) => [`/${value}`, key])
        );

        this.$nextTick(() => {
            let section = window.location.pathname;
            let link = `.link#${this.routesInverse[section]}-link`
            document.querySelector(link).click();
        });
    },

    triggerProfileLink(target) {
        if (target.closest(".profile") != null) return
        this.openProfileLink = !this.openProfileLink;
    },
    closeProfileLink() {
        this.openProfileLink = false;
    },
    navigateToSection(target) {
        let link = target.closest(".link")
        this.section = link.id.replace("-link", "");
        document.querySelector(".link.active").classList.remove("active");
        link.classList.add("active");
        history.pushState({ page: 1 }, "", `/${this.routes[this.section]}${window.location.hash}`);
    },
    plural(palabra, cantidad) {
    // Si sólo hay uno, devuelve la palabra en singular
    if(cantidad== 1){
        return palabra
    }
    // Si termina en vocal no acentuada, agrega 's'
    if (/[aeiou]$/.test(palabra)) {
        return palabra + 's';
    }
    // Si termina en 'z', cambia 'z' por 'ces'
    if (/z$/.test(palabra)) {
        return palabra.replace(/z$/, 'ces');
    }
    // Si termina en consonante (excepto z), agrega 'es'
    if (/[bcdfghjklmnñpqrstvwxyz]$/.test(palabra)) {
        return palabra + 'es';
    }
    // Si termina en vocal acentuada o 'y', agrega 'es'
    if (/[áéíóúý]$/.test(palabra)) {
        return palabra + 'es';
    }
    // Por defecto, agrega 's'
    return palabra + 's';
},
formatDate(date){
    const options = { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit' };
    return new Date(date).toLocaleDateString('es-ES', options).replace(',', '');
},
formatPrice(price){
    return new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 0
    }).format(price);
}
}))
Alpine.data('producto', () => ({
    quantity: 0,
    producto: null,
    productIndex: null,
    slideshowIndex: 0,

    intervalThumbnails: null,
    intervalScroll: null,

    // ...existing code...
showImageModal: false,
modalImageUrl: null,
modalImageIndex: 0,

openImageModal(url, index = 0) {
    this.modalImageUrl = url;
    this.modalImageIndex = index;
    this.showImageModal = true;
},
closeImageModal() {
    this.showImageModal = false;
    this.modalImageUrl = null;
},
nextModalImage() {
    if (!this.producto || !this.producto.imagenes) return;
    this.modalImageIndex = (this.modalImageIndex + 1) % this.producto.imagenes.length;
    this.modalImageUrl = `/storage/${this.producto.imagenes[this.modalImageIndex]}`;
},
prevModalImage() {
    if (!this.producto || !this.producto.imagenes) return;
    this.modalImageIndex = (this.modalImageIndex - 1 + this.producto.imagenes.length) % this.producto.imagenes.length;
    this.modalImageUrl = `/storage/${this.producto.imagenes[this.modalImageIndex]}`;
},

nextSlideshowImage() {
        this.slideshowIndex = (this.slideshowIndex + 1) % this.producto.imagenes.length;
        this.updateSlideshow();
    },
    prevSlideshowImage() {
        this.slideshowIndex = (this.slideshowIndex - 1 + this.producto.imagenes.length) % this.producto.imagenes.length;
        this.updateSlideshow();
    },
appearControls() {
        const controls = this.$refs["controls"];
        const scrollRightControls = this.$refs["scroll-right-controls"];
        const scrollLeftControls = this.$refs["scroll-left-controls"];
        clearTimeout(this.intervalThumbnails)
        controls.classList.add("visible")
        scrollRightControls.classList.add("visible")
        scrollLeftControls.classList.add("visible")
        this.intervalThumbnails = setTimeout(function () {
            controls.classList.remove("visible")
            scrollRightControls.classList.remove("visible")
            scrollLeftControls.classList.remove("visible")
        }, 984)
    },
    scrollLeft() {
        const controls = this.$refs["controls"];
        clearInterval(this.intervalScroll);
        this.intervalScroll = setInterval(() => {
            controls.scrollLeft -= 1;
            this.appearControls();
        }, 2);
    },
    scrollRight() {
        const controls = this.$refs["controls"];
        clearInterval(this.intervalScroll);
        this.intervalScroll = setInterval(() => {
            controls.scrollLeft += 1;
            this.appearControls();
        }, 2);
    },
    updateSlideshow(index) {
        const slideshowContainer = this.$refs["slideshow-container"];
        const controls = this.$refs["controls"];

        const slideshowImgs = slideshowContainer.querySelectorAll(".slideshow img");
        const thumbnails = Array.from(controls.querySelectorAll("img"));


        if (typeof index != "undefined") {
            this.slideshowIndex = index;
            this.appearControls()
        }
        slideshowContainer.setAttribute("data-index", this.slideshowIndex);
        slideshowImgs[this.slideshowIndex].scrollIntoView({ behavior: "smooth", inline: "center", block: "center" });
        controls.querySelector(".active").classList.remove("active");
        thumbnails[this.slideshowIndex].classList.add("active");
        thumbnails[this.slideshowIndex].scrollIntoView({ behavior: "smooth", inline: "center", block: "center" });

        this.appearControls()
    }
}))

Alpine.data('accordion', () => ({
    openItem: null,
    toggleItem(index) {
        this.openItem = this.openItem == index ? null : index;
    },
    isOpen(index) {
        return this.openItem == index;
    }
}))
Alpine.data('managementData', () => ({
    defaultSection: 'productos',
    section: '',
    nextAction: null,
    sections: {
        'productos': {
            api: 'producto',
            subsection: 'index',
            pluralName: 'productos',
            singularName: 'producto',
            rows: null,
            details: {},
            availableProducts: null,
            photos: []
        },
        'ventas': {
            api: 'pedido',
            subsection: 'index',
            pluralName: 'ventas',
            singularName: 'venta',
            rows: null,
            details: {},
            selectedProducts: [],
            productQuantities: {},
        },
        'producciones': {
            api: 'produccion',
            subsection: 'index',
            pluralName: 'producciones',
            singularName: 'producción',
            rows: null,
            details: {},
            selectedInsumos: [],
        },
        'procesos': {
            api: 'proceso',
            subsection: 'index',
            pluralName: 'procesos',
            singularName: 'proceso',
            rows: null,
            details: {},
            selectedInsumos: [],
            steps: [],
        },
        'insumos': {
            api: 'insumo',
            subsection: 'index',
            pluralName: 'insumos',
            singularName: 'insumo',
            rows: null,
            details: {},
        },
        'entradas': {
            api: 'entrada-de-material',
            subsection: 'index',
            pluralName: 'entradas',
            singularName: 'entrada',
            rows: null,
            details: {},
        },
    },
    init() {
        this.reverseUrlForSection();
        this.$watch('section', (value) => {
            this.load(value);
        });
    },
    normalize(text){
        return text.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    },
    async reverseUrlForSection(){
        const url= window.location.hash.replace("#", "");
        const urlSections= url.split("/");
        console.log(this.section, this.defaultSection, urlSections)
        if(urlSections.length <= 1){
            if(urlSections[0])
            {
                this.section = urlSections[0];
            }else{
                this.section = this.defaultSection
                this.$nextTick(()=>{
                    this.setUrl("index")
                });
            }
        }
        else{
            let sectionObj = Object.values(this.sections).find(item => this.normalize(item.singularName) == this.normalize(urlSections[0]));
            if (sectionObj) {
                this.section = this.normalize(sectionObj.pluralName);
            }
        }
        
        if(this.sections[this.section].rows == null){
            await this.load(this.section);
        }

        if(urlSections.length <= 1){
            this.sections[this.section].subsection = "index";
            return;
        }
        const section = urlSections[0].replace("#", "");
        if(urlSections.length == 2){
            this.add();
            return            
        }
        if(urlSections.length == 3){
            switch(urlSections[1]){
                case "editar":
                    this.edit(this.sections[this.section]
                                .rows
                                .find(item => item.id == urlSections[2]));
                    return;
                case "ver":
                    this.view(this.sections[this.section]
                                .rows
                                .find(item => item.id == urlSections[2]));
                    return;
            }
        }
    },
    setUrl(zone, id){
        if(typeof id === "undefined"){
            if(zone == "create"){
                window.location.hash= `${this.normalize(this.sections[this.section].singularName)}/crear`
                return
            }
            window.location.hash= `${this.section}`
            return
        }
        window.location.hash= `${this.normalize(this.sections[this.section].singularName)}/${zone}/${id}`
    },
    async load(section) {
        this.sections[section].rows = null;
        const response = await fetch(`http://localhost:8000/api/${this.sections[section].api}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                this.sections[section].rows = data.data
            })
            .catch(error => console.error('Error:', error));
        if (section == 'ventas') {
            this.sections['ventas'].availableProducts = null;
            const response = await fetch(`http://localhost:8000/api/producto`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    this.sections['ventas'].availableProducts = data.data
                })
                .catch(error => console.error('Error:', error));
        }
        if (section == 'producciones') {
            this.sections.productos.rows = null;
            const response = await fetch(`http://localhost:8000/api/producto`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    this.sections.productos.rows = data.data
                })
                .catch(error => console.error('Error:', error));
            this.sections.insumos.rows = null;
            const response2 = await fetch(`http://localhost:8000/api/insumo`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    this.sections.insumos.rows = data.data
                })
                .catch(error => console.error('Error:', error));
            this.sections.procesos.rows = null;
            const response3 = await fetch(`http://localhost:8000/api/proceso`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    this.sections.procesos.rows = data.data
                })
                .catch(error => console.error('Error:', error));
                
            }
        if (section == 'procesos') {
            this.sections.insumos.rows = null;
            const response3 = await fetch(`http://localhost:8000/api/insumo`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    this.sections.insumos.rows = data.data
                })
                .catch(error => console.error('Error:', error));
                
            }
            if(section== 'entradas'){
                this.sections.insumos.rows = null;
                const response3 = await fetch(`http://localhost:8000/api/insumo`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        this.sections.insumos.rows = data.data
                    })
                    .catch(error => console.error('Error:', error));
            }
    },
    setSection(section) {
        this.section = section;
        switch (this.sections[this.section].subsection) {
            case "index":
                this.setUrl("index");
                break;
            case "create":
                this.setUrl("create")
                break;
            case "edit":
                this.setUrl("editar", this.sections[this.section].details.id);
                break;
            case "view":
                this.setUrl("ver", this.sections[this.section].details.id);
                break;
        }
    },
    getListQuantitiesProducts(items) {
        let list = []
        items.forEach((item) => {
            list.push(`${item.nombre} (${item.pivot.cantidad})`)
        });
        return list.join("  |  ");
    },
    getListQuantitiesInsumos(items) {
        let list = []
        items.forEach((item) => {
            list.push(`${item.nombre} (${item.pivot.cantidad_usada} ${this.capitalize(this.plural(item.unidad, item.pivot.cantidad_usada))})`)
        });
        return list.join("  |  ");
    },
    getListQuantitiesProcesoInsumos(items) {
        return items.map(item => {
            let insumo = this.sections.insumos.rows?.find(i => i.id == item.insumo_id);
            let nombre = insumo ? insumo.nombre : `Insumo ${item.insumo_id}`;
            return `${nombre} (${item.quantity} ${this.capitalize(this.plural(insumo.unidad, item.quantity7))})`;
        }).join("  |  ");
    },
    countProcesoSteps(steps) {
        return steps.length;
    },
    getTotalProducts(items) {
        let total = 0
        items.forEach((item) => {
            total += item.pivot.importe
        });
        return total;
    },
    getTotalInsumos(items) {
        let total = 0
    },
    getTotalInsumos(items) {
        let total = 0
        items.forEach((item) => {
            total += item.pivot.precio_unitario * item.pivot.cantidad_usada
        });
        return total;
    },
    capitalize(text) {
        return text.charAt(0).toUpperCase() + text.slice(1);
    },
    countProductions(items) {
        let count = 0;
        items.forEach((item) => {
            count += 1
        });
        return count;
    },
    countQuantityProductions(items) {
        let count = 0;
        items.forEach((item) => {
            count += item.cantidad
        });
        return count;
    },
    countSales(items) {
        let count = 0;
        items.forEach((item) => {
            count += 1
        });
        return count;
    },
    countQuantitySales(items) {
        let count = 0;
        items.forEach((item) => {
            count += item.pivot.cantidad
        });
        return count;
    },
    sumInsumos(insumos) {
        let sum = 0
        insumos.forEach(insumo => {
            sum += insumo.pivot.cantidad_usada
        })
        return sum;
    },
    setDate(date, el) {
        switch (date) {
            case "today":
                let today = new Date().toISOString();
                el.value = today;
                break;
        }
    },
    addAvailable(section) {
        return ["productos"].includes(section);
    },
    addInsumo() {
        this.sections.producciones.selectedInsumos.push({ insumo_id: '', cantidad_usada: 1 });
    },
    removeInsumo(index) {
        this.sections.producciones.selectedInsumos.splice(index, 1);
    },
    handleFileUpload(event) {
        const files = event.target.files;
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            this.sections.productos.photos.push({
                url: URL.createObjectURL(file),
                file: file
            });
        }
    },
    formatTime(milliseconds) {
        const pad = (num) => String(num).padStart(2, '0');
        const seconds = pad(Math.floor((milliseconds / 1000) % 60));
        const minutes = pad(Math.floor((milliseconds / (1000 * 60)) % 60));
        const hours = pad(Math.floor((milliseconds / (1000 * 60 * 60)) % 24));
        const days = pad(Math.floor(milliseconds / (1000 * 60 * 60 * 24)));
        return `${days}:${hours}:${minutes}:${seconds}`;
    },
    removePhoto(index) {
        this.sections.productos.photos.splice(index, 1);
    },
    dragIndex: null,
    reorder(from, to) {
        if (from === to) return;
        const photos = this.sections.productos.photos;
        const moved = photos.splice(from, 1)[0];
        photos.splice(to, 0, moved);
        // Force Alpine to detect the change
        this.sections.productos.photos = photos.slice();
    },
    edit(item) {
        this.sections[this.section].subsection = "edit";
        this.sections[this.section].details = item;
        if (this.section === 'producciones') {
            if (item.insumos && Array.isArray(item.insumos)) {
                this.sections.producciones.selectedInsumos = item.insumos.map(insumo => ({
                    insumo_id: insumo.id,
                    cantidad_usada: insumo.pivot.cantidad_usada
                }));
            } else {
                this.sections.producciones.selectedInsumos = [];
            }
        }
        if (this.section === 'procesos') {
            let stepsArr = [];
            if (Array.isArray(item.steps)) {
                stepsArr = item.steps;
            } else if (typeof item.steps === 'string') {
                try {
                    stepsArr = JSON.parse(item.steps);
                } catch (e) {
                    stepsArr = [];
                }
            }
            this.sections.procesos.steps = stepsArr.map(step => {
                let s = { ...step };
                if (s.type === 'checklist' && Array.isArray(s.items)) {
                    s.items = s.items.map(i => Array.isArray(i) ? i[0] : i).join(', ');
                }
                if (s.type === 'time') {
                    if (typeof s.duration !== 'undefined' && s.duration !== null) {
                        // Use duration if present
                        s.duration = parseInt(s.duration);
                    } else if (typeof s.milliseconds !== 'undefined' && s.milliseconds !== null) {
                        // Convert milliseconds to minutes
                        s.duration = Math.round(s.milliseconds / 60000);
                    } else {
                        s.duration = 0;
                    }
                }
                return s;
            });
            // Load insumos for editing
            let insumosArr = [];
            if (Array.isArray(item.insumos)) {
                insumosArr = item.insumos;
            } else if (typeof item.insumos === 'string') {
                try {
                    insumosArr = JSON.parse(item.insumos);
                } catch (e) {
                    insumosArr = [];
                }
            }
            this.sections.procesos.selectedInsumos = insumosArr.map(i => ({
                insumo_id: i.insumo_id,
                quantity: i.quantity
            }));
        }
        // Robustly handle both array and stringified JSON
        let imagesArr = [];
        if (Array.isArray(item.imagenes)) {
            imagesArr = item.imagenes;
        } else if (typeof item.imagenes === 'string') {
            try {
                imagesArr = JSON.parse(item.imagenes);
            } catch (e) {
                imagesArr = [];
            }
        }
        this.sections.productos.photos = (imagesArr ? imagesArr : []).map(image => ({
            url: `/storage/${image}`,
            file: null
        }));
        this.setUrl("editar", item.id);

    },
    view(item) {
        this.sections[this.section].subsection = "view";
        this.sections[this.section].details = item
        this.setUrl("ver", item.id);
    },
    goBack() {
        this.sections[this.section].subsection = "index";
        this.setUrl("index");

    },
    create() {
        this.sections.productos.photos = [];
        this.sections[this.section].subsection = "create";
        this.setUrl("create");
    },

    async update() {
        switch (this.section) {
            case "insumos":
                const id = this.sections.insumos.details.id;
                const nombre = this.$refs.nombreInsumoEdit.value;
                const unidad = this.$refs.unidadInsumoEdit.value;
                const marca = this.$refs.marcaInsumoEdit.value;
                const data = { nombre, unidad, marca };
                await fetch(`http://localhost:8000/api/insumo/${id}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    this.load('insumos');
                    this.goBack();
                })
                .catch(error => console.error('Error actualizando insumo:', error));
                break;
            case "productos":
                const formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('nombre', this.$refs.nombreProductoEdit.value);
                formData.append('precio', this.$refs.precioProductoEdit.value);
                formData.append('descripcion', this.$refs.descripcionProductoEdit.value);


                this.sections.productos.photos.forEach((photo) => {
                    if (photo.file) {
                        formData.append('imagenes[]', photo.file);
                    } else {
                        const relativePath = photo.url.replace(/^\/storage\//, '');
                        formData.append('existing[]', relativePath);
                    }
                });

                fetch(`http://localhost:8000/api/${this.sections[this.section].api}/${this.sections[this.section].details.id}`, {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Updated successfully:', data);
                        this.load(this.section);
                        this.goBack();
                    })
                    .catch(error => console.error('Error updating:', error));
                break;
            case "ventas":

                let estado = this.$refs.estadoPedidoEdit.value;
                let data1 = {
                    estado
                }
                fetch(`http://localhost:8000/api/${this.sections[this.section].api}/${this.sections[this.section].details.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data1),
                })
                    .then(response => response.json())
                    .then(updatedData => {
                        console.log('Updated successfully:', updatedData);
                        this.load(this.section);
                        this.goBack();
                    })
                    .catch(error => console.error('Error updating:', error));
                break;
            case "producciones":
                try {
                    let fechaProduccion = this.$refs.fechaProduccionEdit.value;
                    let cantidadProduccion = this.$refs.cantidadProduccionEdit.value;
                    let productoIdProduccion = this.$refs.productoProduccionEdit.value;
                    let insumosProduccion = this.sections.producciones.selectedInsumos;
                    let proceso_id = this.$refs.procesoProduccionEdit.value;
                    let estado= this.$refs.estadoProduccionEdit.value;
                    let produccionData = {
                        fecha: fechaProduccion,
                        cantidad: cantidadProduccion,
                        producto_id: productoIdProduccion,
                        user_id: 1,
                        proceso_id,
                        estado
                    };

                    // Update produccion main data
                    const response = await fetch(`http://localhost:8000/api/${this.sections[this.section].api}/${this.sections[this.section].details.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(produccionData),
                    });
                    const updatedData = await response.json();
                    if (!updatedData.success) {
                        console.error('Error actualizando producción:', updatedData);
                        return;
                    }
                    const produccionId = updatedData.data.id;

                    // Clear all insumos for this produccion
                    const clearRes = await fetch(`http://localhost:8000/api/produccion/${produccionId}/insumos/clear`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                    });
                    if (!clearRes.ok) {
                        console.error('Error clearing insumos:', await clearRes.text());
                        return;
                    }

                    // Add current insumos
                    for (const insumo of insumosProduccion) {
                        const addRes = await fetch(`http://localhost:8000/api/produccion/${produccionId}/insumos`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(insumo),
                        });
                        if (!addRes.ok) {
                            console.error('Error agregando insumo:', await addRes.text());
                        }
                    }

                    this.load(this.section);
                    this.goBack();
                } catch (error) {
                    console.error('Error en update produccion:', error);
                }
                break;
            case "entradas":
                try {
                    let fechaEntrada = this.$refs.fechaEntradaEdit.value;
                    let insumoEntrada = this.$refs.insumoEntradaEdit.value;
                    let cantidadEntrada = this.$refs.cantidadEntradaEdit.value;
                    let precioUnitario = this.$refs.precioUnitarioEntradaEdit.value;
                    let entradaData = {
                        fecha: fechaEntrada,
                        cantidad: cantidadEntrada,
                        insumo_id: insumoEntrada,
                        precio_unitario: precioUnitario
                    };

                    const response = await fetch(`http://localhost:8000/api/${this.sections[this.section].api}/${this.sections[this.section].details.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(entradaData),
                    });
                    const updatedData = await response.json();
                    if (!updatedData.success) {
                        console.error('Error actualizando entrada de material:', updatedData);
                        return;
                    }

                    this.load(this.section);
                    this.goBack();
                } catch (error) {
                    console.error('Error en update entrada de material:', error);
                }
                break;
        }
    },
    async add() {

        let fecha = "";
        switch (this.section) {
            case "insumos":
                const nombre = this.$refs.nombreInsumoCreate.value;
                const unidad = this.$refs.unidadInsumoCreate.value;
                const marca = this.$refs.marcaInsumoCreate.value;
                const data = { nombre, unidad, marca };
                await fetch('http://localhost:8000/api/insumo', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    this.load('insumos');
                    this.goBack();
                })
                .catch(error => console.error('Error creando insumo:', error));
                break;
            case "productos":
                const formData = new FormData();
                formData.append('nombre', this.$refs.nombreProductoCreate.value);
                formData.append('precio', this.$refs.precioProductoCreate.value);
                formData.append('descripcion', this.$refs.descripcionProductoCreate.value);

                this.sections.productos.photos.forEach((photo) => {
                    if (photo.file) {
                        formData.append('imagenes[]', photo.file);
                    }
                });

                fetch(`http://localhost:8000/api/${this.sections[this.section].api}`, {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Created successfully:', data);
                        this.load(this.section);
                        this.goBack();
                        this.sections.productos.photos = [];
                    })
                    .catch(error => console.error('Error creating:', error));
                break;
            case "ventas":
                fecha = this.$refs.fechaPedidoCreate.value;
                let estado = this.$refs.estadoPedidoCreate.value;
                let user_id = this.$refs.clientePedidoCreate.value;


                let productos = this.sections.ventas.selectedProducts.map(productId => {
                    return {
                        producto_id: productId,
                        cantidad: this.sections.ventas.productQuantities[productId],
                        importe: this.sections.ventas.productQuantities[productId] * this.sections['ventas'].availableProducts.find(p => p.id == productId).precio
                    };
                });


                fetch(`http://localhost:8000/api/${this.sections[this.section].api}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ fecha, estado, user_id })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {

                            let pedido_id = data.data.id;
                            productos.forEach(producto => {
                                fetch(`http://localhost:8000/api/pedido/${pedido_id}/productos`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify(producto)
                                })
                                    .then(response => response.json())
                                    .then(productData => {
                                        console.log('Producto agregado:', productData);
                                    })
                                    .catch(error => console.error('Error agregando producto:', error));
                            });

                            console.log('Pedido creado exitosamente:', data);
                            this.load(this.section);
                            this.goBack();
                        } else {
                            console.error('Error creando pedido:', data);
                        }
                    })
                    .catch(error => console.error('Error creando pedido:', error));
                break;
            case "producciones":
                fecha = this.$refs.fechaProduccionCreate.value;
                let cantidad = this.$refs.cantidadProduccionCreate.value;
                let producto_id = this.$refs.productoProduccionCreate.value;
                let insumos = this.sections.producciones.selectedInsumos;
                let proceso_id = this.$refs.procesoProduccionCreate.value;
                fetch(`http://localhost:8000/api/produccion`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ fecha, cantidad, producto_id, user_id: 1, proceso_id }),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const produccionId = data.data.id;


                            insumos.forEach(insumo => {
                                console.log(insumo)
                                window.insumos = insumo
                                fetch(`http://localhost:8000/api/produccion/${produccionId}/insumos`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                    },
                                    body: JSON.stringify(insumo),
                                })
                                    .then(response => response.json())
                                    .then(insumoData => {
                                        console.log('Insumo agregado:', insumoData);
                                    })
                                    .catch(error => console.error('Error agregando insumo:', error));
                            });

                            console.log('Producción creada exitosamente:', data);
                            this.load(this.section);
                            this.goBack();
                        } else {
                            console.error('Error creando producción:', data);
                        }
                    })
                    .catch(error => console.error('Error creando producción:', error));
                break;
                case "entradas":
                let fechaEntrada = this.$refs.fechaEntradaCreate.value;
                let insumoEntrada = this.$refs.insumoEntradaCreate.value;
                let precioUnitarioEntrada = this.$refs.precioUnitarioEntradaCreate.value;
                let cantidadE = this.$refs.cantidadEntradaCreate.value;
                fetch(`http://localhost:8000/api/entrada-de-material`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ fechaEntrada, cantidad: cantidadE, insumo_id: insumoEntrada, precio_unitario: precioUnitarioEntrada }),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.load(this.section);
                            this.goBack();
                        } else {
                            console.error('Error creando entrada de material:', data);
                        }
                    })
                    .catch(error => console.error('Error creando entrada de material:', error));
                break;
        }
    },
    destroy(id) {
        fetch(`http://localhost:8000/api/${this.sections[this.section].api}/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                console.log('Deleted successfully:', data);
                this.load(this.section);
            })
            .catch(error => console.error('Error deleting:', error));
    },
    async setProcesoInsumos() {
        // Only run if in produccion create or edit mode and proceso is selected
        if (this.section === 'producciones' && (this.sections[this.section].subsection === 'create' || this.sections[this.section].subsection === 'edit')) {
            const procesoId = this.sections[this.section].subsection === 'create'
                ? this.$refs.procesoProduccionCreate?.value
                : this.$refs.procesoProduccionEdit?.value;
            if (!procesoId) return;
            const proceso = this.sections.procesos.rows?.find(p => p.id == procesoId);
            if (proceso && proceso.insumos) {
                let insumosArr = Array.isArray(proceso.insumos) ? proceso.insumos : JSON.parse(proceso.insumos);
                this.sections.producciones.selectedInsumos = insumosArr.map(insumo => ({
                    insumo_id: insumo.insumo_id,
                    cantidad_usada: insumo.quantity
                }));
            } else {
                this.sections.producciones.selectedInsumos = [];
            }
        }
    },
    dragStepIndex: null,
    addStep() {
        this.sections.procesos.steps.push({
            text: '',
            type: 'simple',
            items: '', // for checklist
            duration: '', // for time
        });
    },
    removeStep(idx) {
        this.sections.procesos.steps.splice(idx, 1);
    },
    reorderStep(from, to) {
        if (from === to) return;
        const steps = this.sections.procesos.steps;
        const moved = steps.splice(from, 1)[0];
        steps.splice(to, 0, moved);
        this.sections.procesos.steps = steps.slice(); // force Alpine update
    },
    addProcesoInsumo() {
        this.sections.procesos.selectedInsumos.push({ insumo_id: '', quantity: 1 });
    },
    removeProcesoInsumo(index) {
        this.sections.procesos.selectedInsumos.splice(index, 1);
    },
    // Override addProceso for proceso creation with steps
    async addProceso() {
        const nombre = this.$refs.nombreProcesoCreate.value;
        const descripcion = this.$refs.descripcionProcesoCreate.value;
        const steps = this.sections.procesos.steps.map(step => {
            let s = { text: step.text, type: step.type };
            if (step.type === 'checklist') {
                s.items = step.items.split(',').map(i => [i.trim(), false]).filter(i => i[0]);
            }
            if (step.type === 'time') {
                // Save both duration (minutes) and milliseconds (for view/timer)
                s.duration = parseInt(step.duration) || 0;
                s.milliseconds = s.duration * 60000;
            }
            return s;
        });
        // Prepare insumos as JSON
        const insumos = this.sections.procesos.selectedInsumos.filter(i => i.insumo_id && i.quantity > 0);
        const data = { nombre, descripcion, steps, insumos };
        await fetch('http://localhost:8000/api/proceso', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            this.load('procesos');
            this.goBack();
            this.sections.procesos.steps = [];
            this.sections.procesos.selectedInsumos = [];
        })
        .catch(error => console.error('Error creating proceso:', error));
    },
    async updateProceso() {
        const id = this.sections.procesos.details.id;
        const nombre = this.$refs.nombreProcesoEdit.value;
        const descripcion = this.$refs.descripcionProcesoEdit.value;
        const steps = this.sections.procesos.steps.map(step => {
            let s = { text: step.text, type: step.type };
            if (step.type === 'checklist') {
                s.items = step.items.split(',').map(i => [i.trim(), false]).filter(i => i[0]);
            }
            if (step.type === 'time') {
                s.duration = parseInt(step.duration) || 0;
                s.milliseconds = s.duration * 60000;
            }
            return s;
        });
        // Prepare insumos as JSON
        const insumos = this.sections.procesos.selectedInsumos.filter(i => i.insumo_id && i.quantity > 0);
        const data = { nombre, descripcion, steps, insumos };
        await fetch(`http://localhost:8000/api/proceso/${id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            this.load('procesos');
            this.goBack();
            this.sections.procesos.steps = [];
            this.sections.procesos.selectedInsumos = [];
        })
        .catch(error => console.error('Error updating proceso:', error));
    },
    async destroyInsumo(id) {
        if (!confirm('¿Seguro que deseas eliminar este insumo?')) return;
        await fetch(`http://localhost:8000/api/insumo/${id}`, {
            method: 'DELETE',
        })
        .then(response => response.json())
        .then(data => {
            this.load('insumos');
        })
        .catch(error => console.error('Error eliminando insumo:', error));
    },
    viewInsumo(insumo) {
        this.sections.insumos.subsection = 'view';
        this.sections.insumos.details = insumo;
    },
    editInsumo(insumo) {
        this.sections.insumos.subsection = 'edit';
        this.sections.insumos.details = insumo;
    },
    createInsumo() {
        this.sections.insumos.subsection = 'create';
        this.sections.insumos.details = {};
    },
}))
Alpine.start();
