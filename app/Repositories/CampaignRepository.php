<?php

namespace App\Repositories;

use App\Models\Campaign;

class CampaignRepository
{
    public function getByName($name){
        $campaign = Campaign::where('name',$name)->first();
        return $campaign;
    }   
}
