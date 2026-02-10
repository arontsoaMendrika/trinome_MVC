/**
 * E-Takalo - Scripts JavaScript personnalisés
 */

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    
    // Auto-dismiss des alerts après 5 secondes
    const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Prévisualisation d'image avant upload
    const photoInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    photoInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    // Créer ou mettre à jour la prévisualisation
                    let preview = input.parentElement.querySelector('.image-preview');
                    if (!preview) {
                        preview = document.createElement('img');
                        preview.className = 'image-preview mt-2 img-thumbnail';
                        preview.style.maxWidth = '200px';
                        input.parentElement.appendChild(preview);
                    }
                    preview.src = event.target.result;
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    });

    // Validation du formulaire d'inscription
    const registerForm = document.querySelector('form[action="/inscription"]');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            const password = document.getElementById('motdepasse').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                showAlert('Les mots de passe ne correspondent pas', 'danger');
                return false;
            }
            
            if (password.length < 6) {
                e.preventDefault();
                showAlert('Le mot de passe doit contenir au moins 6 caractères', 'danger');
                return false;
            }
        });
    }

    // Confirmation avant suppression
    const deleteButtons = document.querySelectorAll('[data-action="delete"]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
                e.preventDefault();
                return false;
            }
        });
    });

    // Animation du compteur (pour la page d'accueil)
    animateCounters();

    // Lazy loading des images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img.lazy').forEach(img => {
            imageObserver.observe(img);
        });
    }
});

/**
 * Afficher une alerte Bootstrap
 */
function showAlert(message, type = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.role = 'alert';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    const container = document.querySelector('.container');
    if (container) {
        container.insertBefore(alertDiv, container.firstChild);
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alertDiv);
            bsAlert.close();
        }, 5000);
    }
}

/**
 * Animation des compteurs sur la page d'accueil
 */
function animateCounters() {
    const counters = document.querySelectorAll('.stats-card h3');
    
    counters.forEach(counter => {
        const target = parseInt(counter.innerText.replace(/\D/g, ''));
        if (!target) return;
        
        const duration = 2000;
        const increment = target / (duration / 16);
        let current = 0;
        
        const updateCounter = () => {
            current += increment;
            if (current < target) {
                counter.innerText = Math.floor(current) + '+';
                requestAnimationFrame(updateCounter);
            } else {
                counter.innerText = target + '+';
            }
        };
        
        // Observer pour démarrer l'animation quand visible
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) {
                    updateCounter();
                    observer.disconnect();
                }
            });
            observer.observe(counter);
        } else {
            updateCounter();
        }
    });
}

/**
 * Formater le prix en Ariary
 */
function formatPrice(price) {
    return new Intl.NumberFormat('fr-MG', {
        style: 'currency',
        currency: 'MGA',
        minimumFractionDigits: 0
    }).format(price);
}

/**
 * Valider un email
 */
function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

/**
 * Recherche en temps réel dans le catalogue
 */
function setupLiveSearch() {
    const searchInput = document.getElementById('search-input');
    if (!searchInput) return;
    
    searchInput.addEventListener('input', debounce(function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const cards = document.querySelectorAll('.card');
        
        cards.forEach(card => {
            const title = card.querySelector('.card-title').textContent.toLowerCase();
            const description = card.querySelector('.card-text').textContent.toLowerCase();
            
            if (title.includes(searchTerm) || description.includes(searchTerm)) {
                card.parentElement.style.display = '';
            } else {
                card.parentElement.style.display = 'none';
            }
        });
    }, 300));
}

/**
 * Fonction de debounce pour optimiser les recherches
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Copier un texte dans le presse-papiers
 */
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showAlert('Copié dans le presse-papiers !', 'success');
    }).catch(err => {
        console.error('Erreur de copie:', err);
    });
}

/**
 * Partager sur les réseaux sociaux
 */
function shareProduct(title, url) {
    if (navigator.share) {
        navigator.share({
            title: title,
            url: url
        }).catch(err => console.log('Erreur de partage:', err));
    } else {
        copyToClipboard(url);
    }
}

// Exporter les fonctions pour utilisation globale
window.ETakalo = {
    showAlert,
    formatPrice,
    isValidEmail,
    copyToClipboard,
    shareProduct,
    setupLiveSearch
};
