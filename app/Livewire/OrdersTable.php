<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;

class OrdersTable extends Component
{
    public $month;
    public $year;
    protected $listeners = ['centerMonth'];

    public function mount()
    {
        $this->month = request('month', now()->month);
        $this->year = request('year', now()->year);
    }

    public function setMonth($month)
    {
        $this->month = $month;
        $this->dispatch('scroll-month', month: $month);
    }

    public function setYear($year)
    {
        $this->year = $year;
    }

    public function render()
    {
        $user = auth()->user();

        $query = Order::query()
            ->with(['provider', 'user', 'lines'])
            ->withCount('lines')
            ->orderByDesc('created_at');

        if ($user->isCustomer() && $user->is_only_order) {
            $query->where('user_id', $user->id);
        }

        $query->whereMonth('created_at', $this->month);
        $query->whereYear('created_at', $this->year);
        $orders = $query->get();

        return view('livewire.orders-table', [
            'orders' => $orders,
        ]);
    }
}