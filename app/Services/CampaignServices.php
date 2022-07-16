<?php

namespace App\Services;

use App\Repositories\CampaignRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\PurchaseTransactionRepository;
use App\Repositories\VoucherRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class CampaignServices
{
    private $campaignRepository ;
    private $purchaseTransactionRepository;
    private $voucherRepository;
    private $customerRepository;

    public function __construct(CampaignRepository $campaignRepository,PurchaseTransactionRepository $purchaseTransactionRepository,
    VoucherRepository $voucherRepository,CustomerRepository $customerRepository){
        $this->campaignRepository = $campaignRepository;  
        $this->purchaseTransactionRepository = $purchaseTransactionRepository;
        $this->voucherRepository = $voucherRepository;
        $this->customerRepository = $customerRepository;
    }

    /**
     * Cek Eligable customer to get voucher
     *  - Cek available campaign
     *  - Cek customer
     *  - cek already has been claim voucher
     *  - cek voucher available
     *  - if(customer eligable to claim voucher) lock voucher expired after 10 minutes 
     * @param string $campaignName A name of campaign
     * @param string $email A email from customer
     * @return status eligable  
     */
    public function eligableCheck($campaignName,$email){
        $campaign = $this->cekCampaignAvailable($campaignName);
        $customerId = $this->cekCustomerByEmail($email);    
        
        $voucherHasClaim = $this->voucherRepository->findVoucherHasClaimByCustomerId($customerId,$campaign->id);
        if($voucherHasClaim)throw new Exception("customer has been claim");
        DB::beginTransaction();
        $voucher = $this->voucherRepository->findVoucherNotClaim($campaign->id);
        if(!$voucher)throw new Exception("Voucher not available");

        $cekPurchase = $this->cekPurchaseTransaction($customerId);
        if(!$cekPurchase) throw new Exception('purchase transaction not eligible');

        //lock voucher to customer expires after 10 minutes
        if($voucher){
            $voucher->claim_by = $customerId;
            $voucher->claim_expired_at = now()->addMinutes(10);
            $voucher->is_Pending = true;
            $this->voucherRepository->updateVoucher($voucher);
            DB::commit();
        }else{
            DB::rollBack();
            throw new Exception('vouchers not exist');
        }
        return "Customer Qualified to get Voucher";
    }

    public function cekCampaignAvailable($campaignName)
    {
        $campaign = $this->campaignRepository->getByName($campaignName);
        if(!$campaign)throw new Exception("campaign not found");
        $date = now();
        if($date < $campaign->start_campaign || ($campaign->end_campaign 
            && $date > $campaign->end_campaign)) throw new Exception("campaign_not_available");
        return $campaign;
    }

    /**
     * Cek Purchase transaction customer 
     * @param string $customerId A id from customer
     * @return true if condition  Complete 3 purchase transactions within the last 30 days
     * and Total transactions equal or more than $100 
     * @return true if not quilified
     */
    public function cekPurchaseTransaction($customerId){  
        $filterDate = now()->addMonth(-1);
        $purch_transaction = $this->purchaseTransactionRepository
                ->findByCustomerIdAndTransactionAt($customerId,$filterDate);
        if($purch_transaction->count()<3) return false;
        $total_trans = $purch_transaction->sum("total_spent");
        if($total_trans < 1499640.00) return false;        
        return true;
    }    

    /**
     * Validate photo customer
     * - Call the image recognition API to validate the photo submission qualification.
     * - check whether the voucher has exceeded 10 minutes from the time you first claimed the voucher
     * - If the result return is false or submission exceeds 10 minutes, remove the lock
     *   down and this voucher will become available to the next customer to grab.
     * @param string $campaignName A name from campaign
     * @param string $email A email from customer
     * @return code voucher or error message if photo not qualified;
     */
    public function validatePhoto($campaignName,$email,$img){  
        $campaign = $this->campaignRepository->getByName($campaignName);
        if(!$campaign) throw new Exception("campaign not found");
        $customerId = $this->cekCustomerByEmail($email);
        DB::beginTransaction();
        $voucherLock = $this->voucherRepository->findVoucherHasClaimByCustomerId($customerId,$campaign->id);
        if(!$voucherLock) throw new Exception("voucher not availale");
        if($voucherLock->status_claim) throw new Exception("voucher has been claim");
        if($voucherLock->is_pending && $voucherLock->claim_expired_at < now()){
            $voucherLock->is_pending = false;
            $voucherLock->claim_by = null;
            $voucherLock->claim_expired_at = null;
            $this->voucherRepository->updateVoucher($voucherLock);
            DB::commit();
            throw new Exception("voucher expired");
        } 

        $isRecognition = $this->recognitionApi($img);
        if(!$isRecognition){
            $voucherLock->is_pending = false;
            $voucherLock->claim_by = null;
            $voucherLock->claim_expired_at = null;
            $this->voucherRepository->updateVoucher($voucherLock);
            DB::commit();
            throw new Exception("photo not qualified");
        } 

        $voucherLock->is_pending = false;
        $voucherLock->status_claim = true;
        $voucherLock->claim_expired_at = null;
        try{
            $this->voucherRepository->updateVoucher($voucherLock);
            DB::commit();
        }catch(Exception $ex){
            DB::rollback();
            throw new Exception(`Error when claim voucher {$ex}`);
        }
        return $voucherLock->code_voucher;
    }

    /**
     * Call ap recognition to valdate img
     *
     * @param $img $img A file photo to validate on recognitionApi
     * @return code voucher or error message if photo not qualified;
     */
    public function recognitionApi($img){
        //call api recognition
        return true;
    } 

    /**
     * Cek customer by email
     *
     * @param string $email A email from customer
     * @return customer id , error message if null;
     */
    public function cekCustomerByEmail($email){
        $customer = $this->customerRepository->findByEmail($email);
        if(!$customer)throw new Exception("customer not found");
        return $customer->id;
    }
}