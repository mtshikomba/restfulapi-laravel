<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Seller;

class SellerTransactionController extends ApiController
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth:api');
		$this->middleware('scope:read-general')->only('index');
		$this->middleware('can:view,seller')->only('index');
	}
    /**
     * Display a listing of the resource.
     * @param Seller $seller
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $transactions = $seller->products()
            ->whereHas('transactions')
            ->with('transactions')
            ->get()
            ->pluck('transactions')
            ->collapse();

        return $this->showAll($transactions);
    }
}
