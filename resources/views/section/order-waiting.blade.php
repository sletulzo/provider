<section style="width: 100%" id="sectionOrderWaiting" data-url="{{ route('section.order-waiting') }}">
    @foreach($providerOrders as $providerId => $data)
        @php ($provider = \App\Models\Provider::find($providerId))
            <h2>{{ $provider->name }}</h2>
            <div class="overflow-x-auto rounded-xl border border-gray-100 m-b-20">
                <table class="min-w-full text-sm text-left text-gray-600 layout-fixed">
                    <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-semibold">
                        <tr>
                            <th scope="col" class="px-6 py-3" style="width:20%">Produit</th>
                            <th scope="col" class="px-6 py-3" width="120px">Quantité</th>
                            <th scope="col" class="px-6 py-3">Unité</th>
                            <th scope="col" class="px-6 py-3 text-right"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($data as $datum)
                            <tr class="hover:bg-gray-50 transition-all duration-200 line" data-id="{{ $datum->id }}">
                                <td class="px-6 py-4 font-medium text-gray-900" style="width: 50%">{{ $datum->product?->name }}</td>
                                <td class="px-6 py-4 nopaddingtb">
                                    <input type="number" name="update-order-quantity" data-url="{{ route('order-waiting.update.quantity', ['orderWaiting' => $datum->id]) }}" value="{{ $datum->quantity }}">
                                </td>
                                <td class="px-6 py-4">{{ $datum->unity?->name }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('order-waiting.delete', ['orderWaiting' => $datum->id]) }}" class="confirm-delete" data-remove="line"><i class="fa-regular fa-trash-can"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    @endforeach
</section>