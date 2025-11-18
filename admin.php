<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - URL Shortener</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .login-card {
            max-width: 450px;
            margin: 100px auto;
            background: var(--glass-bg);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 48px;
            box-shadow: var(--shadow-glass);
            animation: fadeInUp 0.8s ease;
        }

        .login-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .login-header h2 {
            color: var(--text-primary);
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 12px;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .login-header p {
            color: var(--text-secondary);
        }

        .admin-header {
            background: var(--glass-bg);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 36px;
            margin-bottom: 32px;
            box-shadow: var(--shadow-glass);
            animation: fadeInDown 0.8s ease;
        }

        .admin-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 32px;
            box-shadow: var(--shadow-glass);
            text-align: center;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            animation: fadeInUp 1s ease;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: 22px;
            padding: 2px;
            background: var(--border-gradient);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-glow);
        }

        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }
        .stat-card:nth-child(4) { animation-delay: 0.4s; }

        .stat-value {
            font-size: 42px;
            font-weight: 900;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
        }

        .stat-label {
            color: var(--text-secondary);
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .urls-table-container {
            background: var(--glass-bg);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 36px;
            box-shadow: var(--shadow-glass);
            overflow-x: auto;
            animation: fadeInUp 1.2s ease;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .table-header h3 {
            font-size: 26px;
            font-weight: 800;
            color: var(--text-primary);
        }

        .urls-table {
            width: 100%;
            border-collapse: collapse;
        }

        .urls-table th,
        .urls-table td {
            padding: 18px;
            text-align: left;
            border-bottom: 1px solid var(--glass-border);
        }

        .urls-table th {
            background: rgba(255, 255, 255, 0.02);
            color: var(--text-secondary);
            font-weight: 800;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .urls-table tbody tr {
            transition: all 0.3s ease;
        }

        .urls-table tbody tr:hover {
            background: rgba(102, 126, 234, 0.05);
        }

        .short-code-cell {
            font-weight: 800;
            color: #667eea;
            font-family: 'Courier New', monospace;
        }

        .url-cell {
            max-width: 350px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: var(--text-secondary);
        }

        .badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border: 1px solid;
        }

        .badge-custom {
            background: rgba(79, 172, 254, 0.15);
            border-color: rgba(79, 172, 254, 0.3);
            color: #4facfe;
        }

        .badge-active {
            background: rgba(67, 233, 123, 0.15);
            border-color: rgba(67, 233, 123, 0.3);
            color: #43e97b;
        }

        .badge-inactive {
            background: rgba(245, 87, 108, 0.15);
            border-color: rgba(245, 87, 108, 0.3);
            color: #f5576c;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-small {
            padding: 10px 18px;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        .btn-danger {
            background: var(--gradient-2);
            color: var(--text-primary);
            box-shadow: 0 0 15px rgba(245, 87, 108, 0.3);
        }

        .btn-danger:hover {
            box-shadow: 0 0 25px rgba(245, 87, 108, 0.5);
            transform: translateY(-2px);
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 28px;
            flex-wrap: wrap;
        }

        .page-btn {
            padding: 10px 18px;
            border: 1px solid var(--glass-border);
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 700;
            color: var(--text-primary);
        }

        .page-btn:hover:not(:disabled) {
            border-color: rgba(102, 126, 234, 0.5);
            background: var(--glass-bg-hover);
            box-shadow: var(--shadow-glow);
            transform: translateY(-2px);
        }

        .page-btn.active {
            background: var(--primary-gradient);
            color: #ffffff;
            border-color: transparent;
        }

        .page-btn:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .logout-btn {
            background: var(--gradient-2);
            color: var(--text-primary);
            border: none;
            box-shadow: 0 0 15px rgba(245, 87, 108, 0.3);
        }

        .logout-btn:hover {
            box-shadow: 0 0 25px rgba(245, 87, 108, 0.5);
            transform: translateY(-2px);
        }

        #loadingIndicator {
            text-align: center;
            padding: 60px;
            color: var(--text-secondary);
            font-size: 16px;
        }

        #errorContainer {
            text-align: center;
            padding: 60px;
            color: #f5576c;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div id="loginSection" style="display: none;">
        <div class="login-card">
            <div class="login-header">
                <h2>Admin Login</h2>
                <p style="color: var(--text-secondary);">Enter your admin password</p>
            </div>

            <form id="loginForm">
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input"
                        placeholder="Enter admin password"
                        required
                        autocomplete="current-password"
                    >
                </div>

                <button type="submit" class="btn btn-primary">
                    Login
                </button>
            </form>

            <div id="loginAlert" style="margin-top: 20px;"></div>

            <div style="text-align: center; margin-top: 20px;">
                <a href="index.html" style="color: #667eea; text-decoration: none;">
                    ← Back to Home
                </a>
            </div>
        </div>
    </div>

    <div id="adminSection" style="display: none;">
        <div class="admin-container">
            <header class="admin-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h1 style="font-size: 32px; margin-bottom: 8px;">Admin Panel</h1>
                        <p style="color: var(--text-secondary);">Manage your shortened URLs</p>
                    </div>
                    <div style="display: flex; gap: 12px;">
                        <a href="index.html" class="btn btn-secondary btn-small">
                            ← Back to Home
                        </a>
                        <button id="logoutBtn" class="btn btn-small logout-btn">
                            Logout
                        </button>
                    </div>
                </div>
            </header>

            <div class="admin-stats" id="statsContainer">
                <div class="stat-card">
                    <div class="stat-value" id="totalUrls">0</div>
                    <div class="stat-label">Total URLs</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="totalClicks">0</div>
                    <div class="stat-label">Total Clicks</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="customUrls">0</div>
                    <div class="stat-label">Custom URLs</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="activeUrls">0</div>
                    <div class="stat-label">Active URLs</div>
                </div>
            </div>

            <div class="urls-table-container">
                <div class="table-header">
                    <h3>All Short URLs</h3>
                    <button id="refreshBtn" class="btn btn-secondary btn-small">
                        ↻ Refresh
                    </button>
                </div>

                <div id="loadingIndicator">Loading...</div>

                <div id="tableContainer" style="display: none;">
                    <table class="urls-table">
                        <thead>
                            <tr>
                                <th>Short Code</th>
                                <th>Original URL</th>
                                <th>Created</th>
                                <th>Clicks</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="urlsTableBody">
                        </tbody>
                    </table>

                    <div class="pagination" id="pagination"></div>
                </div>

                <div id="errorContainer" style="display: none; text-align: center; padding: 40px; color: var(--error-color);">
                    Failed to load URLs. Please try again.
                </div>
            </div>
        </div>
    </div>

    <script>
        const API_URL = 'api.php';
        let adminPassword = '';
        let currentPage = 1;

        // Check if already logged in
        const savedPassword = sessionStorage.getItem('adminPassword');
        if (savedPassword) {
            adminPassword = savedPassword;
            showAdminPanel();
        } else {
            document.getElementById('loginSection').style.display = 'block';
        }

        // Login form handler
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const password = document.getElementById('password').value;

            try {
                const response = await fetch(`${API_URL}?action=list`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ password, page: 1 })
                });

                const data = await response.json();

                if (data.success) {
                    adminPassword = password;
                    sessionStorage.setItem('adminPassword', password);
                    document.getElementById('loginSection').style.display = 'none';
                    showAdminPanel();
                } else {
                    showLoginAlert('Invalid password', 'error');
                }
            } catch (error) {
                showLoginAlert('Login failed. Please try again.', 'error');
            }
        });

        function showLoginAlert(message, type) {
            const alert = document.createElement('div');
            alert.className = `alert alert-${type}`;
            alert.textContent = message;
            document.getElementById('loginAlert').innerHTML = '';
            document.getElementById('loginAlert').appendChild(alert);
        }

        function showAdminPanel() {
            document.getElementById('adminSection').style.display = 'block';
            loadUrls();
        }

        async function loadUrls(page = 1) {
            currentPage = page;
            document.getElementById('loadingIndicator').style.display = 'block';
            document.getElementById('tableContainer').style.display = 'none';
            document.getElementById('errorContainer').style.display = 'none';

            try {
                const response = await fetch(`${API_URL}?action=list`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ password: adminPassword, page })
                });

                const data = await response.json();

                if (data.success) {
                    displayUrls(data.urls);
                    updateStats(data.urls);
                    renderPagination(data.pagination);
                    document.getElementById('loadingIndicator').style.display = 'none';
                    document.getElementById('tableContainer').style.display = 'block';
                } else {
                    throw new Error(data.error);
                }
            } catch (error) {
                document.getElementById('loadingIndicator').style.display = 'none';
                document.getElementById('errorContainer').style.display = 'block';
            }
        }

        function displayUrls(urls) {
            const tbody = document.getElementById('urlsTableBody');
            tbody.innerHTML = '';

            urls.forEach(url => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="short-code-cell">${url.short_code} ${url.custom ? '<span class="badge badge-custom">Custom</span>' : ''}</td>
                    <td class="url-cell" title="${url.original_url}">${url.original_url}</td>
                    <td>${new Date(url.created_at).toLocaleDateString()}</td>
                    <td><strong>${url.clicks}</strong></td>
                    <td><span class="badge ${url.active ? 'badge-active' : 'badge-inactive'}">${url.active ? 'Active' : 'Disabled'}</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-small btn-secondary" onclick="toggleUrl(${url.id})">
                                ${url.active ? 'Disable' : 'Enable'}
                            </button>
                            <button class="btn btn-small btn-danger" onclick="deleteUrl(${url.id})">Delete</button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        function updateStats(urls) {
            const totalUrls = urls.length;
            const totalClicks = urls.reduce((sum, url) => sum + parseInt(url.clicks), 0);
            const customUrls = urls.filter(url => url.custom).length;
            const activeUrls = urls.filter(url => url.active).length;

            document.getElementById('totalUrls').textContent = totalUrls;
            document.getElementById('totalClicks').textContent = totalClicks;
            document.getElementById('customUrls').textContent = customUrls;
            document.getElementById('activeUrls').textContent = activeUrls;
        }

        function renderPagination(pagination) {
            const container = document.getElementById('pagination');
            container.innerHTML = '';

            if (pagination.total_pages <= 1) return;

            // Previous button
            const prevBtn = document.createElement('button');
            prevBtn.className = 'page-btn';
            prevBtn.textContent = '← Previous';
            prevBtn.disabled = pagination.page === 1;
            prevBtn.onclick = () => loadUrls(pagination.page - 1);
            container.appendChild(prevBtn);

            // Page numbers
            for (let i = 1; i <= pagination.total_pages; i++) {
                const pageBtn = document.createElement('button');
                pageBtn.className = `page-btn ${i === pagination.page ? 'active' : ''}`;
                pageBtn.textContent = i;
                pageBtn.onclick = () => loadUrls(i);
                container.appendChild(pageBtn);
            }

            // Next button
            const nextBtn = document.createElement('button');
            nextBtn.className = 'page-btn';
            nextBtn.textContent = 'Next →';
            nextBtn.disabled = pagination.page === pagination.total_pages;
            nextBtn.onclick = () => loadUrls(pagination.page + 1);
            container.appendChild(nextBtn);
        }

        async function toggleUrl(id) {
            if (!confirm('Are you sure you want to toggle this URL status?')) return;

            try {
                const response = await fetch(`${API_URL}?action=toggle`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ password: adminPassword, id })
                });

                const data = await response.json();

                if (data.success) {
                    loadUrls(currentPage);
                } else {
                    alert('Failed to toggle URL: ' + data.error);
                }
            } catch (error) {
                alert('Failed to toggle URL. Please try again.');
            }
        }

        async function deleteUrl(id) {
            if (!confirm('Are you sure you want to delete this URL? This action cannot be undone.')) return;

            try {
                const response = await fetch(`${API_URL}?action=delete`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ password: adminPassword, id })
                });

                const data = await response.json();

                if (data.success) {
                    loadUrls(currentPage);
                } else {
                    alert('Failed to delete URL: ' + data.error);
                }
            } catch (error) {
                alert('Failed to delete URL. Please try again.');
            }
        }

        document.getElementById('refreshBtn').addEventListener('click', () => {
            loadUrls(currentPage);
        });

        document.getElementById('logoutBtn').addEventListener('click', () => {
            sessionStorage.removeItem('adminPassword');
            location.reload();
        });
    </script>
</body>
</html>
