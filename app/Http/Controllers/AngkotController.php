<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AngkotController extends Controller
{
    /**
     * Instantiate a new AngkotController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
}
