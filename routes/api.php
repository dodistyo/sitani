<?php

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Product;
use App\Invoice;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/produk/{id}', function ($id) {
    $products = Product::all();
    $product = $products->find($id);
    return response()->json($product);
});

Route::get('/dashboard', function (Request $request) {
    $client = new Client();
    $res = $client->request('GET', 'http://172.16.12.38:5000/avocado');
    $status_code = $res->getStatusCode();
    // 200
    $header = $res->getHeader('content-type');
    // 'application/json; charset=utf8'
    $result = json_decode($res->getBody());
    // {"type":"User"...'
    $usd = 1;
    foreach ($result as $item) {
        $usd = $item->yhat;
    }
    $prediction = $usd * 13740.20;
    $products = Product::all();
    $data['cost'] = $products->sum('cost');
    $data['revenue'] = Invoice::all()->sum('total');
    $data['profit'] = $data['revenue'] - $data['cost'];
    $data['prediction'] = round($prediction);
    return response()->json($data);
});



