<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "API_AMLINECALL",
    version: "1.0.0",
    description: "API AMLINECALL"
)]

#[OA\Server(
    url: "http://127.0.0.1:8000/api",
    description: "Local Server"
)]

class OpenApi {}
