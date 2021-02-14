<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Response;

class Controller extends BaseController
{
    /*
     *  Initializing status codes from \Illuminate\Http\Response
     */
    public const HTTP_OK = Response::HTTP_OK;
    public const HTTP_CREATED = Response::HTTP_CREATED;
    public const HTTP_NO_CONTENT = Response::HTTP_NO_CONTENT;
    public const HTTP_UNAUTHORIZED = Response::HTTP_UNAUTHORIZED;
}
