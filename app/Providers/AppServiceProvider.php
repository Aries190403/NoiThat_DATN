<?php

namespace App\Providers;

use App\Models\cart;
use App\Models\Category;
use App\Models\favorite;
use App\Models\product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Lấy danh mục có trạng thái 'normal'
        $categories = Category::where('status', 'normal')->get();
        View::share('globalCategory', $categories);

        view()->composer('*', function ($view) {
            if (Auth::check()) {
                $userId = Auth::id();
                $favorites = Favorite::where('user_id', $userId)->get();

                $products = [];
                foreach ($favorites as $item) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $products[] = $product;
                    }
                }


                $view->with('favorites', $products);
            }
        });

        view()->composer('*', function ($view) {
            if (Auth::check()) {
                $cartItems = session()->get('cart', []);

                $products = [];
                foreach ($cartItems as $item) {
                    $product = Product::find($item['product_id']);
                    if ($product) {
                        $product->quantity = $item['quantity'];
                        $products[] = $product;
                    }
                }

                $view->with('globalCart', $products);
            }
        });
    }
}
