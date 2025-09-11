<?php

namespace Modules\Seo\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Seo\Services\SeoService;

class SeoMetaController extends Controller
{
    protected SeoService $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function edit(Request $request)
    {
        $modelClass = $request->get('model');
        $modelId = $request->get('id');

        $seoData = $this->seoService->loadSeoData($modelClass, $modelId);

        return view('seo::components.seo-meta-form', [
            'modelClass' => $modelClass,
            'modelId' => $modelId,
            'seoData' => $seoData,
        ]);
    }

    public function update(Request $request)
    {
        $modelClass = $request->get('model');
        $modelId = $request->get('id');
        $seo = $request->input('seo', []);

        $this->seoService->saveSeoData($modelClass, $modelId, $seo);

        return back()->with('success', 'SEO saved!');
    }
}
