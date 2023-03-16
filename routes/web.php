<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('give-permission-to-role', function(){
    $role = Role::findOrFail(1);

    $permission = Permission::findOrFail(1);

    $role->givePermissionTo([$permission]);
});

Route::get('assign-role-to-user', function (){
$user = User::create([
    'name' => 'multirole',
    'email' => 'user@gmail.com',
    'password' => 'user1933'
]);

    $role = Role::findOrFail(1);
    $role1 = Role::findOrFail(2);            
    $role2 = Role::findOrFail(3);

    $user->assignRole([$role,$role1,$role2]);
});

Route::get('spatie-method', function (){
    $user = User::FindOrFail(2);
    dd($user->getRoleNames());
});

$user = User::FindOrfail(1); //login as user 1
Auth::login($user);
// Auth::logout();

Route::get('create-article', function (){
    dd('ini adalah fitur create article hanya bisa diakses oleh author/moderator');
})->middleware('role:author|moderator');

Route::get('edit-article', function (){
    dd('ini adalah fitur edit article hanya bisa diakses oleh editor/moderator');
})->middleware('role:editor|moderator');

Route::get('delete-article', function (){
    dd('ini adalah fitur delete article hanya bisa diakses oleh moderator');
})->middleware('role:moderator');

Route::get('transformer', function (){
    $collection = collect([1, 2, 3, 4, 5]);

    $collection->transform(function ($item, $key) {
        return $item * 2;
    });
    
    $collection->all();
    dd($collection);
});

Route::get('collection', function (){
   
    // $numbers = [9,3,4,6,7,4,9,4,2,5,7,9,3,6,7,8,2];

    // $average = collect($numbers)->filter(function ($value){
//     return $value > 5;
    // })->all();

    $restaurantA = collect([1 =>  ['A'], 2 => [ 'B']]);

    $union = $restaurantA->union([3 => ['C']]);

    $union->all();

    // $diff = collect($restaurantA)->diff($restaurantB);

    // $biodata = [
    //     ['nama' => 'budi', 'umur' => 17],
    //     ['nama' => 'reni', 'umur' => 14],
    //     ['nama' => 'siti', 'umur' => 15],
    //     ['nama' => 'anwar', 'umur' => 19],
    // ];

    // $plug = collect($biodata)->pluck('nama')->all();
    dd($union);


});
