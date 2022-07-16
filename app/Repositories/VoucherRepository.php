<?php

namespace App\Repositories;

use App\Models\Voucher;

class VoucherRepository{
    protected $voucher;
    public function __construct(Voucher $voucher){
        $this->voucher = $voucher;
    }

    public function findVoucherNotClaim($campaignId){
        return $this->voucher->where('campaign_id',$campaignId)
                    ->where('is_pending',false)
                    ->where('status_claim',false)->first();
    }

    public function findVoucherHasClaimByCustomerId($customerId,$campaignId){
        return $this->voucher->where('claim_by',$customerId)
                        ->where('campaign_id',$campaignId)->first();
    }

    public function updateVoucher($req){
        $data = $this->voucher->find($req->id);
        $data->is_pending = $req['is_pending'];
        $data->claim_by=$req['claim_by'];
        $data->status_claim=$req['status_claim'];
        $data->claim_expired_at =$req['claim_expired_at'];
        $data->update();
    }
}