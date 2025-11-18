/**
 * URL Shortener - Frontend JavaScript
 * Handles form submission, API calls, and UI interactions
 */

// DOM Elements
const shortenForm = document.getElementById('shortenForm');
const originalUrlInput = document.getElementById('originalUrl');
const customCodeInput = document.getElementById('customCode');
const shortenBtn = document.getElementById('shortenBtn');
const btnText = shortenBtn.querySelector('.btn-text');
const btnLoader = shortenBtn.querySelector('.btn-loader');
const alertContainer = document.getElementById('alertContainer');
const resultContainer = document.getElementById('resultContainer');
const shortUrlInput = document.getElementById('shortUrlInput');
const originalUrlLink = document.getElementById('originalUrlLink');
const copyBtn = document.getElementById('copyBtn');
const createNewBtn = document.getElementById('createNewBtn');
const statsLink = document.getElementById('statsLink');

// API Base URL
const API_URL = 'api.php';

/**
 * Show alert message
 */
function showAlert(message, type = 'success') {
    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    alert.innerHTML = `
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            ${type === 'success' ? '<path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>' : ''}
            ${type === 'error' ? '<path d="M12 8V12M12 16H12.01M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>' : ''}
        </svg>
        <span>${message}</span>
    `;

    alertContainer.innerHTML = '';
    alertContainer.appendChild(alert);

    // Auto-remove after 5 seconds
    setTimeout(() => {
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 300);
    }, 5000);
}

/**
 * Set loading state
 */
function setLoading(isLoading) {
    if (isLoading) {
        shortenBtn.disabled = true;
        btnText.style.display = 'none';
        btnLoader.style.display = 'block';
    } else {
        shortenBtn.disabled = false;
        btnText.style.display = 'block';
        btnLoader.style.display = 'none';
    }
}

/**
 * Show result
 */
function showResult(data) {
    shortUrlInput.value = data.short_url;
    originalUrlLink.textContent = data.original_url;
    originalUrlLink.href = data.original_url;
    statsLink.href = `stats.html?code=${data.short_code}`;

    resultContainer.style.display = 'block';

    // Scroll to result
    resultContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

/**
 * Hide result
 */
function hideResult() {
    resultContainer.style.display = 'none';
}

/**
 * Handle form submission
 */
shortenForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    // Clear previous alerts
    alertContainer.innerHTML = '';

    const originalUrl = originalUrlInput.value.trim();
    const customCode = customCodeInput.value.trim();

    if (!originalUrl) {
        showAlert('Please enter a URL', 'error');
        return;
    }

    setLoading(true);

    try {
        const response = await fetch(`${API_URL}?action=shorten`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                url: originalUrl,
                custom: customCode
            })
        });

        const data = await response.json();

        if (data.success) {
            showResult(data);
            showAlert('Short URL created successfully!', 'success');
        } else {
            showAlert(data.error || 'Failed to create short URL', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('Network error. Please try again.', 'error');
    } finally {
        setLoading(false);
    }
});

/**
 * Handle copy button click
 */
copyBtn.addEventListener('click', async () => {
    try {
        await navigator.clipboard.writeText(shortUrlInput.value);

        // Change button text temporarily
        const originalHTML = copyBtn.innerHTML;
        copyBtn.innerHTML = `
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Copied!
        `;

        setTimeout(() => {
            copyBtn.innerHTML = originalHTML;
        }, 2000);

        showAlert('Short URL copied to clipboard!', 'success');
    } catch (error) {
        // Fallback for older browsers
        shortUrlInput.select();
        document.execCommand('copy');
        showAlert('Short URL copied to clipboard!', 'success');
    }
});

/**
 * Handle create new button click
 */
createNewBtn.addEventListener('click', () => {
    // Reset form
    shortenForm.reset();
    hideResult();
    alertContainer.innerHTML = '';

    // Focus on URL input
    originalUrlInput.focus();

    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

/**
 * Auto-format URL input
 */
originalUrlInput.addEventListener('blur', () => {
    let url = originalUrlInput.value.trim();

    if (url && !url.match(/^https?:\/\//i)) {
        originalUrlInput.value = 'https://' + url;
    }
});

/**
 * Validate custom code input
 */
customCodeInput.addEventListener('input', (e) => {
    // Only allow alphanumeric characters
    e.target.value = e.target.value.replace(/[^a-zA-Z0-9]/g, '');
});

/**
 * Check for URL parameter (for pre-filling)
 */
window.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const url = urlParams.get('url');

    if (url) {
        originalUrlInput.value = decodeURIComponent(url);
    }
});
