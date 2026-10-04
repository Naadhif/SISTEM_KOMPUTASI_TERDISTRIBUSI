<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Get admin dashboard statistics
     */
    public function stats()
    {
        // Count users by role
        $usersByRole = [
            'admin' => User::where('role', 'admin')->count(),
            'seller' => User::where('role', 'seller')->count(),
            'user' => User::where('role', 'user')->count()
        ];

        // Total users
        $totalUsers = User::count();

        // Total products
        $totalProducts = Product::count();

        // Total categories
        $totalCategories = Category::count();

        // Total orders
        $totalOrders = Order::count();

        // Orders by status
        $ordersByStatus = [
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count()
        ];

        // Total revenue (sum of all delivered orders)
        $totalRevenue = Order::where('status', 'delivered')->sum('total');

        // Average order value
        $averageOrderValue = $totalOrders > 0 ? Order::avg('total') : 0;

        // Recent orders (last 10)
        $recentOrders = Order::with('user', 'details.product')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Top products by order count
        $topProducts = Product::withCount('orderDetails')
            ->orderByDesc('order_details_count')
            ->limit(5)
            ->get();

        // Stock overview (products with low stock)
        $lowStockProducts = Product::where('stock', '<', 10)
            ->with('seller')
            ->orderBy('stock')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'summary' => [
                    'total_users' => $totalUsers,
                    'total_products' => $totalProducts,
                    'total_categories' => $totalCategories,
                    'total_orders' => $totalOrders,
                    'total_revenue' => (float) $totalRevenue,
                    'average_order_value' => round((float) $averageOrderValue, 2)
                ],
                'users_by_role' => $usersByRole,
                'orders_by_status' => $ordersByStatus,
                'recent_orders' => $recentOrders,
                'top_products' => $topProducts,
                'low_stock_products' => $lowStockProducts
            ]
        ]);
    }
}
