<?php

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/customers', function (Request $request) {
    $search = $request->input('q'); 

    $customers = Customer::where('name', 'like', "%{$search}%") 
        ->limit(10) 
        ->get(['id', 'name']); 

    return response()->json([
        'results' => $customers->map(function ($customer) {
            return [
                'id' => $customer->id,
                'text' => $customer->name 
            ];
        })
    ]);
});


