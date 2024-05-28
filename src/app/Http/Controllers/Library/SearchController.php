<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Http\Requests\Search\ZipRequest;
use App\Services\CalilSearchService;
use App\Services\ZipcodeSearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
    public function zip(ZipRequest $request, ZipcodeSearchService $zipService, CalilSearchService $calilService)
    {
        // 郵便番号から住所を検索
        $addresses = $zipService->search($request->input("zip_code"));
        if (!$addresses) {
            $validator = Validator::make($request->all(), []);
            $validator->validate();
            $validator->errors()->add('zip_code', "住所検索に失敗しました");
            return back()->withInput()->withErrors($validator);
        }

        // カーリルAPI
        $libraies = $calilService->address($addresses);

        $request->session()->put([
            '_old_input' => [
                'zip_code'      => $request->input("zip_code"),
            ]
        ]);
        // カーリルから検索
        return view($this->viewName("top"), [
            'search_word'   => "{$addresses['prefecture']}{$addresses['address1']}",
            'libraies'      => $libraies,
        ]);
    }
}
