<?php
namespace laravelApp\ShoppingCart;

use Illuminate\Support\ServiceProvider;

class ShoppingCartServiceProvider extends ServiceProvider
{
    public function boot(){
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'shoppingcart');
        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');

    }
    public function register(){

    }
}
