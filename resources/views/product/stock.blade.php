<hr>

<div>
    <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock restant</label>
    <input type="number" name="stock" id="stock" step="1" value="{{ $product->getStock() }}"
            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
            placeholder="Stock restant">
</div>