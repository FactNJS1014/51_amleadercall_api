<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use OpenApi\Attributes as OA;

class APIGetDataController extends Controller
{
    #[OA\Get(
        path: "/vwork",
        tags: ["DataVWork"],
        summary: "Get work list",
        responses: [
            new OA\Response(
                response: 200,
                description: "Success"
            )
        ]
    )]
    public function DataVWork()
    {
        $data = DB::table('VWORLIST')
            ->select('WON', 'BGCD')
            ->get();

        return response()->json($data);
    }

    #[OA\Get(
        path: "/vcus",
        tags: ["DataVWork"],
        summary: "Get work list",
        responses: [
            new OA\Response(
                response: 200,
                description: "Success"
            )
        ]
    )]
    public function DataCustomer()
    {
        $data = DB::table('VWORLIST')
            ->select('BGCD')
            ->distinct()
            ->get();

        return response()->json($data);
    }

    #[OA\Get(
        path: "/vcheckmodel",
        tags: ["DataVWork"],
        summary: "Get work list",
        responses: [
            new OA\Response(
                response: 200,
                description: "Success"
            )
        ]
    )]
    public function DataCheckModel()
    {
        $data = DB::table('VWORLIST')
            ->select('WON', 'MDLCD', 'MDLNM', 'WONQT')
            ->get();

        return response()->json($data);
    }

    public function DataVWorkByCustomer($customer)
    {
        $data = DB::table('VWORLIST')
            ->select('WON', 'BGCD')
            ->where('BGCD', trim($customer))
            ->get();

        return response()->json($data);
    }

    public function DataCheckModelByWon($won)
    {
        $data = DB::table('VWORLIST')
            ->select('WON', 'MDLCD', 'MDLNM', 'WONQT')
            ->where('WON', trim($won))
            ->first();

        return response()->json($data);
    }

    #[OA\Get(
        path: "/info/record",
        tags: ["Info"],
        summary: "Get info record",
        responses: [
            new OA\Response(
                response: 200,
                description: "Success"
            )
        ]
    )]
    public function DataInfoRecord()
    {
        $data = DB::table('AM_LDR_INFOHREC_TBL')
            ->where('AMLDRINF_HREC_STD', 1)
            ->get();

        return response()->json($data);
    }

    #[OA\Get(
        path: "/info/record/check",
        tags: ["Info"],
        summary: "Get info record",
        responses: [
            new OA\Response(
                response: 200,
                description: "Success"
            )
        ]
    )]
    public function CheckDataRecord()
    {
        $data = DB::table('AM_LDR_INFOHREC_TBL')
            ->where('AMLDRINF_HREC_STD', 0)
            ->get();

        return response()->json($data);
    }

    #[OA\Get(
        path: "/info-action/record",
        tags: ["Action"],
        summary: "Get action record",
        responses: [
            new OA\Response(
                response: 200,
                description: "Success"
            )
        ]
    )]
    public function DataInfoAndActionRecord()
    {
        $data = DB::table('AM_LDR_ACTIONHREC_TBL')
            ->get();

        return response()->json($data);
    }

    #[OA\Get(
        path: "/action/record/check",
        tags: ["Action"],
        summary: "Get action record",
        responses: [
            new OA\Response(
                response: 200,
                description: "Success"
            )
        ]
    )]
    public function CheckActionRecord()
    {
        $data = DB::table('AM_LDR_ACTIONHREC_TBL')
            ->where('AMLDRACT_HREC_STD', 0)
            ->get();

        return response()->json($data);
    }

    #[OA\Get(
        path: "/confirm/record",
        tags: ["Confirm"],
        summary: "Get confirm record",
        responses: [
            new OA\Response(
                response: 200,
                description: "Success"
            )
        ]
    )]
    public function DataConfirmRecord()
    {
        $data = DB::table('AM_LDR_CONFIRMHREC_TBL')
            ->get();

        return response()->json($data);
    }
}
