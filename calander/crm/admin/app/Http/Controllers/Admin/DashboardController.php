<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Users\UserRepository;
use App\User;

class DashboardController extends Controller
{
    public function __construct(UserRepository $userRepository)
    {
        $this->users = $userRepository;
    }

    public function getIndex()
    {
        return view('webpanel.dashboard', compact('jsData'));
    }

}