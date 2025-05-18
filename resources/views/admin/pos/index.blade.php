@extends('layouts.admin')

@section('title', 'Point of Sales - EvoKasir')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 py-6 sm:py-8 space-y-6 sm:space-y-8 bg-transparent relative z-10">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-coral-500 mb-4 sm:mb-6 flex items-center gap-2">
            <i class="fas fa-cash-register text-lg sm:text-xl"></i> Point of Sales
        </h1>

        {{-- Form Input --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div>
                <label for="name" class="block text-sm sm:text-base font-semibold text-gray-300 mb-1">
                    Nama Pelanggan <span class="text-gray-400 text-xs">(opsional)</span>
                </label>
                <input type="text" id="name"
                    class="w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200"
                    placeholder="Evognito Team" autocomplete="off">
            </div>
            <div>
                <label for="email" class="block text-sm sm:text-base font-semibold text-gray-300 mb-1">
                    Email Pelanggan <span class="text-gray-400 text-xs">(opsional)</span>
                </label>
                <input type="email" id="email"
                    class="w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200"
                    placeholder="evognitoteam@gmail.com" autocomplete="off">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div>
                <label for="table_number" class="block text-sm sm:text-base font-semibold text-gray-300 mb-1">Nomor Meja
                    <span class="text-red-400">*</span></label>
                <select id="table_number"
                    class="w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200"
                    required>
                    <option value="">-- Pilih Meja --</option>
                    @foreach ($tables as $table)
                        <option value="{{ $table->id }}">{{ $table->table_name }}</option>
                    @endforeach
                </select>
                <small id="table-error" class="text-red-400 text-xs sm:text-sm mt-1 hidden">Nomor meja wajib
                    dipilih!</small>
            </div>
            <div>
                <label for="discount" class="block text-sm sm:text-base font-semibold text-gray-300 mb-1">
                    Diskon <span class="text-gray-400 text-xs">(opsional)</span>
                </label>
                <input type="text" id="discount"
                    class="w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200"
                    placeholder="Contoh: 10000 atau 10%">
                <small id="discount-error" class="text-red-400 text-xs sm:text-sm mt-1 hidden">Format diskon tidak
                    valid!</small>
            </div>
        </div>

        {{-- Produk --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4 mb-6 sm:mb-8">
            @foreach ($menus as $menu)
                <button onclick="addToCart({{ $menu->id }}, '{{ addslashes($menu->name) }}', {{ $menu->price }})"
                    class="bg-gray-800/90 backdrop-blur-md border border-gray-700 py-4 sm:py-5 rounded-lg shadow-md hover:bg-gray-700 hover:shadow-lg transition-all duration-300 w-full">
                    <div class="font-semibold text-sm sm:text-base text-gray-300">{{ $menu->name }}</div>
                    <div class="text-xs sm:text-sm text-gray-400">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>
                </button>
            @endforeach
        </div>

        {{-- Keranjang --}}
        <div class="bg-gray-800/90 backdrop-blur-md p-4 sm:p-6 rounded-xl shadow-lg mb-6 sm:mb-8">
            <h2 class="text-lg sm:text-xl font-semibold text-coral-500 mb-3 sm:mb-4 flex items-center gap-2">
                <i class="fas fa-shopping-cart"></i> Keranjang
            </h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm sm:text-base">
                    <thead>
                        <tr class="border-b border-gray-700">
                            <th class="text-left py-2 sm:py-3 text-gray-300">Item</th>
                            <th class="text-center py-2 sm:py-3 text-gray-300">Qty</th>
                            <th class="text-right py-2 sm:py-3 text-gray-300">Harga</th>
                            <th class="text-right py-2 sm:py-3 text-gray-300">Total</th>
                            <th class="py-2 sm:py-3"></th>
                        </tr>
                    </thead>
                    <tbody id="cart-body"></tbody>
                </table>
            </div>
            <div class="text-right mt-4 sm:mt-6">
                <div class="text-sm sm:text-base text-gray-300">Total: Rp <span id="cart-total">0</span></div>
                <div class="text-sm sm:text-base text-gray-300">Diskon: Rp <span id="cart-discount">0</span></div>
                <div class="text-lg sm:text-xl font-semibold text-teal-400">Total Dibayar: Rp <span id="cart-pay">0</span>
                </div>
            </div>

            <div class="mt-4 sm:mt-6 flex flex-wrap gap-3 sm:gap-4">
                <button id="checkout-button" onclick="checkout()"
                    class="px-4 sm:px-6 py-2 sm:py-3 rounded-lg text-white bg-teal-500 hover:bg-teal-600 disabled:bg-gray-600 disabled:cursor-not-allowed text-sm sm:text-base font-semibold transition-all duration-200 transform hover:scale-105"
                    disabled>
                    Bayar
                </button>
                <button onclick="resetCart()"
                    class="px-4 sm:px-6 py-2 sm:py-3 rounded-lg bg-red-500 hover:bg-red-600 text-white text-sm sm:text-base font-semibold transition-all duration-200 transform hover:scale-105">
                    Reset
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let cart = [];

            function addToCart(id, name, price) {
                const existing = cart.find(item => item.id === id);
                if (existing) {
                    existing.qty += 1;
                } else {
                    cart.push({
                        id,
                        name,
                        price,
                        qty: 1
                    });
                }
                console.log('Added to cart:', {
                    id,
                    name,
                    qty: existing ? existing.qty : 1
                });
                renderCart();
            }

            function removeFromCart(index) {
                console.log('Removing from cart at index:', index);
                cart.splice(index, 1);
                renderCart();
            }

            function changeQty(index, delta) {
                cart[index].qty += delta;
                console.log('Changed qty at index:', index, 'to:', cart[index].qty);
                if (cart[index].qty <= 0) {
                    cart.splice(index, 1);
                    console.log('Item removed due to qty <= 0');
                }
                renderCart();
            }

            function renderCart() {
                const tbody = document.getElementById('cart-body');
                tbody.innerHTML = '';
                let total = 0;

                cart.forEach((item, i) => {
                    const itemTotal = item.qty * item.price;
                    total += itemTotal;
                    tbody.innerHTML += `
                    <tr class="border-b border-gray-700 hover:bg-gray-7
                    00/50 transition-all duration-200">
                        <td class="py-2 sm:py-3 text-gray-300">${item.name}</td>
                        <td class="py-2 sm:py-3">
                            <div class="flex items-center justify-center space-x-2">
                                <button onclick="changeQty(${i}, -1)" class="bg-red-500 text-white rounded-full p-2 hover:bg-red-600 transition">
                                    <i class="fas fa-minus text-xs"></i>
                                </button>
                                <span class="min-w-[20px] text-center font-medium text-gray-300">${item.qty}</span>
                                <button onclick="changeQty(${i}, 1)" class="bg-teal-500 text-white rounded-full p-2 hover:bg-teal-600 transition">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                            </div>
                        </td>
                        <td class="text-right text-gray-300">Rp ${item.price.toLocaleString('id-ID')}</td>
                        <td class="text-right text-gray-300">Rp ${itemTotal.toLocaleString('id-ID')}</td>
                        <td><button onclick="removeFromCart(${i})" class="text-red-400 hover:text-red-300"><i class="fas fa-trash-alt"></i></button></td>
                    </tr>
                `;
                });

                const discountInput = document.getElementById('discount').value.trim();
                const errorEl = document.getElementById('discount-error');
                const tableEl = document.getElementById('table_number');
                const tableErrorEl = document.getElementById('table-error');
                const checkoutBtn = document.getElementById('checkout-button');

                let discountValue = 0;
                let isValid = true;

                if (discountInput === '') {
                    errorEl.classList.add('hidden');
                } else if (discountInput.endsWith('%')) {
                    const percent = parseFloat(discountInput.slice(0, -1));
                    if (isNaN(percent) || percent < 0 || percent > 100) {
                        isValid = false;
                    } else {
                        discountValue = total * percent / 100;
                    }
                } else {
                    const numeric = parseFloat(discountInput.replace(/[^\d]/g, ''));
                    if (isNaN(numeric)) {
                        isValid = false;
                    } else {
                        discountValue = numeric;
                    }
                }

                if (!isValid) {
                    errorEl.classList.remove('hidden');
                    checkoutBtn.disabled = true;
                } else {
                    errorEl.classList.add('hidden');
                    const totalAfterDiscount = Math.max(total - discountValue, 0);

                    document.getElementById('cart-total').textContent = total.toLocaleString('id-ID');
                    document.getElementById('cart-discount').textContent = discountValue.toLocaleString('id-ID');
                    document.getElementById('cart-pay').textContent = totalAfterDiscount.toLocaleString('id-ID');

                    checkoutBtn.disabled = (cart.length === 0 || !tableEl.value);
                    tableErrorEl.classList.toggle('hidden', tableEl.value !== '');
                }

                if (cart.length === 0) {
                    document.getElementById('cart-discount').textContent = '0';
                    document.getElementById('cart-pay').textContent = '0';
                    checkoutBtn.disabled = true;
                }

                console.log('Cart rendered:', {
                    total,
                    discount: discountValue,
                    cartLength: cart.length,
                    tableSelected: tableEl.value
                });
            }

            function resetCart() {
                cart = [];
                document.getElementById('discount').value = '';
                document.getElementById('table_number').value = '';
                document.getElementById('name').value = '';
                document.getElementById('email').value = '';
                console.log('Cart reset');
                renderCart();
            }

            function checkout() {
                const tableId = document.getElementById('table_number').value;
                const discountInput = document.getElementById('discount').value.trim();
                const name = document.getElementById('name').value;
                const email = document.getElementById('email').value;

                if (!tableId) {
                    document.getElementById('table-error').classList.remove('hidden');
                    Swal.fire({
                        title: 'Error',
                        text: 'Pilih nomor meja terlebih dahulu.',
                        icon: 'error',
                        background: '#1f2937',
                        customClass: {
                            title: 'text-coral-500',
                            content: 'text-gray-300'
                        }
                    });
                    return;
                }

                if (cart.length === 0) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Keranjang kosong!',
                        icon: 'error',
                        background: '#1f2937',
                        customClass: {
                            title: 'text-coral-500',
                            content: 'text-gray-300'
                        }
                    });
                    return;
                }

                console.log('Checkout initiated:', {
                    tableId,
                    discountInput,
                    name,
                    email,
                    items: cart
                });

                fetch("{{ route('admin.pos.order.store', ['slug' => $slug]) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            table_id: tableId,
                            discount: discountInput,
                            name,
                            email,
                            items: cart
                        })
                    })
                    .then(res => {
                        if (!res.ok) throw new Error('Network response was not ok');
                        return res.json();
                    })
                    .then(res => {
                        if (res.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Order berhasil disimpan!',
                                icon: 'success',
                                showConfirmButton: true,
                                background: '#1f2937',
                                customClass: {
                                    title: 'text-teal-400',
                                    content: 'text-gray-300'
                                }
                            }).then(() => {
                                window.location.href =
                                    "{{ route('admin.orders.print', ['slug' => $slug, 'order_code' => '__ORDER_CODE__']) }}"
                                    .replace('__ORDER_CODE__', res.order_code);
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Gagal menyimpan order: ' + (res.message || 'Unknown error'),
                                icon: 'error',
                                background: '#1f2937',
                                customClass: {
                                    title: 'text-coral-500',
                                    content: 'text-gray-300'
                                }
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Checkout error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat checkout: ' + error.message,
                            icon: 'error',
                            background: '#1f2937',
                            customClass: {
                                title: 'text-coral-500',
                                content: 'text-gray-300'
                            }
                        });
                    });
            }

            document.addEventListener('DOMContentLoaded', function() {
                console.log('POS page loaded, checking geometric background');
                const geoBackground = document.querySelector('.fixed.inset-0');
                if (geoBackground) {
                    console.log('Geometric background element found');
                    console.log('Opacity:', geoBackground.style.opacity);
                    console.log('Z-index:', geoBackground.style.zIndex);
                    console.log('Computed display:', window.getComputedStyle(geoBackground).display);
                } else {
                    console.error('Geometric background element not found');
                }

                console.log('addToCart function defined:', typeof addToCart === 'function');
                document.getElementById('discount').addEventListener('input', renderCart);
                document.getElementById('table_number').addEventListener('change', renderCart);
            });
        </script>
    @endpush
@endsection
