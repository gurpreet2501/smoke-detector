<?php

namespace App\Notifications\Dispatchers\FE;

use App\Models;
use App\Notifications\Dispatchers\Interfaces;
use App\Notifications\Factory as Notifications;

class JobCreated implements Interfaces\Dispatcher
{
    private $model;
    public function __construct(Models\Jobs $model)
    {
        $this->model = $model;
    }

    public function sendText(){

      	Notifications::sms()
            ->toCustomer(
              $this->model->customer_id,
              'customer-job-created', 
              [ 'job' => $this->model ]
            );
    }

    public function sendEmail($mandrillTemplate)
    {
      
      Notifications::email()
        ->toCustomer($this->model->customer_id,
                'fixd-consumer-job-scheduled-success',
                [], [
                  'mandrill' => [
                      'template' => $mandrillTemplate,
                       'mergeVars' => [
                          'REPAIR_TYPE' => $this->model->makeTitle(), 
                          'FNAME'  => $this->model->customer->first_name,
                          'LNAME' => $this->model->customer->last_name, 
                          'FULL_ADDRESS' => $this->model->jobCustomerAddresses->formatted(), 
                          'SCHEDULED_DATE' => $this->model->customerFormattedRequestDate(), 
                          'SCHEDULED_TIME' => $this->model->timeSlot->formatted(), 
                          'EMAIL' => $this->model->customer->users->email, 
                       ],
                    ],
                  ]
                  ,config('mail.FE_from')
                );
    }

     public function sendEmailToStaff()
    {

      $emails = explode(",",env('MAIL_STAFF'));
      
      if(empty($emails)){
        return false;
      }

      $job = $this->model;

      Notifications::email()
        ->toAddress($emails, 'fixd-staff-job-scheduled-success' ,
                [
                  'jobId' => $job->id,
                  'jobTitle' => $this->model
                                ->makeTitle(),
                  'requestDate' => $job->customerFormattedRequestDate(),
                  'customerName' => $job->contact_name
                ]);
    }

    public function send()
    { 
      $feProfile = $this->model->customerUser->feCustomerProfile;
     
      $company = '';
      if($feProfile)
        $company = $feProfile->sub_company;

      $template = '';
      if($company == 'OHIO-EDISON')
        $template = 'firstenergy-oe-job-scheduled';
      else
        $template = 'firstenergy-pe-job-scheduled';
      

      $this->sendEmail($template);
      $this->sendEmailToStaff();

      //$this->sendText();
    }
}
