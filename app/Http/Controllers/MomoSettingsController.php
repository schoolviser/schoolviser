<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\MomoSettingRepository;
use App\Services\MomoService;


class MomoSettingsController extends Controller
{

    protected MomoSettingRepository $momoRepository;
    protected MomoService $momoService;

    public function __construct(MomoSettingRepository $momoRepository, MomoService $momoService)
    {
        $this->momoRepository = $momoRepository;
        $this->momoService = $momoService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return $response = $this->momoService->requestToPayTransactionStatus('2b20cdef-fd6f-4aac-a04f-6b1cecc1004b');



        $response = $this->momoService->requestToPay(
            amount: '1000',
            currency: 'EUR',
            externalId: 'EXT12345',
            payer: [
                'partyIdType' => 'MSISDN',
                'partyId' => '256774285504',
            ],
            payerMessage: 'Payment for services',
            payeeNote: 'Thank you for your payment',
            callbackUrl: 'https://your-callback-url.com'
        );

        if ($response['status'] === 'success') {
            return "Request to Pay initiated successfully. Reference ID: " . $response['referenceId'];
        } else {
            return $response;
            return "Error: " . $response['message'];
        }


        $momo =  $this->momoRepository->getSettings();
        return view('admin.settings.momo.index', compact('momo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeSettings(Request $request)
    {
        $request->validate([
            'momo_api_user' => 'required',
            'momo_api_key' => 'required'
        ]);

        $data = [];

        $data['momo_api_user'] = $request->momo_api_user;
        $data['momo_api_key'] = $request->momo_api_key;

        $this->momoService->updateOrCreateSettings($data);
        return back()->withInput();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function generateAccessToken()
    {
        return $tokenDetails = $this->momoService->generateAccessToken();
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
