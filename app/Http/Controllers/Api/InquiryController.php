<?php

namespace App\Http\Controllers\Api;

use App\AppServices\Inquiry\StoreApiInquiry;
use App\Http\Controllers\Controller;
use App\Http\Requests\Inquiry\StoreInquiryRequest;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    use HttpResponses;

    public function store(StoreInquiryRequest $request, StoreApiInquiry $storeApiInquiry)
    {
        $result = $storeApiInquiry->handle($request);

        return $this->success($result['inquiry'], $result['success_message'], 201);
    }
}
