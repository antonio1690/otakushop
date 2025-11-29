// public/js/app.js

// ============================================
// INICIALIZACIÓN
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    
    // Inicializar modo oscuro
    initDarkMode();
    
    // Crear partículas de anime
    createAnimeParticles();
    
    // Animaciones de scroll
    initScrollAnimations();
    
    // Efectos de hover en productos
    initProductEffects();
    
    // Auto-submit de carrito
    initCartAutoUpdate();
    
    // Validación de formularios
    initFormValidation();
    
    // Efectos de cursor
    initCursorEffects();
    
    console.log('✨ OtakuShop cargado - Modo Otaku activado!');
});

// ============================================
// MODO OSCURO
// ============================================
function initDarkMode() {
    // Buscar el botón que ya existe en el navbar
    const toggleBtn = document.getElementById('darkModeToggle');
    
    if (!toggleBtn) return;
    
    // Verificar preferencia guardada
    const darkMode = localStorage.getItem('darkMode');
    if (darkMode === 'enabled') {
        document.body.classList.add('dark-mode');
        toggleBtn.innerHTML = '<i class="bi bi-sun-fill"></i>';
    }
    
    // Toggle al hacer clic
    toggleBtn.addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');
        
        if (document.body.classList.contains('dark-mode')) {
            localStorage.setItem('darkMode', 'enabled');
            toggleBtn.innerHTML = '<i class="bi bi-sun-fill"></i>';
            showNotification('Modo oscuro activado 🌙', 'success');
        } else {
            localStorage.setItem('darkMode', 'disabled');
            toggleBtn.innerHTML = '<i class="bi bi-moon-stars-fill"></i>';
            showNotification('Modo claro activado ☀️', 'success');
        }
    });
}

// ============================================
// PARTÍCULAS DE ANIME FLOTANTES
// ============================================
function createAnimeParticles() {
    const particlesContainer = document.createElement('div');
    particlesContainer.className = 'anime-particles';
    document.body.appendChild(particlesContainer);
    
    // Emojis temáticos de anime
    const animeEmojis = ['⭐', '✨', '💫', '🌸', '🎌', '⚡', '🔥', '💖', '🌙'];
    
    for (let i = 0; i < 9; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.textContent = animeEmojis[i];
        particle.style.left = `${Math.random() * 100}%`;
        particlesContainer.appendChild(particle);
    }
}

// ============================================
// ANIMACIONES DE SCROLL
// ============================================
function initScrollAnimations() {
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

    // Observar todas las cards
    document.querySelectorAll('.product-card, .card').forEach(card => {
        observer.observe(card);
    });
    
    // Parallax suave
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector('.hero-section');
        if (hero) {
            hero.style.transform = `translateY(${scrolled * 0.3}px)`;
        }
    });
}

// ============================================
// EFECTOS EN PRODUCTOS
// ============================================
function initProductEffects() {
    const productCards = document.querySelectorAll('.product-card');
    
    productCards.forEach(card => {
        // Efecto de brillo al pasar el mouse
        card.addEventListener('mouseenter', function(e) {
            createSparkles(e);
        });
        
        // Animación de entrada escalonada
        const delay = Array.from(productCards).indexOf(card) * 100;
        setTimeout(() => {
            card.style.opacity = '1';
            card.classList.add('fade-in-up');
        }, delay);
    });
}

// Crear efecto de chispas
function createSparkles(e) {
    const card = e.currentTarget;
    const rect = card.getBoundingClientRect();
    
    for (let i = 0; i < 3; i++) {
        setTimeout(() => {
            const sparkle = document.createElement('div');
            sparkle.className = 'sparkle';
            sparkle.style.left = `${Math.random() * rect.width}px`;
            sparkle.style.top = `${Math.random() * rect.height}px`;
            card.appendChild(sparkle);
            
            setTimeout(() => sparkle.remove(), 1000);
        }, i * 100);
    }
}

// ============================================
// CARRITO - ACTUALIZACIÓN AUTOMÁTICA
// ============================================
function initCartAutoUpdate() {
    const quantityInputs = document.querySelectorAll('input[name="quantity"]');
    
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const form = this.closest('form');
            if (form && form.querySelector('button[type="submit"]')) {
                showNotification('Actualizando carrito...', 'success');
                setTimeout(() => form.submit(), 500);
            }
        });
    });
}

// ============================================
// VALIDACIÓN DE FORMULARIOS
// ============================================
function initFormValidation() {
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
}

function validateInput(input) {
    const value = input.value.trim();
    const type = input.type;
    let isValid = true;
    let errorMessage = '';

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

    if (isValid) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
    } else {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
        
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
// EFECTOS DE CURSOR
// ============================================
function initCursorEffects() {
    // Efecto de ondas al hacer clic en botones
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-primary-custom')) {
            createRipple(e);
        }
    });
}

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

// ============================================
// NOTIFICACIONES TOAST
// ============================================
window.showNotification = function(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast-notification toast-${type}`;
    
    const icon = type === 'success' ? 'check-circle-fill' : 'exclamation-circle-fill';
    
    toast.innerHTML = `
        <div class="toast-content">
            <i class="bi bi-${icon}"></i>
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
// PREVIEW DE IMÁGENES MEJORADO
// ============================================
window.previewImage = function(input, previewId = 'preview') {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        const file = input.files[0];
        
        // Validar tamaño (2MB máximo)
        if (file.size > 2048 * 1024) {
            showNotification('La imagen no debe superar 2MB ❌', 'error');
            input.value = '';
            return;
        }
        
        // Validar tipo
        if (!file.type.match('image.*')) {
            showNotification('Solo se permiten imágenes ❌', 'error');
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
            
            showNotification('Imagen cargada correctamente ✨', 'success');
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
        showNotification('Copiado al portapapeles 📋', 'success');
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

// ============================================
// CONTADOR DE PRODUCTOS EN CARRITO ANIMADO
// ============================================
function animateCartBadge() {
    const badge = document.querySelector('.badge-cart');
    if (badge) {
        badge.classList.add('pulse');
        setTimeout(() => badge.classList.remove('pulse'), 1000);
    }
}

// ============================================
// EFECTOS DE CONFETTI AL COMPLETAR COMPRA
// ============================================
window.celebrateOrder = function() {
    // Crear confetti
    const colors = ['#ff6b9d', '#c44569', '#ffa502', '#667eea', '#764ba2'];
    
    for (let i = 0; i < 50; i++) {
        const confetti = document.createElement('div');
        confetti.style.position = 'fixed';
        confetti.style.width = '10px';
        confetti.style.height = '10px';
        confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
        confetti.style.left = `${Math.random() * 100}%`;
        confetti.style.top = '-10px';
        confetti.style.borderRadius = '50%';
        confetti.style.zIndex = '99999';
        confetti.style.pointerEvents = 'none';
        
        document.body.appendChild(confetti);
        
        const fall = confetti.animate([
            { transform: 'translateY(0) rotate(0deg)', opacity: 1 },
            { transform: `translateY(${window.innerHeight}px) rotate(${Math.random() * 720}deg)`, opacity: 0 }
        ], {
            duration: 2000 + Math.random() * 1000,
            easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)'
        });
        
        fall.onfinish = () => confetti.remove();
    }
};

// ============================================
// FUNCIONES GLOBALES
// ============================================

function togglePreorder() {
    const isPreorder = document.getElementById('is_preorder')?.checked;
    const preorderDate = document.getElementById('preorder-date');
    
    if (preorderDate) {
        preorderDate.style.display = isPreorder ? 'block' : 'none';
        
        if (isPreorder) {
            preorderDate.style.opacity = '0';
            setTimeout(() => {
                preorderDate.style.transition = 'opacity 0.3s';
                preorderDate.style.opacity = '1';
            }, 10);
        }
    }
}

function deleteProduct(id) {
    if (confirm('¿Estás seguro de eliminar este producto? Esta acción no se puede deshacer.')) {
        document.getElementById('delete-form-' + id).submit();
    }
}

function deleteCategory(id) {
    if (confirm('¿Estás seguro de eliminar esta categoría?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}

function deleteFranchise(id) {
    if (confirm('¿Estás seguro de eliminar esta franquicia?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}

function deleteOrder(id) {
    if (confirm('¿Estás seguro de eliminar este pedido?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}

// ============================================
// EASTER EGG - KONAMI CODE
// ============================================
let konamiCode = [];
const konamiSequence = [38, 38, 40, 40, 37, 39, 37, 39, 66, 65]; // ↑↑↓↓←→←→BA

document.addEventListener('keydown', function(e) {
    konamiCode.push(e.keyCode);
    konamiCode = konamiCode.slice(-10);
    
    if (konamiCode.join(',') === konamiSequence.join(',')) {
        showNotification('🎌 Modo Otaku Ultra activado! 🎌', 'success');
        document.body.style.animation = 'gradient-animation 3s ease infinite';
        celebrateOrder();
        
        // Resetear después de 5 segundos
        setTimeout(() => {
            document.body.style.animation = '';
        }, 5000);
    }
});

console.log('💫 ¿Sabías que hay un código secreto? Prueba: ↑↑↓↓←→←→BA');