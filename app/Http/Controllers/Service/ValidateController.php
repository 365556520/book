<?php

namespace App\Http\Controllers\Service;

use App\Tool\Validate\ValidateCode;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ValidateController extends Controller
{
  public function create(Request $request)
  {
      $validateCode = new ValidateCode;
      return $validateCode->doimg();
  }
}
