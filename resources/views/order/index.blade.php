<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-pencil"></i> Commandes effectuées
        </h2>
    </x-slot>

    <div class="table-wrapper">

       <form method="GET" class="orders-filters">
            <input type="hidden" name="month" id="month-input" value="{{ $month }}">
            
            <div class="orders-filters-title">
                Filtrer les commandes
            </div>

            {{-- Mois slider --}}
            <div class="orders-months">
                @foreach(range(1,12) as $m)
                    @php
                        $label = \Carbon\Carbon::create()->month($m)->locale('fr')->translatedFormat('F');
                    @endphp

                    <button
                        type="button"
                        class="orders-month-item {{ $month == $m ? 'active' : '' }}"
                        onclick="setMonth({{ $m }})">
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            {{-- Année + actions --}}
            <div class="orders-filters-bottom">
                <select name="year" class="orders-select" onchange="this.form.submit()">
                    @foreach(range(date('Y'), date('Y') - 4) as $y)
                        <option value="{{ $y }}" @selected(request('year') == $y)>
                            {{ $y }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        {{-- 🔥 TABLE DESKTOP --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Articles</th>
                        <th>Date</th>
                        <th>Fournisseur</th>
                        <th>Créateur</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($orders as $order)
                        <tr class="hover:bg-gray-50 transition line">
                            <td>{{ $order->id }}</td>
                            <td>Commande</td>

                            {{-- 🔥 FIX N+1 --}}
                            <td>{{ $order->lines_count }}</td>

                            <td>{{ carbon($order->created_at)->format('d/m/Y') }}</td>
                            <td>{{ $order->provider?->name }}</td>
                            <td>{{ $order->user?->name }}</td>

                            <td class="text-right">
                                <a href="{{ route('orders.products', $order) }}">
                                    <i class="fa-solid fa-table-cells-large"></i>
                                </a>

                                <a href="{{ route('orders.delete', $order) }}" class="confirm-delete">
                                    <i class="fa-regular fa-trash-can"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- 📱 MOBILE CARD VIEW --}}
        <div class="block sm:hidden">
            <div id="orders-container" class="space-y-3">
                @foreach($orders as $order)
                    @if (Auth::user()->isProvider())
                        @include('order.provider-card', ['order' => $order])
                    @else
                        @include('order.card', ['order' => $order])
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function setMonth(month) {
        document.getElementById('month-input').value = month;
        document.querySelector('.orders-filters').submit();
    }
</script>