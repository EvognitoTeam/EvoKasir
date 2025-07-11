<div x-data="{
    show: false,
    name: '',
    description: '',
    stock: '',
    price: '',
    image: '',
    addUrl: '',
    isAdding: false,
    added: false
}"
    @open-menu-modal.window="
        show = true;
        name = $event.detail.name;
        description = $event.detail.description;
        stock = $event.detail.stock;
        price = $event.detail.price;
        image = $event.detail.image;
        addUrl = $event.detail.addUrl;
        added = false;
    "
    x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4"
    @keydown.escape.window="show = false">
    <div @click.away="show = false"
        class="bg-gray-800 rounded-2xl shadow-lg max-w-lg w-full p-6 m-4 relative animate-scale-in">
        <button @click="show = false" class="absolute top-4 right-4 text-gray-400 hover:text-white">&times;</button>
        <img :src="image" :alt="name" class="w-full h-48 object-cover rounded-lg mx-auto mb-4">
        <h3 class="text-2xl font-bold text-coral-500" x-text="name"></h3>
        <p class="text-gray-400 mt-2 text-sm" x-html="description"></p>

        <div class="flex justify-between items-center mt-4 text-sm">
            <p class="text-gray-300">Stok: <span class="font-semibold" x-text="stock"></span></p>
            <p class="text-teal-400 text-lg font-bold" x-text="price"></p>
        </div>

        <button
            @click="
                isAdding = true;
                fetch(addUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ quantity: 1 })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        added = true;
                        // Dispatch event untuk update cart count
                        $dispatch('cart-updated'); 
                        setTimeout(() => show = false, 1000);
                    } else {
                        alert(data.message || 'Gagal menambahkan');
                    }
                })
                .finally(() => isAdding = false)
            "
            :disabled="isAdding || added" class="w-full mt-6 py-3 rounded-lg text-white font-bold transition-colors"
            :class="{ 'bg-teal-500 hover:bg-teal-600': !added, 'bg-green-500': added }">
            <span x-show="!isAdding && !added">Tambah ke Keranjang</span>
            <span x-show="isAdding">Menambahkan...</span>
            <span x-show="added">Berhasil Ditambahkan <i class="fas fa-check"></i></span>
        </button>
    </div>
</div>
