<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Artisan;
use App\Models\Post;

// route to web /
Route::get('/', function () {
  $posts = Post::where('status', 'published')->latest()->take(3)->get();
  return view('landing', ['posts' => $posts]);
});

Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

//Maintenance route
Route::get('/clear/{option?}', function ($option = null) {
  $logs = [];
  // if option is 'prod' then run composer install -autoloader --no-dev
  if ($option == 'prod') {
    $logs['Composer Install for PROD'] = Artisan::call('composer optimize-autoloader --no-dev');
  }

  $maintenance = ($option == "cache") ? [
    'Flush' => 'cache:flush',
  ] : [
    //'DebugBar'=>'debugbar:clear',
    'Storage Link' => 'storage:link',
    'Config' => 'config:clear',
    'Optimize Clear' => 'optimize:clear',
    'Optimize' => 'optimize',
    'Route Clear' => 'route:clear',
    'Route Cache' => 'route:cache',
    'View Clear' => 'view:clear',
    'View Cache' => 'view:cache',
    'Cache Clear' => 'cache:clear',
    'Cache Config' => 'config:cache',
  ];

  foreach ($maintenance as $key => $value) {
    try {
      Artisan::call($value);
      $logs[$key] = '✔️';
    } catch (\Exception $e) {
      $logs[$key] = '❌' . $e->getMessage();
    }
  }
  return "<pre>" . print_r($logs, true) . "</pre><hr />";
});

Volt::route('/login', 'login')->name('login');

Route::get('/logout', function () {
  auth()->logout();
  request()->session()->invalidate();
  request()->session()->regenerateToken();
  request()->session()->flush();
  return redirect('/');
});

// Protected routes
Route::middleware(['auth', 'admin'])->group(function () {
  Volt::route('/register', 'register')->name('register');
  Volt::route('/dashboard', 'dashboard');
  Volt::route('/users', 'users.index');
  Volt::route('/user/{user?}', 'users.crud');
  Volt::route('/carlos', 'carlos');
  Volt::route('/posts', 'posts.index');
  Volt::route('/post/{post?}', 'posts.crud');
  Volt::route('/products', 'products.index');
  Volt::route('/product/{product?}', 'products.crud');
  Volt::route('/categories', 'category.index');
  Volt::route('/category/{category?}', 'category.crud');
  Volt::route('/budgets', 'budget.index');
  Volt::route('/budgets/{budget?}', 'budget.detail');
  Volt::route('/budget/{budget?}', 'budget.crud');
});

Route::middleware(['auth'])->group(function () {
  Volt::route('/budgets', 'budget.index');
  Volt::route('/budgets/{budget}/view', 'budget.user-show');
});
