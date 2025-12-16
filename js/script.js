// Modern Header Scroll Effect
window.addEventListener('scroll', () => {
    const header = document.querySelector('header');
    if (window.scrollY > 50) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});

// Smooth Scroll for Navigation Links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Mobile Menu Toggle
const toggler = document.querySelector('#toggler');
if (toggler) {
    toggler.addEventListener('change', () => {
        const navbar = document.querySelector('.navbar');
        if (toggler.checked) {
            navbar.style.clipPath = 'polygon(0 0, 100% 0, 100% 100%, 0% 100%)';
        } else {
            navbar.style.clipPath = 'polygon(0 0, 100% 0, 100% 0, 0 0)';
        }
    });
}

// Close mobile menu when clicking outside
document.addEventListener('click', (e) => {
    const header = document.querySelector('header');
    const toggler = document.querySelector('#toggler');
    const navbar = document.querySelector('.navbar');
    
    if (toggler && navbar && !header.contains(e.target) && toggler.checked) {
        toggler.checked = false;
        navbar.style.clipPath = 'polygon(0 0, 100% 0, 100% 0, 0 0)';
    }
});

// Close mobile menu when clicking on a link
document.querySelectorAll('.navbar a').forEach(link => {
    link.addEventListener('click', () => {
        const toggler = document.querySelector('#toggler');
        const navbar = document.querySelector('.navbar');
        if (toggler && toggler.checked) {
            toggler.checked = false;
            navbar.style.clipPath = 'polygon(0 0, 100% 0, 100% 0, 0 0)';
        }
    });
});

// Intersection Observer for Fade-in Animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe elements for animation
document.querySelectorAll('.box, .icons, .review .box, .about .row').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(30px)';
    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(el);
});

// Add loading animation to images
document.querySelectorAll('img').forEach(img => {
    img.addEventListener('load', function() {
        this.style.opacity = '1';
        this.style.transition = 'opacity 0.3s ease';
    });
    
    if (img.complete) {
        img.style.opacity = '1';
    } else {
        img.style.opacity = '0';
    }
});

// Product Card Hover Effects
document.querySelectorAll('.products .box').forEach(box => {
    box.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-10px)';
    });
    
    box.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
    });
});

// Button Ripple Effect
document.querySelectorAll('.btn, button').forEach(button => {
    button.addEventListener('click', function(e) {
        const ripple = document.createElement('span');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.classList.add('ripple');
        
        this.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    });
});

// Add ripple CSS if not exists
if (!document.querySelector('#ripple-styles')) {
    const style = document.createElement('style');
    style.id = 'ripple-styles';
    style.textContent = `
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            transform: scale(0);
            animation: ripple-animation 0.6s ease-out;
            pointer-events: none;
        }
        
        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        .btn, button {
            position: relative;
            overflow: hidden;
        }
    `;
    document.head.appendChild(style);
}

// Lazy Loading for Images
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                }
                imageObserver.unobserve(img);
            }
        });
    });
    
    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

// Console log for debugging (can be removed in production)
console.log('✅ Modern UI enhancements loaded successfully!');
