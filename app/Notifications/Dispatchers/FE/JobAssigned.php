<?php

namespace App\Notifications\Dispatchers\FE;

use App\Models;
use App\Notifications\Dispatchers\Interfaces;
use App\Notifications\Factory as Notifications;

class JobAssigned implements Interfaces\Dispatcher
{
    private $model;
    public function __construct(Models\Jobs $model)
    {
        $this->model = $model;
    }

    public function sendEmail($template)
    {
      $techProfile = $this->model->technicianProfile;
      $techAccount = $this->model->technicianAccount;
      
      Notifications::email()
        ->toCustomer($this->model->customer_id,
                'firstenergy-oe-pro-assigned',
                [],
                [
                  'mandrill' => [
                      'template' => $template,
                      'mergeVars' => [
                        'FNAME'       => $this->model
                                              ->customerProfile
                                              ->first_name,
                        'COMPANY' => $this->model
                                              ->proProfile
                                              ->company_name,
                        'COMPANY_ADDRESS'     => $this->model
                                              ->proProfile->address,
                        'COMPANY_CITY'        => $this->model->proProfile->city,
                        'COMPANY_STATE'       => $this->model->proProfile->state,
                        'TECH_FNAME' => $techProfile->first_name,
                        'TECH_LNAME' => $techProfile->last_name,
                        'TECH_EMAIL' => $techAccount->email,
                        'TECH_PHONE' => $techAccount->phone,
                        'EXPERIENCE_YEARS' => $techProfile->years_in_business,
                        'RATING' => round($techProfile->avg_rating,1).'/5',
                      ],
                    ],
                  ]
                  ,config('mail.FE_from')
                );
    }

    public function send()
    {
      $feProfile = $this->model->customerUser->feCustomerProfile;
     
      $company = '';
      if($feProfile)
        $company = $feProfile->sub_company;

      $template = '';
      if($company == 'OHIO-EDISON')
        $template = 'firstenergy-pe-pro-assigned';
      else
        $template = 'firstenergy-pe-pro-assigned';

      $this->sendEmail($template);
    }
}
