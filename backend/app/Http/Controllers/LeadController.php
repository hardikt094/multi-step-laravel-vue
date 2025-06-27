<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use Illuminate\Support\Facades\Validator;

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

        return response()->json([
            'success' => true,
            'message' => 'Lead captured successfully!',
            'lead' => $lead,
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
