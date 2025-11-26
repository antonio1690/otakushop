// public/js/app.js

// ============================================
// ANIMACIONES DE SCROLL
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    
    // Animación de aparición al hacer scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in-up');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observar todas las cards de productos
    document.querySelectorAll('.product-card').forEach(card => {
        observer.observe(card);
    });

    // ============================================
    // CARRITO - ACTUALIZACIÓN AUTOMÁTICA
    // ============================================
    const quantityInputs = document.querySelectorAll('input[name="quantity"]');
    
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const form = this.closest('form');
            if (form && form.querySelector('button[type="submit"]')) {
                // Auto-submit después de un pequeño delay
                setTimeout(() => {
                    form.submit();
                }, 500);
            }
        });
    });

    // ============================================
    // VALIDACIÓN DE FORMULARIOS EN TIEMPO REAL
    // ============================================
    const forms = document.querySelectorAll('form[data-validate="true"]');
    
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateInput(this);
            });
            
            input.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    validateInput(this);
                }
            });
        });
    });

    function validateInput(input) {
        const value = input.value.trim();
        const type = input.type;
        let isValid = true;
        let errorMessage = '';

        // Validación según el tipo
        if (input.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'Este campo es obligatorio';
        } else if (type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'Email no válido';
            }
        } else if (input.name === 'password' && value && value.length < 8) {
            isValid = false;
            errorMessage = 'La contraseña debe tener al menos 8 caracteres';
        }

        // Aplicar clases de validación
        if (isValid) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
        } else {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
            
            // Mostrar mensaje de error
            let feedback = input.nextElementSibling;
            if (!feedback || !feedback.classList.contains('invalid-feedback')) {
                feedback = document.createElement('div');
                feedback.classList.add('invalid-feedback');
                input.parentNode.insertBefore(feedback, input.nextSibling);
            }
            feedback.textContent = errorMessage;
        }
    }

    // ============================================
    // NOTIFICACIONES TOAST
    // ============================================
    window.showNotification = function(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast-notification toast-${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-circle'}-fill"></i>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => toast.classList.add('show'), 100);
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    };

    // ============================================
    // BUSCADOR CON AUTOCOMPLETADO
    // ============================================
    const searchInput = document.querySelector('input[name="search"]');
    
    if (searchInput) {
        let searchTimeout;
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            
            if (query.length >= 2) {
                searchTimeout = setTimeout(() => {
                    // Aquí podrías hacer una petición AJAX para autocompletado
                    console.log('Buscando:', query);
                }, 300);
            }
        });
    }

    // ============================================
    // FILTROS DINÁMICOS
    // ============================================
    const filterInputs = document.querySelectorAll('.filter-input');
    
    filterInputs.forEach(input => {
        input.addEventListener('change', function() {
            // Auto-submit del formulario de filtros
            const form = this.closest('form');
            if (form) {
                showLoadingSpinner();
                form.submit();
            }
        });
    });

    // ============================================
    // LOADING SPINNER
    // ============================================
    function showLoadingSpinner() {
        const spinner = document.createElement('div');
        spinner.className = 'loading-spinner';
        spinner.innerHTML = '<div class="spinner-border text-primary"></div>';
        document.body.appendChild(spinner);
    }

    // ============================================
    // CONFIRMACIÓN DE ELIMINACIÓN
    // ============================================
    window.confirmDelete = function(message = '¿Estás seguro de eliminar este elemento?') {
        return confirm(message);
    };

    // ============================================
    // CONTADOR DE CARACTERES
    // ============================================
    const textareas = document.querySelectorAll('textarea[maxlength]');
    
    textareas.forEach(textarea => {
        const maxLength = textarea.getAttribute('maxlength');
        const counter = document.createElement('small');
        counter.className = 'text-muted char-counter';
        counter.textContent = `0 / ${maxLength}`;
        
        textarea.parentNode.appendChild(counter);
        
        textarea.addEventListener('input', function() {
            const length = this.value.length;
            counter.textContent = `${length} / ${maxLength}`;
            
            if (length > maxLength * 0.9) {
                counter.classList.add('text-danger');
            } else {
                counter.classList.remove('text-danger');
            }
        });
    });

    // ============================================
    // PREVIEW DE IMÁGENES MEJORADO
    // ============================================
    window.previewImage = function(input, previewId = 'preview') {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            const file = input.files[0];
            
            // Validar tamaño (2MB máximo)
            if (file.size > 2048 * 1024) {
                showNotification('La imagen no debe superar 2MB', 'error');
                input.value = '';
                return;
            }
            
            // Validar tipo
            if (!file.type.match('image.*')) {
                showNotification('Solo se permiten imágenes', 'error');
                input.value = '';
                return;
            }
            
            reader.onload = function(e) {
                const preview = document.getElementById(previewId);
                const container = preview.closest('#image-preview, #logo-preview');
                
                preview.src = e.target.result;
                if (container) {
                    container.style.display = 'block';
                    container.classList.add('fade-in');
                }
            };
            
            reader.readAsDataURL(file);
        }
    };

    // ============================================
    // SMOOTH SCROLL
    // ============================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href.length > 1) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });

    // ============================================
    // MODO OSCURO (OPCIONAL)
    // ============================================
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    
    if (darkModeToggle) {
        const darkMode = localStorage.getItem('darkMode');
        
        if (darkMode === 'enabled') {
            document.body.classList.add('dark-mode');
            darkModeToggle.checked = true;
        }
        
        darkModeToggle.addEventListener('change', function() {
            if (this.checked) {
                document.body.classList.add('dark-mode');
                localStorage.setItem('darkMode', 'enabled');
            } else {
                document.body.classList.remove('dark-mode');
                localStorage.setItem('darkMode', 'disabled');
            }
        });
    }

    // ============================================
    // LAZY LOADING DE IMÁGENES
    // ============================================
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.add('fade-in');
                observer.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));

    // ============================================
    // COPIAR AL PORTAPAPELES
    // ============================================
    window.copyToClipboard = function(text) {
        navigator.clipboard.writeText(text).then(() => {
            showNotification('Copiado al portapapeles', 'success');
        });
    };

    // ============================================
    // FORMATEAR PRECIO EN TIEMPO REAL
    // ============================================
    const priceInputs = document.querySelectorAll('input[name="price"]');
    
    priceInputs.forEach(input => {
        input.addEventListener('blur', function() {
            const value = parseFloat(this.value);
            if (!isNaN(value)) {
                this.value = value.toFixed(2);
            }
        });
    });

});

// ============================================
// FUNCIONES GLOBALES
// ============================================

// Toggle de preventa en formulario de productos
function togglePreorder() {
    const isPreorder = document.getElementById('is_preorder')?.checked;
    const preorderDate = document.getElementById('preorder-date');
    
    if (preorderDate) {
        preorderDate.style.display = isPreorder ? 'block' : 'none';
        
        // Animación suave
        if (isPreorder) {
            preorderDate.style.opacity = '0';
            setTimeout(() => {
                preorderDate.style.transition = 'opacity 0.3s';
                preorderDate.style.opacity = '1';
            }, 10);
        }
    }
}

// Función para eliminar productos (admin)
function deleteProduct(id) {
    if (confirmDelete('¿Estás seguro de eliminar este producto? Esta acción no se puede deshacer.')) {
        document.getElementById('delete-form-' + id).submit();
    }
}

// Función para eliminar categorías
function deleteCategory(id) {
    if (confirmDelete('¿Estás seguro de eliminar esta categoría?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}

// Función para eliminar franquicias
function deleteFranchise(id) {
    if (confirmDelete('¿Estás seguro de eliminar esta franquicia?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}

// Función para eliminar pedidos
function deleteOrder(id) {
    if (confirmDelete('¿Estás seguro de eliminar este pedido?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}

// ============================================
// ANIMACIONES Y EFECTOS VISUALES
// ============================================

// Efecto de ondas al hacer click
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-primary-custom')) {
        createRipple(e);
    }
});

function createRipple(event) {
    const button = event.currentTarget;
    const circle = document.createElement('span');
    const diameter = Math.max(button.clientWidth, button.clientHeight);
    const radius = diameter / 2;

    circle.style.width = circle.style.height = `${diameter}px`;
    circle.style.left = `${event.clientX - button.offsetLeft - radius}px`;
    circle.style.top = `${event.clientY - button.offsetTop - radius}px`;
    circle.classList.add('ripple');

    const ripple = button.getElementsByClassName('ripple')[0];
    if (ripple) {
        ripple.remove();
    }

    button.appendChild(circle);
}

console.log('✨ OtakuShop JavaScript cargado correctamente');