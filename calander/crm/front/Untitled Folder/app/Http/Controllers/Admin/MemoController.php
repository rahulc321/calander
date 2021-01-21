<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Memo;
use App\Modules\Users\UserRepository;

class MemoController extends Controller
{
    public function __construct(UserRepository $userRepository)
    {
        $this->users = $userRepository;
    }

    public function getIndex()
    {
        $memo = Memo::first();
        return sysView('memos.index', compact('memo'));
    }

    public function postIndex()
    {
        $data = \Input::all();
        $memo = Memo::first();
        if (!$memo) {
            $memo = Memo::create(['memo' => '']);
        }

        $memo->memo = \Input::get('memo');
        $memo->save();

        return redirect()->back()->with(['success' => 'Memo Updated']);
    }

}