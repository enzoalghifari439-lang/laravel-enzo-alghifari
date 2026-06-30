@extends('layouts.app')

@section('content')
<div class=\"container mx-auto px-4 py-8\">
    <div class=\"mb-8 flex justify-between items-center\">
        <div>
            <h1 class=\"text-4xl font-bold text-gray-800\">📊 Dashboard Analytics</h1>
            <p class=\"text-gray-600 mt-2\">Real-time business insights and analytics</p>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class=\"grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8\">
        <div class=\"bg-white rounded-lg shadow p-6 border-l-4 border-blue-500\">
            <p class=\"text-gray-600 text-sm font-semibold\">Total Produk</p>
            <p class=\"text-3xl font-bold text-gray-800 mt-2\">{{ $total_products }}</p>
        </div>

        <div class=\"bg-white rounded-lg shadow p-6 border-l-4 border-green-500\">
            <p class=\"text-gray-600 text-sm font-semibold\">Total Supplier</p>
            <p class=\"text-3xl font-bold text-gray-800 mt-2\">{{ $total_suppliers }}</p>
        </div>

        <div class=\"bg-white rounded-lg shadow p-6 border-l-4 border-purple-500\">
            <p class=\"text-gray-600 text-sm font-semibold\">Total Penjualan</p>
            <p class=\"text-3xl font-bold text-gray-800 mt-2\">{{ $total_sales }}</p>
        </div>

        <div class=\"bg-white rounded-lg shadow p-6 border-l-4 border-red-500\">
            <p class=\"text-gray-600 text-sm font-semibold\">Pendapatan Bulanan</p>
            <p class=\"text-3xl font-bold text-gray-800 mt-2\">Rp {{ number_format($monthly_revenue, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Top Products -->
    <div class=\"bg-white rounded-lg shadow p-6 mb-8\">
        <h3 class=\"text-lg font-semibold text-gray-800 mb-4\">🏆 Top 10 Produk</h3>
        <div class=\"overflow-x-auto\">
            <table class=\"w-full text-sm\">
                <thead class=\"bg-gray-100\">
                    <tr>
                        <th class=\"px-4 py-2 text-left\">Produk</th>
                        <th class=\"px-4 py-2 text-right\">Qty</th>
                        <th class=\"px-4 py-2 text-right\">Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($top_products as $item)
                    <tr class=\"border-b\">
                        <td class=\"px-4 py-2\">{{ $item['product']['name'] ?? 'N/A' }}</td>
                        <td class=\"px-4 py-2 text-right\">{{ $item['total_quantity'] }}</td>
                        <td class=\"px-4 py-2 text-right\">Rp {{ number_format($item['total_revenue'], 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Customers -->
    <div class=\"bg-white rounded-lg shadow p-6\">
        <h3 class=\"text-lg font-semibold text-gray-800 mb-4\">👥 Top Customer</h3>
        <div class=\"overflow-x-auto\">
            <table class=\"w-full text-sm\">
                <thead class=\"bg-gray-100\">
                    <tr>
                        <th class=\"px-4 py-2 text-left\">Customer</th>
                        <th class=\"px-4 py-2 text-right\">Pembelian</th>
                        <th class=\"px-4 py-2 text-right\">Total Belanja</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($top_customers as $item)
                    <tr class=\"border-b\">
                        <td class=\"px-4 py-2\">{{ $item['customer']['name'] ?? 'N/A' }}</td>
                        <td class=\"px-4 py-2 text-right\">{{ $item['total_purchases'] }}x</td>
                        <td class=\"px-4 py-2 text-right\">Rp {{ number_format($item['total_spent'], 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
