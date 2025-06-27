<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company_name' => 'nullable|string|max:255',
            'website_url' => 'nullable|url|max:255',
            'website_type' => 'required|string',
            'platform' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $lead = Lead::create($request->only([
            'name', 'email', 'company_name', 'website_url', 'website_type', 'platform'
        ]));

        // OneSignal Push Notification Integration
        $onesignalAppId = config('services.onesignal.app_id');
        $onesignalApiKey = config('services.onesignal.api_key');
        $onesignalUrl = 'https://onesignal.com/api/v1/notifications';
        $notificationStatus = null;
        $notificationError = null;
        $notificationResponse = null;

        try {
            $payload = [
                'app_id' => $onesignalAppId,
                'included_segments' => ['All'],
                'headings' => ['en' => 'New Lead Submitted'],
                'contents' => ['en' => 'A new user has submitted the registration form'],
            ];

            \Log::info('OneSignal Request Payload', $payload);

            $client = new Client();
            $onesignalRes = $client->post($onesignalUrl, [
                'headers' => [
                    'Authorization' => 'Basic ' . $onesignalApiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
            ]);

            $notificationResponse = json_decode($onesignalRes->getBody()->getContents(), true);
            $notificationStatus = 'success';
            \Log::info('OneSignal Response', $notificationResponse);
        } catch (\Exception $e) {
            $notificationStatus = 'error';
            $notificationError = 'Failed to send push notification. Please try again later.';
            \Log::error('OneSignal Error', ['error' => $e->getMessage()]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Lead captured successfully!',
            'lead' => $lead,
            'notification_status' => $notificationStatus,
            'notification_response' => $notificationResponse,
            'notification_error' => $notificationError,
        ]);
    }

    public function getPlatforms($type)
    {
        $platforms = [];

        switch ($type) {
            case 'ecommerce':
                $platforms = ['Shopify', 'Magento', 'WooCommerce', 'BigCommerce'];
                break;
            case 'blog':
                $platforms = ['WordPress', 'Ghost', 'Medium'];
                break;
            case 'portfolio':
                $platforms = ['Wix', 'Squarespace', 'Webflow'];
                break;
            case 'corporate':
            case 'business':
                $platforms = ['SharePoint', 'Drupal', 'Joomla', 'Custom CMS'];
                break;
            default:
                $platforms = ['Other'];
        }

        return response()->json([
            'success' => true,
            'platforms' => $platforms,
        ]);
    }
}
