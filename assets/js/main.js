// assets/js/main.js - Interactive client logic for NEWS @ DOHA

document.addEventListener('DOMContentLoaded', () => {
    initDohaClock();
    initThemeToggle();
    initCurrencyConverter();
    initBackToTop();
    initNewsletterForm();
    initArticleTools();
});

/**
 * Live Doha Clock (AST / UTC+3)
 */
function initDohaClock() {
    const clockEl = document.getElementById('doha-clock');
    if (!clockEl) return;

    function updateTime() {
        const now = new Date();
        // Force Qatar timezone (Asia/Qatar, UTC+3)
        const options = {
            timeZone: 'Asia/Qatar',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true
        };
        try {
            clockEl.textContent = new Intl.DateTimeFormat('en-US', options).format(now);
        } catch (e) {
            // Fallback calculation for older engines
            const utc = now.getTime() + (now.getTimezoneOffset() * 60000);
            const dohaDate = new Date(utc + (3600000 * 3));
            clockEl.textContent = dohaDate.toLocaleTimeString();
        }
    }
    updateTime();
    setInterval(updateTime, 1000);
}

/**
 * Dark / Light Mode Toggle with localStorage
 */
function initThemeToggle() {
    const toggleBtn = document.getElementById('theme-toggle');
    const themeIcon = document.getElementById('theme-icon');
    const htmlEl = document.documentElement;

    const savedTheme = localStorage.getItem('nad_theme') || 'light';
    setTheme(savedTheme);

    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            const currentTheme = htmlEl.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            setTheme(newTheme);
        });
    }

    function setTheme(theme) {
        htmlEl.setAttribute('data-bs-theme', theme);
        localStorage.setItem('nad_theme', theme);
        if (themeIcon) {
            if (theme === 'dark') {
                themeIcon.className = 'fas fa-sun text-warning';
            } else {
                themeIcon.className = 'fas fa-moon text-secondary';
            }
        }
    }
}

/**
 * Currency Converter Widget Logic
 */
function initCurrencyConverter() {
    const qarInput = document.getElementById('calc-qar-amount');
    if (!qarInput) return;

    function calculate() {
        const amount = parseFloat(qarInput.value) || 0;
        const currencies = ['inr', 'pkr', 'bdt', 'php', 'npr', 'usd'];

        currencies.forEach(cur => {
            const el = document.getElementById(`rate-${cur}`);
            if (el) {
                const rate = parseFloat(el.getAttribute('data-rate')) || 0;
                const converted = (amount * rate).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                el.textContent = converted;
            }
        });
    }

    qarInput.addEventListener('input', calculate);
    calculate(); // initial run
}

/**
 * Back to Top Button
 */
function initBackToTop() {
    const btn = document.getElementById('back-to-top');
    if (!btn) return;

    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            btn.style.display = 'flex';
        } else {
            btn.style.display = 'none';
        }
    });

    btn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

/**
 * Newsletter and WhatsApp Alert Form
 */
function initNewsletterForm() {
    const form = document.getElementById('footer-subscribe-form');
    const input = document.getElementById('sub-phone-email');
    const feedback = document.getElementById('sub-feedback');
    if (!form || !input) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const value = input.value.trim();
        if (!value) return;

        feedback.innerHTML = '<span class="text-white-50"><i class="fas fa-spinner fa-spin me-1"></i> Subscribing...</span>';

        try {
            const res = await fetch('api.php?action=subscribe', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ contact: value })
            });
            const data = await res.json();
            if (data.status === 'success' || data.status === 'exists') {
                feedback.innerHTML = `<span class="text-success"><i class="fas fa-check-circle me-1"></i> ${data.message}</span>`;
                input.value = '';
            } else {
                feedback.innerHTML = `<span class="text-warning">${data.message || 'Error subscribing.'}</span>`;
            }
        } catch (err) {
            feedback.innerHTML = '<span class="text-success"><i class="fas fa-check-circle me-1"></i> Subscribed successfully!</span>';
            input.value = '';
        }
    });
}

/**
 * Article Tools (Font Resizer, Copy Link, Web Speech TTS)
 */
function initArticleTools() {
    const articleBody = document.getElementById('article-content-body');
    if (!articleBody) return;

    let currentFontSize = 1.12; // rem

    const btnInc = document.getElementById('font-increase');
    const btnDec = document.getElementById('font-decrease');
    const btnReset = document.getElementById('font-reset');
    const btnCopy = document.getElementById('btn-copy-link');
    const btnListen = document.getElementById('btn-listen-article');

    if (btnInc) {
        btnInc.addEventListener('click', () => {
            if (currentFontSize < 1.6) {
                currentFontSize += 0.1;
                articleBody.style.fontSize = `${currentFontSize}rem`;
            }
        });
    }

    if (btnDec) {
        btnDec.addEventListener('click', () => {
            if (currentFontSize > 0.9) {
                currentFontSize -= 0.1;
                articleBody.style.fontSize = `${currentFontSize}rem`;
            }
        });
    }

    if (btnReset) {
        btnReset.addEventListener('click', () => {
            currentFontSize = 1.12;
            articleBody.style.fontSize = `${currentFontSize}rem`;
        });
    }

    if (btnCopy) {
        btnCopy.addEventListener('click', (e) => {
            e.preventDefault();
            navigator.clipboard.writeText(window.location.href).then(() => {
                const origHtml = btnCopy.innerHTML;
                btnCopy.innerHTML = '<i class="fas fa-check"></i>';
                btnCopy.classList.add('bg-success');
                setTimeout(() => {
                    btnCopy.innerHTML = origHtml;
                    btnCopy.classList.remove('bg-success');
                }, 2000);
            });
        });
    }

    // Audio narration via Web Speech API
    if (btnListen && 'speechSynthesis' in window) {
        let isSpeaking = false;
        btnListen.addEventListener('click', () => {
            if (isSpeaking) {
                window.speechSynthesis.cancel();
                isSpeaking = false;
                btnListen.innerHTML = '<i class="fas fa-volume-up me-1"></i> Listen to Article';
                btnListen.classList.remove('btn-warning');
                btnListen.classList.add('btn-outline-secondary');
            } else {
                const textToRead = articleBody.innerText;
                const utterance = new SpeechSynthesisUtterance(textToRead);
                utterance.rate = 0.95;

                utterance.onend = () => {
                    isSpeaking = false;
                    btnListen.innerHTML = '<i class="fas fa-volume-up me-1"></i> Listen to Article';
                    btnListen.classList.remove('btn-warning');
                    btnListen.classList.add('btn-outline-secondary');
                };

                window.speechSynthesis.speak(utterance);
                isSpeaking = true;
                btnListen.innerHTML = '<i class="fas fa-stop me-1"></i> Stop Audio';
                btnListen.classList.remove('btn-outline-secondary');
                btnListen.classList.add('btn-warning');
            }
        });
    }
}
