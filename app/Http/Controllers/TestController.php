<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Any;

use App\Momo\Product\Collection;

use App\Services\MomoService;

class TestController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {

        $collection = new Collection();


       return $collection->createInvoice('123456780', '256774285504', '50000');
        return $collection->getInvoiceStatus('1b5c9db5-70e7-4e2d-8129-e1c03186b4e0"');


        //return $collection->sendRequesttoPayDeliveryNotification('865ffdee-101b-494c-abf3-ba34618c7391', 'hello dude');

        //return $collection->getRequestToPayTransactionStatus('bffc1cd3-12fc-4f6f-bbb2-7902bdb90c29');

        //return $collection->getAccessToken();

       // return $collection->requestToPay('hello', '256774285504', 100);

    }

}
