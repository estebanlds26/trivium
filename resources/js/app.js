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