<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Purchase;
use App\Services\CentralPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PurchaseController extends Controller
{
    protected $centralPayService;

    public function __construct(CentralPayService $centralPayService)
    {
        $this->centralPayService = $centralPayService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::with(['plan', 'user'])->get();
        return response()->json($purchases);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => 'required|integer|exists:plans,id',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $plan = Plan::find($validated['plan_id']);

        $purchase = Purchase::create([
            'plan_id' => $validated['plan_id'],
            'user_id' => $validated['user_id'],
            'total' => $plan->price,
            'method' => 'CentralPay'
        ]);

        return response()->json([
            'purchase' => $purchase,
            'payment_form_url' => 'https://google.com',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
