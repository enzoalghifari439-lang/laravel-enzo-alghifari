<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\Customer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $cacheKey = 'dashboard_analytics_' . today()->format('Y-m-d');

        $dashboardData = Cache::remember($cacheKey, 86400, function () {
            return [
                'total_products' => $this->getTotalProducts(),
                'total_suppliers' => $this->getTotalSuppliers(),
                'total_sales' => $this->getTotalSales(),
                'monthly_revenue' => $this->getMonthlyRevenue(),
                'top_products' => $this->getTopProducts(),
                'top_customers' => $this->getTopCustomers(),
                'sales_chart_data' => $this->getSalesChartData(),
                'revenue_trend' => $this->getRevenueTrend(),
            ];
        });

        return view('dashboard.index', $dashboardData);
    }

    private function getTotalProducts(): int
    {
        return Product::count();
    }

    private function getTotalSuppliers(): int
    {
        return Supplier::count();
    }

    private function getTotalSales(): int
    {
        return Sale::whereMonth('sale_date', Carbon::now()->month)
            ->whereYear('sale_date', Carbon::now()->year)
            ->count();
    }

    private function getMonthlyRevenue(): float
    {
        $revenue = Sale::whereMonth('sale_date', Carbon::now()->month)
            ->whereYear('sale_date', Carbon::now()->year)
            ->sum('total_price');

        return floatval($revenue) ?? 0;
    }

    private function getTopProducts(): array
    {
        return Sale::select('product_id', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(total_price) as total_revenue'))
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_revenue')
            ->limit(10)
            ->get()
            ->toArray();
    }

    private function getTopCustomers(): array
    {
        return Sale::select('customer_id', DB::raw('COUNT(*) as total_purchases'), DB::raw('SUM(total_price) as total_spent'))
            ->with('customer')
            ->groupBy('customer_id')
            ->orderByDesc('total_spent')
            ->limit(10)
            ->get()
            ->toArray();
    }

    private function getSalesChartData(): array
    {
        $monthlyData = Sale::select(
            DB::raw('DATE_TRUNC(\'month\', sale_date) as month'),
            DB::raw('COUNT(*) as total_sales'),
            DB::raw('SUM(total_price) as total_revenue')
        )
            ->whereBetween('sale_date', [
                Carbon::now()->subMonths(12),
                Carbon::now(),
            ])
            ->groupBy(DB::raw('DATE_TRUNC(\'month\', sale_date)'))
            ->orderBy('month')
            ->get();

        return $monthlyData->toArray();
    }

    private function getRevenueTrend(): array
    {
        return Sale::select(
            DB::raw('DATE(sale_date) as date'),
            DB::raw('SUM(total_price) as revenue')
        )
            ->whereBetween('sale_date', [
                Carbon::now()->subDays(30),
                Carbon::now(),
            ])
            ->groupBy(DB::raw('DATE(sale_date)'))
            ->orderBy('date')
            ->get()
            ->toArray();
    }

    public function clearCache()
    {
        Cache::forget('dashboard_analytics_' . today()->format('Y-m-d'));
        return back()->with('success', 'Dashboard cache cleared');
    }
}