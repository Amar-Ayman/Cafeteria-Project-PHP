<?php 
/** @var array $users */
/** @var array $products */
require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/nav.php') ?>

<style>
    :root {
      --gold:        #B8973A;
      --gold-lt:     #D4AF55;
      --gold-dk:     #EDD98A;
      --bg:          #FDFAF4;
      --surface:     #F5EFE0;
      --card:        #FFFFFF;
      --border:    rgba(184,151,58,.25);
      --border-lt: rgba(184,151,58,.12);
      --text:        #2C2418;
      --muted:       #6B5B3E;
      --red:       #E05252;
      --green:     #4CAF8A;
    }

    .manual-order-container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 0 20px;
        font-family: 'Jost', sans-serif;
        direction: ltr;
    }

    .layout {
      display: grid;
      grid-template-columns: 1fr 320px;
      gap: 24px;
      align-items: start;
    }

    .user-select-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 8px; padding: 20px;
      margin-bottom: 22px;
    }

    .user-select {
      width: 100%; padding: 10px;
      border: 1px solid var(--border); border-radius: 5px;
      margin-bottom: 15px;
    }

    .selected-user-info {
      display: none; align-items: center; gap: 15px;
      background: rgba(184,151,58,.06);
      border: 1px solid var(--border);
      border-radius: 8px; padding: 15px;
    }
    .selected-user-info.show { display: flex; }

    .su-avatar {
      width: 45px; height: 45px; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-weight: 700; color: white;
    }

    .cat-tabs { display: flex; gap: 10px; margin-bottom: 20px; }
    .ctab {
      padding: 8px 20px; border-radius: 20px;
      border: 1px solid var(--border); background: white;
      cursor: pointer; transition: 0.3s;
    }
    .ctab.active { background: var(--gold); color: white; border-color: var(--gold); }

    .products-grid {
      display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
      gap: 15px;
    }

    .product-card {
      background: white; border: 1px solid var(--border);
      border-radius: 10px; overflow: hidden; cursor: pointer;
      transition: 0.3s; position: relative;
    }
    .product-card:hover { transform: translateY(-5px); border-color: var(--gold); }
    .product-card.in-cart { border-color: var(--gold); box-shadow: 0 0 10px rgba(184,151,58,0.2); }
    .product-card.unavailable { opacity: 0.5; cursor: not-allowed; }

    .pc-img { height: 120px; background: #f9f9f9; display: flex; align-items: center; justify-content: center; }
    .pc-img img { width: 100%; height: 100%; object-fit: cover; }
    .pc-badge { position: absolute; top: 10px; right: 10px; background: var(--gold); color: white; padding: 2px 8px; border-radius: 10px; font-size: 12px; }
    .pc-unavail { position: absolute; top: 10px; left: 10px; background: var(--red); color: white; padding: 2px 8px; border-radius: 10px; font-size: 10px; }

    .pc-info { padding: 12px; text-align: center; }
    .pc-name { font-weight: 600; margin-bottom: 5px; }
    .pc-price { color: var(--gold); font-weight: 700; }

    .cart-panel {
      background: var(--surface); border: 1px solid var(--border);
      border-radius: 10px; padding: 20px; position: sticky; top: 20px;
    }

    .cart-item { display: flex; align-items: center; gap: 10px; padding: 10px 0; border-bottom: 1px solid var(--border-lt); }
    .ci-name { flex: 1; font-size: 14px; }
    .qty-ctrl { display: flex; align-items: center; gap: 5px; }
    .qty-btn { width: 24px; height: 24px; border-radius: 50%; border: 1px solid var(--gold); background: transparent; color: var(--gold); cursor: pointer; }
    .remove-btn { background: transparent; border: none; color: var(--red); cursor: pointer; }

    .total-row { display: flex; justify-content: space-between; padding: 15px 0; border-top: 2px dashed var(--gold); margin: 15px 0; font-weight: 700; font-size: 18px; }
    .btn-confirm { width: 100%; padding: 15px; background: var(--gold); color: white; border: none; border-radius: 5px; font-weight: 700; cursor: pointer; }
    .btn-confirm:disabled { opacity: 0.5; cursor: not-allowed; }

    .toast { position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); background: #333; color: white; padding: 10px 20px; border-radius: 5px; display: none; z-index: 1000; }
    .toast.show { display: block; }
    .toast.red { background: var(--red); }
    .toast.gold { background: var(--gold); }
</style>

<div class="manual-order-container">
    <h2 style="margin-bottom: 20px;">Manual Order</h2>

    <div class="layout">
        <div class="main-col">
            <div class="user-select-card">
                <select id="userSelect" class="user-select" onchange="onUserChange()">
                    <option value="">— Select User —</option>
                </select>

                <div id="selectedUserInfo" class="selected-user-info">
                    <div id="suAvatar" class="su-avatar"></div>
                    <div>
                        <div id="suName" style="font-weight: 700;"></div>
                        <div id="suRoom" style="font-size: 12px; color: var(--muted);"></div>
                    </div>
                </div>
            </div>

            <div class="cat-tabs">
                <button class="ctab active" onclick="filterCat('all', this)">All</button>
                <button class="ctab" onclick="filterCat('Hot Drinks', this)">Hot Drinks</button>
                <button class="ctab" onclick="filterCat('Cold Drinks', this)">Cold Drinks</button>
                <button class="ctab" onclick="filterCat('Snacks', this)">Snacks</button>
            </div>

            <div id="productsGrid" class="products-grid">
                <!-- Products load here -->
            </div>
        </div>

        <div class="cart-panel">
            <h3 style="margin-bottom: 15px; border-bottom: 1px solid var(--gold); padding-bottom: 10px;">Order Cart</h3>
            <div id="cartList">
                <div style="text-align: center; color: var(--muted); padding: 20px;">Cart is empty</div>
            </div>

            <div style="margin-top: 20px;">
                <label style="display: block; font-size: 12px; margin-bottom: 5px;">Room / Table Number</label>
                <select id="roomSelect" class="user-select">
                    <option value="">Select Room</option>
                </select>

                <label style="display: block; font-size: 12px; margin-bottom: 5px; margin-top: 10px;">Notes</label>
                <textarea id="notesArea" class="user-select" rows="3" placeholder="Any special requests?"></textarea>
            </div>

            <div class="total-row">
                <span>Total:</span>
                <span id="totalAmt">0 EGP</span>
            </div>

            <button id="confirmBtn" class="btn-confirm" onclick="confirmOrder()" disabled>Confirm Order</button>
        </div>
    </div>
</div>

<div id="toast" class="toast"></div>

<script>
    let users = [];
    let products = [];
    let cart = {};
    let currentCat = 'all';
    let selectedUserId = null;

    const API = '/admin/manual_order';

    async function loadFormData() {
        try {
            const response = await fetch(`${API}?action=get_data`);
            const data = await response.json();

            if (data.success) {
                users = data.users;
                products = data.products;
                fillUserDropdown(data.users);
                fillRoomsDropdown(data.rooms);
                renderProducts();
            }
        } catch (err) {
            showToast('Server connection error', 'red');
        }
    }

    function fillUserDropdown(list) {
        const sel = document.getElementById('userSelect');
        list.forEach(u => {
            const opt = document.createElement('option');
            opt.value = u.id;
            opt.textContent = `${u.name} — Room ${u.room_number || '—'}`;
            sel.appendChild(opt);
        });
    }

    function fillRoomsDropdown(rooms) {
        const sel = document.getElementById('roomSelect');
        rooms.forEach(r => {
            const opt = document.createElement('option');
            opt.value = r.id;
            opt.textContent = r.room_number;
            sel.appendChild(opt);
        });
    }

    function onUserChange() {
        const id = +document.getElementById('userSelect').value;
        const info = document.getElementById('selectedUserInfo');

        if (!id) {
            selectedUserId = null;
            info.classList.remove('show');
            updateConfirmBtn();
            return;
        }

        const u = users.find(x => x.id === id);
        selectedUserId = id;

        const avatar = document.getElementById('suAvatar');
        avatar.style.background = '#B8973A';
        avatar.textContent = u.name.charAt(0);
        document.getElementById('suName').textContent = u.name;
        document.getElementById('suRoom').textContent = `Room ${u.room_number || '—'} — Ext ${u.ext || '—'}`;
        info.classList.add('show');

        const roomSel = document.getElementById('roomSelect');
        if (u.room_number) {
            for (let opt of roomSel.options) {
                if (opt.textContent === u.room_number) {
                    roomSel.value = opt.value;
                    break;
                }
            }
        }

        updateConfirmBtn();
    }

    function renderProducts() {
        const list = currentCat === 'all' ? products : products.filter(p => p.category_name === currentCat);
        const grid = document.getElementById('productsGrid');

        grid.innerHTML = list.map(p => {
            const avail = p.is_available == 1;
            return `
                <div class="product-card ${cart[p.id] ? 'in-cart' : ''} ${!avail ? 'unavailable' : ''}" onclick="${avail ? `addToCart(${p.id})` : ''}">
                    <div class="pc-img">
                        ${p.image ? `<img src="${p.image}">` : '<span style="font-size:40px;">☕</span>'}
                        ${!avail ? '<span class="pc-unavail">Unavailable</span>' : ''}
                        ${cart[p.id] ? `<span class="pc-badge">×${cart[p.id]}</span>` : ''}
                    </div>
                    <div class="pc-info">
                        <div class="pc-name">${p.name}</div>
                        <div class="pc-price">${p.price} EGP</div>
                    </div>
                </div>`;
        }).join('');
    }

    function addToCart(id) {
        cart[id] = (cart[id] || 0) + 1;
        renderAll();
        showToast('Added to cart', 'gold');
    }

    function changeQty(id, delta) {
        cart[id] = (cart[id] || 0) + delta;
        if (cart[id] <= 0) delete cart[id];
        renderAll();
    }

    function removeFromCart(id) {
        delete cart[id];
        renderAll();
    }

    function renderCart() {
        const ids = Object.keys(cart).map(Number);
        const list = document.getElementById('cartList');

        if (!ids.length) {
            list.innerHTML = '<div style="text-align: center; color: var(--muted); padding: 20px;">Cart is empty</div>';
            document.getElementById('totalAmt').textContent = '0 EGP';
            updateConfirmBtn();
            return;
        }

        let total = 0;
        list.innerHTML = ids.map(id => {
            const p = products.find(x => x.id === id);
            const lineTotal = p.price * cart[id];
            total += lineTotal;
            return `
                <div class="cart-item">
                    <span class="ci-name">${p.name}</span>
                    <div class="qty-ctrl">
                        <button class="qty-btn" onclick="changeQty(${id},-1)">−</button>
                        <span>${cart[id]}</span>
                        <button class="qty-btn" onclick="changeQty(${id},1)">+</button>
                    </div>
                    <span style="font-weight:600; margin: 0 10px;">${lineTotal}</span>
                    <button class="remove-btn" onclick="removeFromCart(${id})">✕</button>
                </div>`;
        }).join('');

        document.getElementById('totalAmt').textContent = total + ' EGP';
        updateConfirmBtn();
    }

    function updateConfirmBtn() {
        document.getElementById('confirmBtn').disabled = !(selectedUserId && Object.keys(cart).length > 0);
    }

    function filterCat(cat, btn) {
        currentCat = cat;
        document.querySelectorAll('.ctab').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        renderProducts();
    }

    async function confirmOrder() {
        const roomId = document.getElementById('roomSelect').value;
        const notes = document.getElementById('notesArea').value;

        if (!roomId) { showToast('Please select a room', 'red'); return; }

        const items = Object.keys(cart).map(id => ({ product_id: +id, quantity: cart[id] }));
        const btn = document.getElementById('confirmBtn');
        btn.disabled = true;
        btn.textContent = '⏳ Sending...';

        try {
            const response = await fetch(`${API}?action=create`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ user_id: selectedUserId, room_id: roomId, notes: notes, items: items })
            });

            const data = await response.json();
            if (data.success) {
                showToast(`Order created successfully! Order ID: #${data.order_id}`, 'success');
                cart = {};
                document.getElementById('notesArea').value = '';
                document.getElementById('userSelect').value = '';
                onUserChange();
                renderAll();
            } else {
                showToast(data.message, 'error');
            }
        } catch (err) {
            showToast('Failed to send order', 'error');
        } finally {
            btn.textContent = '✅ Confirm Order';
            updateConfirmBtn();
        }
    }

    function renderAll() {
        renderProducts();
        renderCart();
    }

    function showToast(msg, cls) {
        const t = document.getElementById('toast');
        t.textContent = msg; t.className = 'toast show ' + cls;
        setTimeout(() => t.classList.remove('show'), 3000);
    }

    loadFormData();
</script>

<?php require base_path('views/partials/footer.php') ?>
