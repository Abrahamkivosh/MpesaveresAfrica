<?php

namespace App\Http\Controllers;

use App\User;
use App\Mpesa;
use Illuminate\Http\Request;
use App\Payment\MpesaGateway;
use Illuminate\Support\Facades\Auth;

class MpesaController extends Controller
{


    public function c2bCall(MpesaGateway $mpesa , Request $request)
    {


        try {
            $response = $mpesa->C2B("0708374149") ;

            return back()->with('c2b',$response) ->with('success',$response['ResponseDescription']) ;

        } catch (\Throwable $th) {
            throw $th ;
        }



    }

    public function b2cCall(MpesaGateway $mpesa , Request $request)
    {


    try {
        $response = $mpesa->B2C("0708374149",100) ;

        return back()->with('b2c',$response) ->with('success',$response['ResponseDescription']) ;

    } catch (\Throwable $th) {
        throw $th ;
    }

    }


    public function time_out_url(Request $request)
    {
        $result = Mpesa::create([
           'result' =>$request

        ]);

    }

    public function lipanampesa(MpesaGateway $mpesa , Request $request)
    {
        request()->validate(array(
            'phone' => 'required|numeric',
        ));
        $phone = $request->phone;
        $amount = $request->amount;


        try {
            $response =   $mpesa->LipaNaMPesaOnlineAPI($phone, $amount);
            Mpesa::create([
                'user_id' => auth()->user()->id,
                'merchantRequestID' => $response['MerchantRequestID'],
                'checkoutRequestID' => $response['CheckoutRequestID'],
                'responseCode' => $response['ResponseCode'],
                'responseDescription' => $response['ResponseDescription'],
                'customerMessage' => $response['CustomerMessage'],
                'phoneNumber' => $phone,
                'amount' => $amount,
            ]);
            return back()->with('success', $response['CustomerMessage'])
            ->with('lipanampesa',$response) ;
        } catch (\Throwable $th) {
            return $th ;//  back()->with('error', $response['errorMessage']);
        }

    }

    public function handle_result(Request $request)
    {
        $data = $request->all();
        $data = $data['Body']['stkCallback'];
        $result = Mpesa::where('checkoutRequestID', $data['CheckoutRequestID'])->where('active', true)->first();
        $result->active = false;
        $result->result = json_encode($data);
        $result->save();

        if($result == null || $result->merchantRequestID != $data['MerchantRequestID'])
            return null;
        $result->resultCode = $data['ResultCode'];
        $result->resultDesc = $data['ResultDesc'];
        $result->save();
        if($result->resultCode == 0){
            $items = $data['CallbackMetadata']['Item'];
            foreach($items as $item){
                if($item['Name'] == 'Amount' && array_key_exists('Value', $item))
                    $result->amount = $item['Value'];
                elseif($item['Name'] == 'MpesaReceiptNumber' && array_key_exists('Value', $item))
                    $result->mpesaReceiptNumber = $item['Value'];
                elseif($item['Name'] == 'Balance' && array_key_exists('Value', $item))
                    $result->balance = $item['Value'];
                elseif($item['Name'] == 'TransactionDate' && array_key_exists('Value', $item))
                    $result->transactionDate = date('Y-m-d H:i:s', strtotime($item['Value']));
            }
            $result->save() ;
        }

    }


    public function reverse(MpesaGateway $mpesa , Request $request)
    {

        try {
            $response = $mpesa->ReversalAPI("LGR019G3J2",20);

            return back()
            ->with('reversepesa',$response) ;

        } catch (\Throwable $th) {
            throw $th ;
        }

    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mpesa  $mpesa
     * @return \Illuminate\Http\Response
     */
    public function show(Mpesa $mpesa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mpesa  $mpesa
     * @return \Illuminate\Http\Response
     */
    public function edit(Mpesa $mpesa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mpesa  $mpesa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mpesa $mpesa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mpesa  $mpesa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mpesa $mpesa)
    {
        //
    }
}
