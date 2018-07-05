<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


/**
 * @SWG\Swagger(
 *     schemes={"http","https"},
 *     host="localhost/laravel5.5-template/public",
 *     basePath="/",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Welcome to Test Swagger API Doc",
 *         description="Api description...",
 *         termsOfService="",
 *         @SWG\Contact(
 *             email="contact@mysite.com"
 *         ),
 *         @SWG\License(
 *             name="Private License",
 *             url="URL to the license"
 *         )
 *     ),
 *     @SWG\ExternalDocumentation(
 *         description="Find out more about my website",
 *         url="http..."
 *     )
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
