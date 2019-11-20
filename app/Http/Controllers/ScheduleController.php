<?php

namespace App\Http\Controllers;

use DB;
use Crypt;
use Carbon;
use App\Policy;
use App\Tenant;
use App\SMSReport;
use App\TenantSMS;
use App\TenantBill;
use App\Http\Requests;

use infobip\api\client\PreviewSms;
use infobip\api\client\SendSingleTextualSms;
use infobip\api\model\sms\mt\send\preview\Preview;
use infobip\api\configuration\BasicAuthConfiguration;
use infobip\api\model\sms\mt\send\preview\PreviewRequest;
use infobip\api\model\sms\mt\send\textual\SMSTextualRequest;

class ScheduleController extends Controller
{
    /**
     * Send Notification
     *
     * @return Response
     */
    public function index()
    {
    	$tenants = Tenant::all();
    	$now = Carbon::now()->format('H:i');
    	$today = Carbon::today()->toDateString();
        

        foreach ($tenants as $tenant) {
        	/* Check Subscription*/
        	$subscription_expiration = Carbon::parse($tenant->subscription->end_date)->toDateString();

	    	if($subscription_expiration >= $today){
	    		/* Check Tenant Alert Time */
	            $time = Carbon::parse($tenant->schedule->alert)->format('H:i');
            	
            	if($time == $now){
            		/* Check Monthly Bill */
            		$this->checkMonthlyBill($tenant->id);
            		
            		/* Get all Tenant Policies */
		        	$policies = Policy::where('tenant_id', $tenant->id)->get();

			    	foreach ($policies as $policy) {
			    		/* Get Alert Dates */
	    				$alert_one = Carbon::parse($policy->alert->alert_one)->toDateString();
	    				$alert_two = Carbon::parse($policy->alert->alert_two)->toDateString();
	    				$expiration = Carbon::parse($policy->expiration_date)->toDateString();

    					/* Alert One */
		    			if ($alert_one == $today) {			    				
				            /* Generate Message for Client */
                            $swaMessage = 
                                'Habari Ndugu '. 
                                $policy->client_name . '. Bima yako itakwisha tarehe ' . Carbon::parse($policy->expiration_date)->toFormattedDateString() . '. Tafadhali fanya malipo kwa kipindi kijacho. Kwa maelezo zaidi piga +' . $policy->tenant->sales->phone_number . '.' . PHP_EOL . 'Asante - '. $policy->tenant->name;

                            $engMessage = 
					        	'Hello '. 
                                $policy->client_name . '. Your insurance will expire on ' . Carbon::parse($policy->expiration_date)->toFormattedDateString() . '. Please make payments for the upcoming period. For more information please call +' . $policy->tenant->sales->phone_number . '.' . PHP_EOL . 'Thank You - '. $policy->tenant->name;

				            /* Select Language */
			            	foreach ($tenant->languages as $language) {
			            		if ($language->language->id == 1) {
		                            /* SMS Counter */
		                            $sms_count = $this->smsCount($swaMessage, $tenant->id);

		                         	/* Check Balance */
						            $smsBalance = $this->smsBalanceChecker($sms_count, $tenant->id);

						            if ($smsBalance) {
				            			$this->smsSender($swaMessage, $policy->phone_number, $tenant->id);

						                $this->updateBalance($sms_count, $tenant->id);

						                $this->addMonthlyBill($sms_count, $tenant->id);

						                $this->saveReport($policy->phone_number, $swaMessage, $sms_count, $tenant->id);
						            }
			            		}elseif ($language->language->id == 2) {
		                            /* SMS Counter */
		                            $sms_count = $this->smsCount($engMessage, $tenant->id);

		                         	/* Check Balance */
						            $smsBalance = $this->smsBalanceChecker($sms_count, $tenant->id);

						            if ($smsBalance) {
				            			$this->smsSender($engMessage, $policy->phone_number, $tenant->id);

						                $this->updateBalance($sms_count, $tenant->id);

						                $this->addMonthlyBill($sms_count, $tenant->id);

						                $this->saveReport($policy->phone_number, $engMessage, $sms_count, $tenant->id);
						            }
			            		}
			            	}
						}elseif ($alert_two == $today) {									    				
				            /* Generate Message for Client */
                            $swaMessage = 
                                'Habari Ndugu '. 
                                $policy->client_name . '. Bima yako itakwisha tarehe ' . Carbon::parse($policy->expiration_date)->toFormattedDateString() . '. Tafadhali fanya malipo kwa kipindi kijacho. Kwa maelezo zaidi piga +' . $policy->tenant->sales->phone_number . '.' . PHP_EOL . 'Asante - '. $policy->tenant->name;

                            $engMessage = 
					        	'Hello '. 
                                $policy->client_name . '. Your insurance will expire on ' . Carbon::parse($policy->expiration_date)->toFormattedDateString() . '. Please make payments for the upcoming period. For more information please call +' . $policy->tenant->sales->phone_number . '.' . PHP_EOL . 'Thank You - '. $policy->tenant->name;

				            /* Select Language */
			            	foreach ($tenant->languages as $language) {
			            		if ($language->language->id == 1) {
		                            /* SMS Counter */
		                            $sms_count = $this->smsCount($swaMessage, $tenant->id);

		                         	/* Check Balance */
						            $smsBalance = $this->smsBalanceChecker($sms_count, $tenant->id);

						            if ($smsBalance) {
				            			$this->smsSender($swaMessage, $policy->phone_number, $tenant->id);

						                $this->updateBalance($sms_count, $tenant->id);

						                $this->addMonthlyBill($sms_count, $tenant->id);

						                $this->saveReport($policy->phone_number, $swaMessage, $sms_count, $tenant->id);
						            }
			            		}elseif ($language->language->id == 2) {
		                            /* SMS Counter */
		                            $sms_count = $this->smsCount($engMessage, $tenant->id);

		                         	/* Check Balance */
						            $smsBalance = $this->smsBalanceChecker($sms_count, $tenant->id);

						            if ($smsBalance) {
				            			$this->smsSender($engMessage, $policy->phone_number, $tenant->id);

						                $this->updateBalance($sms_count, $tenant->id);

						                $this->addMonthlyBill($sms_count, $tenant->id);

						                $this->saveReport($policy->phone_number, $engMessage, $sms_count, $tenant->id);
						            }
			            		}
			            	}
						}elseif ($expiration == $today) {
							/* Generate Message for Client */
                            $swaMessage = 
                                'Habari Ndugu '. 
                                $policy->client_name . '. Bima yako inaisha leo tarehe ' . Carbon::parse($policy->expiration_date)->toFormattedDateString() . '. Tafadhali fanya malipo kwa kipindi kijacho. Kwa maelezo zaidi piga +' . $policy->tenant->sales->phone_number . '.' . PHP_EOL . 'Asante - '. $policy->tenant->name;

                            $engMessage = 
					        	'Hello '. 
                                $policy->client_name . '. Your insurance has expired today ' . Carbon::parse($policy->expiration_date)->toFormattedDateString() . '. Please make payments for the upcoming period. For more information please call +' . $policy->tenant->sales->phone_number . '.' . PHP_EOL . 'Thank You - '. $policy->tenant->name;

                            /* Select Language */
			            	foreach ($tenant->languages as $language) {
			            		if ($language->language->id == 1) {
		                            /* SMS Counter */
		                            $sms_count = $this->smsCount($swaMessage, $tenant->id);

		                         	/* Check Balance */
						            $smsBalance = $this->smsBalanceChecker($sms_count, $tenant->id);

						            if ($smsBalance) {
				            			$this->smsSender($swaMessage, $policy->phone_number, $tenant->id);

						                $this->updateBalance($sms_count, $tenant->id);

						                $this->addMonthlyBill($sms_count, $tenant->id);

						                $this->saveReport($policy->phone_number, $swaMessage, $sms_count, $tenant->id);
						            }
			            		}elseif ($language->language->id == 2) {
		                            /* SMS Counter */
		                            $sms_count = $this->smsCount($engMessage, $tenant->id);

		                         	/* Check Balance */
						            $smsBalance = $this->smsBalanceChecker($sms_count, $tenant->id);

						            if ($smsBalance) {
				            			$this->smsSender($engMessage, $policy->phone_number, $tenant->id);

						                $this->updateBalance($sms_count, $tenant->id);

						                $this->addMonthlyBill($sms_count, $tenant->id);

						                $this->saveReport($policy->phone_number, $engMessage, $sms_count, $tenant->id);
						            }
			            		}
			            	}
						}
			    	}
	    		}
	    	}
		}
    }

    /**
     * Remove Expired Policies
     *
     * @return Response
     */
    public function expired()
    {
        $tenants = Tenant::all();
        $past = Carbon::today()->subDays(7)->toDateString();

        foreach ($tenants as $tenant) {
            foreach ($tenant->policies as $policy) {
                if ($past >= $policy->expiration_date) {
                    $policy->alert->delete();
                    $policy->delete();
                }
            }
        }
    }

    /**
     * Check or Innitiate Monthly Bill
     */
    public function checkMonthlyBill($tenant)
    {
        $date = Carbon::now();

        $bill = TenantBill::where([
                        ['tenant_id', $tenant],
                        ['year', $date->year],
                        ['month', $date->month]
                    ])->first();
        if (!$bill) {
            $bill = new TenantBill;

            $bill->sms_count = 0;
            $bill->amount = 0;
            $bill->month = $date->month;
            $bill->year = $date->year;
            $bill->tenant_id = $tenant;

            $bill->save();
        }

        return $bill;
    }
    
    /**
     * Get SMS Count
     */
    public function smsCount($message, $tenant)
    {
        $sms = TenantSMS::where('tenant_id', $tenant)->first();

        $username =  $sms->username;
        $password =  Crypt::decrypt($sms->password);

        // Initializing PreviewSms client with appropriate configuration
        $client = new PreviewSms(new BasicAuthConfiguration($username, $password));
        $previewRequest = new PreviewRequest();
        $previewRequest->setText($message);
        $previewResponse = $client->execute($previewRequest);
        $noConfigurationPreview = $previewResponse->getPreviews()[0];
        $smsCount = $noConfigurationPreview->getMessageCount();

        return $smsCount;
    }

    /**
     * SMS Balance Checker
     */
    public function smsBalanceChecker($sms_count, $tenant)
    {
        $sms = TenantSMS::where('tenant_id', $tenant)->first();

        $balance = false;

        if (($sms_count  * $sms->price) <= $sms->balance ) {
            $balance = true;
        }

        return $balance;
    }

    /**
     * SMS Sender
     */
    public function smsSender($message, $phone_numbers, $tenant)
    {
        $sms = TenantSMS::where('tenant_id', $tenant)->first();

        $username = $sms->username;
        $password = Crypt::decrypt($sms->password);
        // Initializing SendSingleTextualSms client with appropriate configuration
        $client = new SendSingleTextualSms(new BasicAuthConfiguration($username, $password));

        // Creating request body
        $requestBody = new SMSTextualRequest();
        $requestBody->setFrom($sms->sender);
        $requestBody->setTo($phone_numbers);
        $requestBody->setText($message);

        // Executing request
        $response = $client->execute($requestBody);

        return true;
    }

    /**
     * Update Tenant SMS Balance
     */
    public function updateBalance($sms_count, $tenant)
    {
        $sms = TenantSMS::where('tenant_id', $tenant)->first();

        $sms->balance = $sms->balance - ($sms_count * $sms->price);

        $sms->save();

        return true;
    }

    /**
     * Update Monthly Bill
     */
    public function addMonthlyBill($sms_count, $tenant)
    {
        $date = Carbon::now();
        $sms = TenantSMS::where('tenant_id', $tenant)->first();

        $bill = TenantBill::where([
                            ['tenant_id', $tenant],
                            ['year', $date->year],
                            ['month', $date->month]
                        ])->first();

        $bill->sms_count += $sms_count;
        $bill->amount += ($sms_count * $sms->price);

        $bill->save();

        return true;
    }

    /**
     * Save SMS Reports
     */
    public function saveReport($phone_number, $message, $sms_count, $tenant)
    {
            $report = new SMSReport;

            $report->text = $message;
            $report->phone_number = $phone_number;
            $report->sms_count = $sms_count;
            $report->date = Carbon::now();
            $report->tenant_id = $tenant;

            $report->save();

        return true;
    }
}
