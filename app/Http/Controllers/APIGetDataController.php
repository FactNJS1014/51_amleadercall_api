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
        try {
            DB::beginTransaction();

            $data = DB::table('AM_LDR_ACTIONHREC_TBL as a')
                ->join('AM_LDR_INFOHREC_TBL as i', 'a.AMLDRINF_HREC_ID', '=', 'i.AMLDRINF_HREC_ID')
                ->where('a.AMLDRACT_HREC_STD', 1)
                ->where('i.AMLDRINF_HREC_STD', 3)
                ->where('a.AMLDRCONF_HREC_ID', null)
                ->get();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    #[OA\Get(
        path: "/info/record/reject",
        tags: ["Info"],
        summary: "Get info record reject",
        responses: [
            new OA\Response(
                response: 200,
                description: "Success"
            )
        ]
    )]
    public function DataInfoRecordReject()
    {
        $data = DB::table('AM_LDR_INFOHREC_TBL')
            ->where('AMLDRINF_HREC_STD', 4)
            ->get();

        return response()->json($data);
    }

    #[OA\Get(
        path: "/all-record",
        tags: ["All"],
        summary: "Get all record",
        responses: [
            new OA\Response(
                response: 200,
                description: "Success"
            )
        ]
    )]
    public function DataAllRecord()
    {
        $data = DB::table('AM_LDR_CONFIRMHREC_TBL as c')
            ->join('AM_LDR_INFOHREC_TBL as i', 'c.AMLDRINF_HREC_ID', '=', 'i.AMLDRINF_HREC_ID')
            ->join('AM_LDR_ACTIONHREC_TBL as a', 'c.AMLDRACT_HREC_ID', '=', 'a.AMLDRACT_HREC_ID')
            ->where('c.AMLDRCONF_HREC_STD', 1)
            ->where('i.AMLDRINF_HREC_STD', 3)
            ->where('a.AMLDRACT_HREC_STD', 1)
            ->get();

        return response()->json($data);
    }

    #[OA\Get(
        path: "/action/record/reject",
        tags: ["Action"],
        summary: "Get action record reject",
        responses: [
            new OA\Response(
                response: 200,
                description: "Success"
            )
        ]
    )]
    public function DataActionRecordReject()
    {
        $data = DB::table('AM_LDR_ACTIONHREC_TBL')
            ->where('AMLDRACT_HREC_STD', 2)
            ->get();

        return response()->json($data);
    }
}
