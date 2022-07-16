<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Customers;
use App\Models\PurchaseTransactions;
use App\Services\CampaignServices;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Http\Request;
use Nette\Schema\Message;

use function PHPUnit\Framework\isEmpty;

class CampaignController extends Controller
{
    private $campaignService;
    public function __construct(CampaignServices $campaignService)
    {
        $this->campaignService = $campaignService;
    }

    public function eligableCheck(Request $request,$campaignName){
        $email = $request->query('email');
        try{
            return ApiResponseFormatter::createApi(200,'Success',$this->campaignService->eligableCheck($campaignName,$email));
        }catch(Exception $ex){
            return ApiResponseFormatter::createApi(500,$ex->getMessage());
        }
    }

    public function validatePhoto(Request $request,$campaignName){
        try{
            $email = $request->query('email');
            $image = $request->file('image');
            error_log($image);
            return ApiResponseFormatter::createApi(200,'Success',$this->campaignService->validatePhoto($campaignName,$email,$image));
        }catch(Exception $ex){
            return ApiResponseFormatter::createApi(500,$ex->getMessage());
        }
    }
}
