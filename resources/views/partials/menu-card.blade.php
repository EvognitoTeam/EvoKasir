<div @click="$dispatch('open-menu-modal', { 
        name: '{{ e($product->name) }}', 
        description: '{{ e($product->description) }}', 
        stock: '{{ $product->stock }}',
        price: '{{ $product->formatted_price }}',
        image: '{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400x300/1f2937/FFFFFF?text=Menu' }}',
        addUrl: '{{ route('cart.add', ['slug' => $slug, 'id' => $product->id]) }}'
    })"
    class="bg-gray-800/80 backdrop-blur-md rounded-2xl shadow-lg p-4 group hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1 animate-scale-in cursor-pointer"
    style="animation-delay: {{ $loop->index * 0.1 }}s;">
    <div class="flex gap-4">
        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/150x150/1f2937/FFFFFF?text=Menu' }}"
            alt="{{ $product->name }}" class="w-24 h-24 object-cover rounded-lg flex-shrink-0">
        <div class="flex flex-col">
            <h3 class="text-lg font-semibold text-coral-500 line-clamp-1 group-hover:text-coral-400">{{ $product->name }}
            </h3>
            <p class="text-gray-400 text-sm line-clamp-2 flex-grow">{!! Illuminate\Support\Str::limit(strip_tags($product->description), 70) !!}</p>
            <p class="text-teal-400 font-semibold text-base mt-2">{{ $product->formatted_price }}</p>
        </div>
    </div>
</div>
