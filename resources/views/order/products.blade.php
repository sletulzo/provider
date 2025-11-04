<div class="overflow-x-auto rounded-xl border border-gray-100">
    <table class="min-w-full text-sm text-left text-gray-600">
        <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-semibold">
            <tr>
                <th scope="col" class="px-6 py-3">Article</th>
                <th scope="col" class="px-6 py-3">Quantité</th>
                <th scope="col" class="px-6 py-3">Unité</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($order->lines as $line)
                <tr class="hover:bg-gray-50 transition-all duration-200">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $line->product?->name }}</td>
                    <td class="px-6 py-4 font-medium">{{ $line->quantity }}</td>
                    <td class="px-6 py-4 font-medium">{{ $line->unity?->name }}</td>
                </tr> 
            @endforeach
        </tbody>
    </table>
</div>