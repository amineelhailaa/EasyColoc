import './bootstrap';





//for password hide and montrer
document.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-toggle-password]');
    if (!btn) return;
    const input = document.querySelector(btn.getAttribute('data-toggle-password'));
    if (!input) return;

    const isPassword = input.type === 'password';
    input.type = isPassword ? 'text' : 'password';

    const showLabel = btn.getAttribute('data-show-label') || 'Show';
    const hideLabel = btn.getAttribute('data-hide-label') || 'Hide';
    btn.textContent = isPassword ? hideLabel : showLabel;
});
