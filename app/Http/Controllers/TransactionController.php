<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function transaction()
    {
        $transact = Transaction::with('user')->get();

        return view('transaction', compact('transact'));
    }

    public function order()
    {
        // $transact = Transaction::with('user')->get();
        // $transactdetail = TransactionDetail::with('mobil', 'transaction')->get();
        $ddetail = Mobil::all();

        return view('Order', [
            // 'transactdetail' => $transactdetail,
            'ddetail' => $ddetail
        ]);
    }

    public function detail()
    {
        $transactdetail = TransactionDetail::with('mobil', 'transaction')->get();

        return view('transaction-detail', compact('transactdetail'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $invoice = IdGenerator::generate([
                'table' => 'transactions',
                'length' => 10,
                'prefix' => 'INV-',
                'field' => 'invoice'
            ]);

            Transaction::create([
                'id' => Request()->id,
                'invoice' => $invoice,
                'user_id' => Auth()->id(),
                'jumlah_mobil' => Request()->jumlah_mobil
            ]);

            TransactionDetail::create([
                'id' => Request()->id,
                'invoice' => $invoice,
                'mobil_id' => Request()->mobil_id
            ]);

            $response = Http::post('http://localhost:3030/notification', [
                'req_id' => $invoice,
                'title' => 'Pemesanan berhasil',
                'description' => 'Melakukan pembelian ' . Request()->jumlah_mobil . ' mobil dengan id_mobil ' . Request()->mobil_id,
                'user' => Auth::user()->name,
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terdapat kesalahan, data telah di Rollback!');
        }

        return redirect('/',)->with('success', 'Berhasil dipesan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function orderMobil($id)
    {
        $datamobil = Mobil::findOrFail($id);

        return view('order-mobil', compact('datamobil'));
    }

    // public function mobil()
    // {
    //     $transact = Transaction::with('user')->latest()->take(1)->get();
    //     $transactdetail = TransactionDetail::with('mobil', 'transaction')->latest()->take(1)->get();

    //     return view('mobil', compact('transact'), compact('transactdetail'));
    // }

    public function notification()
    {
        $response = Http::get('http://localhost:3030/notification');
        $collection = $response->collect();
        $filtered = $collection->whereIn('user', [Auth::user()->name])->reverse();

        return view('notification', ['filtered' => $filtered]);
    }

    public function deleteNotification($id)
    {
        $response = Http::delete('http://localhost:3030/notification/' . $id);

        $collection = $response->collect();
        $filtered = $collection->whereIn('user', [Auth::user()->name])->reverse();

        return redirect()->back()->with(compact('filtered'));
    }
}