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
            this.section= this.routesInverse[window.location.pathname];
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
            
            this.$nextTick(()=>{
                if (this.section == "home") {
                    this.setSection(this.previousSection, "no-auto-scroll")
                }
            })
        } else {
            this.setSection("home", "no-auto-scroll")
        }
    },
    handleInnerScroll(element){
        console.log(element.scrollTop)
    },
    setSection(section, mode){
        this.previousSection= this.section == "home"? this.previousSection: this.section;
        this.section= section;
        this.$nextTick(()=>{
                history.pushState({ page: 1 }, "", `/${this.routes[section]??''}`);
        })
        if(typeof mode != "undefined" && mode == "no-auto-scroll") return
        section == "home"?
        this.autoScrollHeaderBottom():
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
    slideshowIndex: 0,
    products: null,
    showProductDetail: false,
    productDetail: null,
    intervalThumbnails: null,
    intervalScroll: null,
    init(){
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
    closeProductDetail() {
        this.showProductDetail = false;
        this.productDetail = null;
    },
    setProductDetail(producto) {
        this.productDetail = producto;
        this.showProductDetail = true;
    },
    nextSlideshowImage() {
        this.slideshowIndex = (this.slideshowIndex + 1) % this.productDetail.imagenes.length;
        this.updateSlideshow();
    },
    prevSlideshowImage() {
        this.slideshowIndex = (this.slideshowIndex - 1 + this.productDetail.imagenes.length) % this.productDetail.imagenes.length;
        this.updateSlideshow();
    },
    appearControls() {
        const controls = document.querySelector(".controls");
        const scrollRightControls = document.querySelector(".scroll-right-controls")
        const scrollLeftControls = document.querySelector(".scroll-left-controls")
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
        clearInterval(this.intervalScroll)
        this.intervalScroll = setInterval(function () {
            controls.scrollLeft -= 1
            this.appearControls()

        }, 2)
    },
    scrollRight() {
        clearInterval(this.intervalScroll)
        this.intervalScroll = setInterval(function () {
            controls.scrollLeft += 1
            this.appearControls()
        }, 2)
    },
    updateSlideshow(index) {
        const slideshowContainer = document.querySelector(".slideshow-container");

        const slideshowImgs = slideshowContainer.querySelectorAll(".slideshow img");
        const thumbnails = Array.from(document.querySelectorAll(".controls img"));


        if (typeof index != "undefined") {
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
Alpine.data('produccion', () => ({
    procesos: [{
        productionSteps: [
            { type: 'simple', text: "Inicio" },
            { type: 'checklist', text: "Se verifica la materia prima", items: [["insumo", false], ["insumo", false], ["insumo", false], ["insumo", false]] },
            { type: 'simple', text: "Se pone a calentar el agua" },
            { type: 'simple', text: "Molienda de la cebada" },
            { type: 'simple', text: "Mezcla y macerado" },
            { type: 'simple', text: "Extracción del mosto" },
            { type: 'time', text: "Cocción", milliseconds: 10000, startTime: null, endTime: null },
            { type: 'simple', text: "Se le hecha lúpulo" },
            { type: 'time', text: "Cocción", milliseconds: 2700000, startTime: null, endTime: null },
            { type: 'simple', text: "Se le hecha más lúpulo" },
            { type: 'simple', text: "Whirlpool" },
            { type: 'simple', text: "Enfriado" },
            { type: 'time', text: "Fermentación", milliseconds: 864000000, startTime: null, endTime: null },
            { type: 'simple', text: "Enbarrilado" },
            { type: 'time', text: "Reposo del enbarrilado", milliseconds: 86400000, startTime: null, endTime: null },
            { type: 'simple', text: "Gasificado" },
            { type: 'time', text: "Reposo del gasificado", milliseconds: 86400000, startTime: null, endTime: null },
            { type: 'simple', text: "Enbotellado" },
            { type: 'simple', text: "Fin" },
        ],
        procesoId: 56,
        procesoName: null,
        activeStep: 0,
    },
    {
        productionSteps: [
            { type: 'simple', text: "Inicio" },
            { type: 'checklist', text: "Se verifica la materia prima", items: [["insumo", false], ["insumo", false], ["insumo", false], ["insumo", false]] },
            { type: 'simple', text: "Se pone a calentar el agua" },
            { type: 'simple', text: "Molienda de la cebada" },
            { type: 'simple', text: "Mezcla y macerado" },
            { type: 'simple', text: "Extracción del mosto" },
            { type: 'time', text: "Cocción", milliseconds: 10000, startTime: null, endTime: null },
            { type: 'simple', text: "Se le hecha lúpulo" },
            { type: 'time', text: "Cocción", milliseconds: 2700000, startTime: null, endTime: null },
            { type: 'simple', text: "Se le hecha más lúpulo" },
            { type: 'simple', text: "Whirlpool" },
            { type: 'simple', text: "Enfriado" },
            { type: 'time', text: "Fermentación", milliseconds: 864000000, startTime: null, endTime: null },
            { type: 'simple', text: "Enbarrilado" },
            { type: 'time', text: "Reposo del enbarrilado", milliseconds: 86400000, startTime: null, endTime: null },
            { type: 'simple', text: "Gasificado" },
            { type: 'time', text: "Reposo del gasificado", milliseconds: 86400000, startTime: null, endTime: null },
            { type: 'simple', text: "Enbotellado" },
            { type: 'simple', text: "Fin" },
        ],
        procesoId: 56,
        procesoName: null,
        activeStep: 0,
    }],

    init() {
        document.querySelector(".step.active")?.scrollIntoView({ behavior: "smooth", inline: "center", block: "center" });
    },
    continuar(nextStep, target, step, process) {
        switch (step.type) {
            case "checklist":
                if (this.todoChuleado(step)) {
                    this.procesos[process].activeStep = nextStep;
                    console.log(target)
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
    startTimer(step) {
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
    toggleItem(index) {
        this.openItem = this.openItem == index ? null : index;
    },
    isOpen(index) {
        return this.openItem == index;
    }
}))
Alpine.data('managementData', () => ({
    section: 'productos',
    subsection: 'index',
    sections: {
        'productos': {
            api: 'producto',
            pluralName: 'productos',
            singularName: 'producto',
            rows: null,
            details: {},
            availableProducts: null,
            photos: []
        },
        'ventas': {
            api: 'pedido',
            pluralName: 'ventas',
            singularName: 'venta',
            rows: null,
            details: {},
            selectedProducts: [],
            productQuantities: {},
        },
        'produccion': {
            api: 'produccion',
            pluralName: 'producciones',
            singularName: 'producción',
            rows: null,
            details: {},
            selectedInsumos: [],
        },
        'insumos': {
            api: 'insumo',
            rows: null,
        },
    },
    init() {
        this.load(this.section);
        this.$watch('section', (value) => {
            this.load(value);
        });
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
        if (section == 'produccion') {
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
        }
    },
    setSection(section) {
        this.section = section;
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
            list.push(`${item.nombre} (${item.pivot.cantidad_usada})`)
        });
        return list.join("  |  ");
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
            sum += insumo.unidad * insumo.pivot.cantidad_usada
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
        this.sections.produccion.selectedInsumos.push({ insumo_id: '', cantidad_usada: 1 });
    },
    removeInsumo(index) {
        this.sections.produccion.selectedInsumos.splice(index, 1);
    },
    handleFileUpload(event) {
        const files = event.target.files;
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = (e) => {
                this.sections.productos.photos.push({
                    url: e.target.result,
                    file: file
                });
            };

            reader.readAsDataURL(file);
        }
    },
    removePhoto(index) {
        this.sections.productos.photos.splice(index, 1);
    },
    edit(item) {
        this.subsection = "edit";
        this.sections[this.section].details = item;

       
        this.sections.productos.photos = (item.imagenes ? JSON.parse(item.imagenes) : []).map(image => ({
            url: `/storage/${image}`,
            file: null
        }));
    },
    view(item) {
        this.subsection = "view";
        this.sections[this.section].details = item
    },
    goBack() {
        this.subsection = "index";
    },
    create() {
        this.sections.productos.photos = [];
        this.subsection = "create";
    },

    update() {
        switch (this.section) {
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
                case "produccion":
                    let fechaProduccion = this.$refs.fechaProduccionEdit.value;
                    let cantidadProduccion = this.$refs.cantidadProduccionEdit.value;
                    let productoIdProduccion = this.$refs.productoProduccionEdit.value;
                    let insumosProduccion = this.sections.produccion.selectedInsumos;

                    let produccionData = {
                        fecha: fechaProduccion,
                        cantidad: cantidadProduccion,
                        producto_id: productoIdProduccion,
                        user_id: 1,
                    };

                    fetch(`http://localhost:8000/api/${this.sections[this.section].api}/${this.sections[this.section].details.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(produccionData),
                    })
                        .then(response => response.json())
                        .then(updatedData => {
                            if (updatedData.success) {
                                const produccionId = updatedData.data.id;

                               
                                insumosProduccion.forEach(insumo => {
                                    fetch(`http://localhost:8000/api/produccion/${produccionId}/insumos`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                        },
                                        body: JSON.stringify(insumo),
                                    })
                                        .then(response => response.json())
                                        .then(insumoData => {
                                            console.log('Insumo actualizado:', insumoData);
                                        })
                                        .catch(error => console.error('Error actualizando insumo:', error));
                                });

                                console.log('Producción actualizada exitosamente:', updatedData);
                                this.load(this.section);
                                this.goBack();
                            } else {
                                console.error('Error actualizando producción:', updatedData);
                            }
                        })
                        .catch(error => console.error('Error actualizando producción:', error));
                    break;
        }

    },
    add() {

        let fecha= "";
        switch (this.section) {
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
            case "produccion":
                    fecha = this.$refs.fechaProduccionCreate.value;
                    let cantidad = this.$refs.cantidadProduccionCreate.value;
                    let producto_id = this.$refs.productoProduccionCreate.value;
                    let insumos = this.sections.produccion.selectedInsumos;
                   
                    fetch(`http://localhost:8000/api/produccion`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ fecha, cantidad, producto_id, user_id: 1 }),
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const produccionId = data.data.id;
            
                               
                                insumos.forEach(insumo => {
                                    console.log(insumo)
            window.insumos= insumo
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
    }
}))
Alpine.start();
