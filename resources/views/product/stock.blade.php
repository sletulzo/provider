<div class="form-field form-field--full">
    <label for="stock" class="form-field__label">Stock restant</label>
    <input type="number" name="stock" id="stock" step="1" value="{{ $product->getStock() }}" placeholder="Stock restant">
    <p class="form-field__hint">Quantité actuellement disponible chez le fournisseur.</p>
</div>
