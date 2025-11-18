/**
 * URL Shortener - Frontend JavaScript
 * Handles form submission, API calls, and UI interactions
 */

// DOM Elements
const shortenForm = document.getElementById('shortenForm');
const originalUrlInput = document.getElementById('originalUrl');
const customCodeInput = document.getElementById('customCode');
const codeLengthSelect = document.getElementById('codeLength');
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
    const codeLength = parseInt(codeLengthSelect.value);

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
                custom: customCode,
                length: codeLength
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

/**
 * Tab Switching Functionality
 */
const tabBtns = document.querySelectorAll('.tab-btn');
const tabContents = document.querySelectorAll('.tab-content');

tabBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        const tabName = btn.getAttribute('data-tab');

        // Remove active class from all tabs and contents
        tabBtns.forEach(b => b.classList.remove('active'));
        tabContents.forEach(c => c.classList.remove('active'));

        // Add active class to clicked tab and corresponding content
        btn.classList.add('active');
        document.getElementById(tabName + 'Tab').classList.add('active');
    });
});

/**
 * Bulk URL Shortening
 */
const bulkShortenForm = document.getElementById('bulkShortenForm');
const bulkUrlsInput = document.getElementById('bulkUrls');
const bulkCodeLengthSelect = document.getElementById('bulkCodeLength');
const bulkShortenBtn = document.getElementById('bulkShortenBtn');
const bulkAlertContainer = document.getElementById('bulkAlertContainer');
const bulkResultsContainer = document.getElementById('bulkResultsContainer');

function showBulkAlert(message, type = 'success') {
    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    alert.innerHTML = `
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            ${type === 'success' ? '<path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>' : ''}
            ${type === 'error' ? '<path d="M12 8V12M12 16H12.01M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>' : ''}
        </svg>
        <span>${message}</span>
    `;

    bulkAlertContainer.innerHTML = '';
    bulkAlertContainer.appendChild(alert);

    setTimeout(() => {
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 300);
    }, 5000);
}

function setBulkLoading(isLoading) {
    const btnText = bulkShortenBtn.querySelector('.btn-text');
    const btnLoader = bulkShortenBtn.querySelector('.btn-loader');

    if (isLoading) {
        bulkShortenBtn.disabled = true;
        btnText.style.display = 'none';
        btnLoader.style.display = 'block';
    } else {
        bulkShortenBtn.disabled = false;
        btnText.style.display = 'block';
        btnLoader.style.display = 'none';
    }
}

bulkShortenForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    bulkAlertContainer.innerHTML = '';
    bulkResultsContainer.innerHTML = '';
    bulkResultsContainer.style.display = 'none';

    const bulkText = bulkUrlsInput.value.trim();
    const defaultLength = parseInt(bulkCodeLengthSelect.value);

    if (!bulkText) {
        showBulkAlert('Please enter at least one URL', 'error');
        return;
    }

    // Parse URLs line by line
    const lines = bulkText.split('\n').filter(line => line.trim());

    if (lines.length === 0) {
        showBulkAlert('Please enter at least one URL', 'error');
        return;
    }

    if (lines.length > 50) {
        showBulkAlert('Maximum 50 URLs allowed at once', 'error');
        return;
    }

    // Parse each line for URL and optional custom code
    const urlsToShorten = lines.map(line => {
        const parts = line.trim().split(/\s+/);
        const url = parts[0];
        const customCode = parts.length > 1 ? parts[1] : '';

        return { url, customCode };
    });

    setBulkLoading(true);

    // Process all URLs
    const results = [];

    for (let i = 0; i < urlsToShorten.length; i++) {
        const { url, customCode } = urlsToShorten[i];

        try {
            const response = await fetch(`${API_URL}?action=shorten`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    url: url,
                    custom: customCode,
                    length: defaultLength
                })
            });

            const data = await response.json();

            if (data.success) {
                results.push({
                    success: true,
                    originalUrl: url,
                    shortUrl: data.short_url,
                    shortCode: data.short_code
                });
            } else {
                results.push({
                    success: false,
                    originalUrl: url,
                    error: data.error
                });
            }
        } catch (error) {
            results.push({
                success: false,
                originalUrl: url,
                error: 'Network error'
            });
        }
    }

    setBulkLoading(false);

    // Display results
    displayBulkResults(results);

    const successCount = results.filter(r => r.success).length;
    showBulkAlert(`Processed ${results.length} URLs. ${successCount} successful, ${results.length - successCount} failed.`, successCount > 0 ? 'success' : 'error');
});

function displayBulkResults(results) {
    bulkResultsContainer.innerHTML = '';
    bulkResultsContainer.style.display = 'block';

    results.forEach((result, index) => {
        const resultItem = document.createElement('div');
        resultItem.className = `bulk-result-item ${result.success ? 'success' : 'error'}`;

        if (result.success) {
            resultItem.innerHTML = `
                <div class="bulk-result-info">
                    <div class="bulk-result-short">${result.shortUrl}</div>
                    <div class="bulk-result-original">${result.originalUrl}</div>
                </div>
                <button class="bulk-copy-btn" onclick="copyBulkUrl('${result.shortUrl}', this)">Copy</button>
            `;
        } else {
            resultItem.innerHTML = `
                <div class="bulk-result-info">
                    <div class="bulk-result-original">${result.originalUrl}</div>
                    <div class="bulk-result-error">Error: ${result.error}</div>
                </div>
            `;
        }

        bulkResultsContainer.appendChild(resultItem);
    });

    // Scroll to results
    bulkResultsContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

async function copyBulkUrl(url, button) {
    try {
        await navigator.clipboard.writeText(url);
        const originalText = button.textContent;
        button.textContent = 'Copied!';
        button.style.background = 'var(--gradient-4)';

        setTimeout(() => {
            button.textContent = originalText;
            button.style.background = 'var(--gradient-3)';
        }, 2000);
    } catch (error) {
        alert('Failed to copy to clipboard');
    }
}
