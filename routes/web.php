<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('users', function () {
    // Which column to display
    $columns = [
        0 => 'name',
        1 => 'email',
        2 => 'actions'
    ];

    // Total data count
    $totalData = App\User::count();

    // Assigning data count to another variable
    $totalFiltered = $totalData;

    // Get a request input
    $start     = request()->input('start');
    $limit     = request()->input('length');
    $order     = $columns[request()->input('order.0.column')];
    $dir       = request()->input('order.0.dir');

    $users = null;

    if (empty(request()->input('search.value'))) {
        $users = App\User::offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
    } else {
        $search = request()->input('search.value');

        $users =  App\User::where('name','LIKE',"%{$search}%")
                        ->orWhere('email', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();

        $totalFiltered = $users->count();
    }

    if (! empty($users)) {
        $data = $users->map(function ($user) {
            return [
                'name'     => $user->name,
                'email'    => $user->email,
                'actions'  => "<div class=\"pull-right\"><a class=\"btn btn-info btn-sm\" href=\"{$user->id}\">Show</a>&nbsp;<a class=\"btn btn-warning btn-sm\" href=\"{$user->id}\">Edit</a>&nbsp;<a class=\"btn btn-danger btn-sm\" href=\"{$user->id}\">Delete</a></div>"
            ];
        });

        return response()->json([
            "draw"            => intval(request()->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        ], 200);
    }

})->name('users');
