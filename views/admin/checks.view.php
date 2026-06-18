<?php 
/** @var array $users */
/** @var array $allUsers */
/** @var array $kpis */
/** @var string $dateFrom */
/** @var string $dateTo */
/** @var string $selectedUserId */
require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/nav.php') ?>

<style>
    :root {
      --gold:#B8973A;   --gold-lt:#D4AF55;  --gold-dk:#EDD98A;
      --bg:#FDFAF4;     --surface:#F5EFE0;  --card:#FFFFFF;  --card2:#F7F0DC;
      --border:rgba(184,151,58,.2);  --border-lt:rgba(184,151,58,.1);
      --text:#2C2418;   --muted:#6B5B3E;
      --red:#E05252;    --green:#4CAF8A;  --blue:#4A90D9;  --orange:#E0944A;
    }

    .checks-container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 0 20px;
        font-family: 'Jost', sans-serif;
        direction: ltr;
    }

    .filter-card {
      background: var(--surface); border: 1px solid var(--border);
      border-radius: 8px; padding: 20px; margin-bottom: 24px;
    }

    .filter-row { display: flex; align-items: flex-end; gap: 14px; flex-wrap: wrap; }
    .fg { display: flex; flex-direction: column; gap: 6px; flex: 1; min-width: 150px; }
    .fg label { font-size: 12px; color: var(--muted); }
    .fg input, .fg select { padding: 9px; border: 1px solid var(--border); border-radius: 3px; font-family: inherit; }

    .btn-search { padding: 9px 24px; background: var(--gold); border: none; border-radius: 3px; color: white; font-weight: 700; cursor: pointer; }
    .btn-reset { padding: 9px 16px; background: transparent; border: 1px solid var(--border); border-radius: 3px; color: var(--muted); cursor: pointer; }

    .kpi-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 24px; }
    .kpi { background: var(--surface); border: 1px solid var(--border); border-radius: 8px; padding: 18px; position: relative; }
    .kpi::after { content: ''; position: absolute; top: 0; right: 0; width: 3px; height: 100%; background: var(--gold); }
    .kpi-val { font-family: 'Cormorant Garamond', serif; font-size: 24px; color: var(--gold); }
    .kpi-lbl { font-size: 12px; color: var(--muted); }

    .two-col { display: grid; grid-template-columns: 1fr 380px; gap: 20px; align-items: start; }
    .table-wrap { background: var(--surface); border: 1px solid var(--border); border-radius: 8px; overflow: hidden; }
    table { width: 100%; border-collapse: collapse; text-align: left; }
    thead th { padding: 12px; background: rgba(184,151,58,0.05); font-size: 12px; color: var(--muted); border-bottom: 1px solid var(--border); }
    tbody tr { border-bottom: 1px solid rgba(184,151,58,0.07); cursor: pointer; transition: 0.2s; }
    tbody tr:hover { background: rgba(184,151,58,0.04); }
    tbody tr.selected { background: rgba(184,151,58,0.1) !important; border-left: 3px solid var(--gold); }
    td { padding: 12px; font-size: 14px; }

    .detail-panel { background: var(--surface); border: 1px solid var(--border); border-radius: 8px; overflow: hidden; position: sticky; top: 20px; }
    .dp-head { padding: 15px; background: rgba(184,151,58,0.05); border-bottom: 1px solid var(--border); }
    .dp-summary { display: grid; grid-template-columns: 1fr 1fr; border-bottom: 1px solid var(--border); }
    .dp-sum-cell { padding: 15px; text-align: center; border-right: 1px solid var(--border-lt); }
    .dp-orders { max-height: 400px; overflow-y: auto; padding: 15px; }
    .dp-order { background: white; border: 1px solid var(--border-lt); border-radius: 6px; padding: 12px; margin-bottom: 10px; }

    .d-status { font-size: 10px; padding: 2px 8px; border-radius: 10px; font-weight: 600; }
    .d-status.processing { background: #e3f2fd; color: #1976d2; }
    .d-status.delivery { background: #fff3e0; color: #f57c00; }
    .d-status.done { background: #e8f5e9; color: #388e3c; }

    .dp-chip { background: var(--card2); padding: 2px 8px; border-radius: 4px; font-size: 11px; margin-right: 5px; }
    .pagination { display: flex; justify-content: center; gap: 5px; margin-top: 15px; padding-bottom: 15px; }
    .pg-btn { padding: 5px 10px; border: 1px solid var(--border); background: white; cursor: pointer; }
    .pg-btn.active { background: var(--gold); color: white; }

    .toast { position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); background: #333; color: white; padding: 10px 20px; border-radius: 5px; display: none; }
    .toast.show { display: block; }
</style>

<div class="checks-container">
    <h2 style="margin-bottom: 20px;">Checks & Reports</h2>

    <div class="filter-card">
        <div class="filter-row">
            <div class="fg">
                <label>Date From</label>
                <input type="date" id="dateFrom" value="<?= $dateFrom ?>">
            </div>
            <div class="fg">
                <label>Date To</label>
                <input type="date" id="dateTo" value="<?= $dateTo ?>">
            </div>
            <div class="fg">
                <label>User</label>
                <select id="userFilter">
                    <option value="">All Users</option>
                    <?php foreach($allUsers as $u): ?>
                        <option value="<?= $u['id'] ?>" <?= $selectedUserId == $u['id'] ? 'selected' : '' ?>><?= $u['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button class="btn-search" onclick="applyFilter()">Search</button>
            <button class="btn-reset" onclick="resetFilter()">Reset</button>
        </div>
    </div>

    <div class="kpi-row">
        <div class="kpi">
            <div class="kpi-val" id="kRevenue"><?= round($kpis['revenue']) ?> EGP</div>
            <div class="kpi-lbl">Total Revenue</div>
        </div>
        <div class="kpi">
            <div class="kpi-val" id="kOrders"><?= $kpis['total_orders'] ?></div>
            <div class="kpi-lbl">Total Orders</div>
        </div>
        <div class="kpi">
            <div class="kpi-val" id="kUsers"><?= $kpis['active_users'] ?></div>
            <div class="kpi-lbl">Active Users</div>
        </div>
        <div class="kpi">
            <div class="kpi-val" id="kAvg"><?= round($kpis['avg_order']) ?> EGP</div>
            <div class="kpi-lbl">Average Order</div>
        </div>
    </div>

    <div class="two-col">
        <div class="table-wrap">
            <div style="padding: 15px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between;">
                <span style="font-weight: 700;">Users Summary</span>
                <span id="twCount" style="font-size: 12px; color: var(--muted);"><?= count($users) ?> Users</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Orders</th>
                        <th>Total</th>
                        <th>Last Order</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="checksBody">
                    <!-- Loaded via JS -->
                </tbody>
            </table>
            <div id="pagination" class="pagination"></div>
        </div>

        <div id="detailPanel" class="detail-panel">
            <div style="padding: 50px; text-align: center; color: var(--muted);">
                <span style="font-size: 40px;">💳</span>
                <p>Select a user to view details</p>
            </div>
        </div>
    </div>
</div>

<div id="toast" class="toast"></div>

<script>
    const API = '/admin/checks';
    const PAGE_SIZE = 5;
    let currentPage = 1;
    let selectedUserId = null;
    let filteredUsers = <?= json_encode($users) ?>;

    function statusLabel(s) {
        return { processing: 'Processing', delivery: 'Out for Delivery', done: 'Done' }[s] || s;
    }

    async function applyFilter() {
        const from = document.getElementById('dateFrom').value;
        const to = document.getElementById('dateTo').value;
        const userId = document.getElementById('userFilter').value;
        const qs = new URLSearchParams({ date_from: from, date_to: to, user_id: userId });

        try {
            const summaryRes = await fetch(`${API}?action=summary&${qs}`);
            const summaryData = await summaryRes.json();
            const kpisRes = await fetch(`${API}?action=kpis&${qs}`);
            const kpisData = await kpisRes.json();

            if (summaryData.success) {
                filteredUsers = summaryData.users;
                currentPage = 1;
                selectedUserId = null;
                renderTable();
            }
            if (kpisData.success) {
                updateKPIs(kpisData.kpis);
            }
            showToast('Data updated successfully');
        } catch (err) {
            showToast('Connection error');
        }
    }

    function resetFilter() {
        window.location.href = window.location.pathname;
    }

    function updateKPIs(k) {
        document.getElementById('kRevenue').textContent = Math.round(k.revenue) + ' EGP';
        document.getElementById('kOrders').textContent = k.total_orders;
        document.getElementById('kUsers').textContent = k.active_users;
        document.getElementById('kAvg').textContent = Math.round(k.avg_order) + ' EGP';
    }

    function renderTable() {
        const start = (currentPage - 1) * PAGE_SIZE;
        const slice = filteredUsers.slice(start, start + PAGE_SIZE);
        const tbody = document.getElementById('checksBody');
        document.getElementById('twCount').textContent = filteredUsers.length + ' Users';

        if (!slice.length) {
            tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; padding:20px;">No data found</td></tr>';
            renderPagination();
            return;
        }

        tbody.innerHTML = slice.map(u => `
            <tr class="${selectedUserId == u.id ? 'selected' : ''}" onclick="selectUser(${u.id})">
                <td>
                    <div style="font-weight:600;">${u.name}</div>
                    <div style="font-size:11px; color:var(--muted);">Room ${u.room_number || '—'}</div>
                </td>
                <td>${u.total_orders}</td>
                <td style="color:var(--gold); font-weight:700;">${Math.round(u.total_amount)} EGP</td>
                <td style="font-size:12px;">${u.last_order_date ? u.last_order_date.split(' ')[0] : '—'}</td>
                <td><button style="font-size:11px; padding:3px 8px; cursor:pointer;">Details</button></td>
            </tr>
        `).join('');
        renderPagination();
    }

    function renderPagination() {
        const pages = Math.ceil(filteredUsers.length / PAGE_SIZE);
        const pg = document.getElementById('pagination');
        if (pages <= 1) { pg.innerHTML = ''; return; }
        let h = '';
        for (let i = 1; i <= pages; i++) {
            h += `<button class="pg-btn ${i === currentPage ? 'active' : ''}" onclick="goPage(${i})">${i}</button>`;
        }
        pg.innerHTML = h;
    }

    function goPage(n) { currentPage = n; renderTable(); }

    async function selectUser(id) {
        selectedUserId = id;
        renderTable();
        const from = document.getElementById('dateFrom').value;
        const to = document.getElementById('dateTo').value;
        const panel = document.getElementById('detailPanel');
        panel.innerHTML = '<div style="padding:50px; text-align:center;">Loading...</div>';

        try {
            const res = await fetch(`${API}?action=user_detail&user_id=${id}&date_from=${from}&date_to=${to}`);
            const data = await res.json();
            if (data.success) renderDetailPanel(data.user, data.orders, data.stats);
        } catch (err) {
            panel.innerHTML = '<div style="padding:50px; text-align:center;">Failed to load</div>';
        }
    }

    function renderDetailPanel(user, orders, stats) {
        const panel = document.getElementById('detailPanel');
        panel.innerHTML = `
            <div class="dp-head">
                <div style="font-weight:700; font-size:18px;">${user.name}</div>
                <div style="font-size:12px; color:var(--muted);">${user.email}</div>
            </div>
            <div class="dp-summary">
                <div class="dp-sum-cell">
                    <div style="font-weight:700; color:var(--gold);">${Math.round(stats.total_amount)} EGP</div>
                    <div style="font-size:11px;">Total Spent</div>
                </div>
                <div class="dp-sum-cell">
                    <div style="font-weight:700; color:var(--gold);">${stats.total_orders}</div>
                    <div style="font-size:11px;">Orders Count</div>
                </div>
            </div>
            <div class="dp-orders">
                ${orders.length === 0 ? '<p style="text-align:center;">No orders found</p>' : orders.map(o => `
                    <div class="dp-order">
                        <div style="display:flex; justify-content:space-between; margin-bottom:5px;">
                            <span style="font-size:11px; color:var(--muted);">${o.created_at}</span>
                            <span style="font-weight:700; color:var(--gold);">${Math.round(o.total)} EGP</span>
                        </div>
                        <div class="d-status ${o.status}">${statusLabel(o.status)}</div>
                        <div style="margin-top:8px;">
                            ${o.items.map(it => `<span class="dp-chip">${it.product_name} ×${it.quantity}</span>`).join('')}
                        </div>
                    </div>
                `).join('')}
            </div>
        `;
    }

    function showToast(msg) {
        const t = document.getElementById('toast');
        t.textContent = msg; t.className = 'toast show';
        setTimeout(() => t.classList.remove('show'), 3000);
    }

    renderTable();
</script>

<?php require base_path('views/partials/footer.php') ?>
