<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class APIInsertDataController extends Controller
{
    /**
     * todo : 2026-03-09
     * * FN: สำหรับบันทึกข้อมูลลงในตาราง AM_LDR_INFOHREC_TBL
     */
    #[OA\Post(
        path: "/info/insert",
        tags: ["Info"],
        summary: "Insert info record",
        responses: [
            new OA\Response(
                response: 200,
                description: "Success"
            )
        ]
    )]
    public function DataInfoInsert(Request $request)
    {
        try {
            DB::beginTransaction();
            // Basic validation
            $request->validate([
                'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $payload = $request->except('image');
            $YM = date('Ym');
            $uploadedImages = [];

            if ($request->hasFile('image')) {
                $files = $request->file('image');

                // Handle both single file and array of files
                $files = is_array($files) ? $files : [$files];

                foreach ($files as $file) {
                    $extension = $file->getClientOriginalExtension();
                    // Use uniqid to prevent collisions
                    $fileName = 'IMG-' . $YM . '-' . uniqid() . '.' . $extension;
                    $destinationPath = public_path('images_information/');

                    $file->move($destinationPath, $fileName);
                    $uploadedImages[] = $fileName;
                }
            }

            // If multiple images were uploaded, return them as an array, 
            // otherwise returning as a single string (or null) to maintain compatibility if possible
            $payload['image'] = count($uploadedImages) === 1 ? $uploadedImages[0] : (empty($uploadedImages) ? null : $uploadedImages);

            $AMLDRINF_HREC_ID = "";

            /**
             * TODO: Auto Generate Key
             */

            $findPreviousMaxID = DB::table('AM_LDR_INFOHREC_TBL')
                ->select('AMLDRINF_HREC_ID')
                ->orderBy('AMLDRINF_HREC_ID', 'DESC')
                ->first();

            if (empty($findPreviousMaxID)) {
                $AMLDRINF_HREC_ID = 'AMLDRINF-' . $YM . '-000001';
            } else {
                $AMLDRINF_HREC_ID = AutogenerateKey('AMLDRINF', $findPreviousMaxID->AMLDRINF_HREC_ID);
            }


            /**
             * TODO: Auto Insert Document Number
             */


            $doc_num = "";

            $parts = explode('-', $AMLDRINF_HREC_ID);
            $v = end($parts) ?: '';

            if (!is_numeric($v)) {
                $doc_num = "";
            } else {

                $num = intval($v);

                // ถ้าน้อยกว่า 1000 → แสดง 3 หลัก
                if ($num < 1000) {
                    $doc_num = str_pad($num, 3, "0", STR_PAD_LEFT);
                }
                // ถ้า 1000 ขึ้นไป → แสดงเต็ม
                else {
                    $doc_num = (string)$num;
                }
            }



            // TODO: Perform database insertion here
            // Example: InfoHRec::create($payload);
            $insert_info = [
                'AMLDRINF_HREC_ID' => $AMLDRINF_HREC_ID,
                'AMLDRINF_DOC_NUM' => $doc_num,
                'AMLDRINF_EMPHREC' => $payload['emp_id'],
                'AMLDRINF_HREC_LINE' => $payload['line'],
                'AMLDRINF_HREC_CUS' => $payload['customer'],
                'AMLDRINF_HREC_WON' => $payload['won'],
                'AMLDRINF_HREC_MDLCD' => $payload['model_code'],
                'AMLDRINF_HREC_MDLNM' => $payload['model_name'],
                'AMLDRINF_HREC_LOTS' => (int)$payload['lots'],
                'AMLDRINF_HREC_PROCS' => $payload['procs'],
                'AMLDRINF_HREC_CSTYPE' => $payload['cause'],
                'AMLDRINF_HREC_PROB' => $payload['prob'],
                'AMLDRINF_HREC_IMAGE' => $payload['image'],
                'AMLDRINF_HREC_LOCATE' => $payload['locate'],
                'AMLDRINF_HREC_MACHINE' => $payload['machine'],
                'AMLDRINF_HREC_QTYNG' => $payload['qty_ng'],
                'AMLDRINF_HREC_STARTTIME' => $payload['start_time'],
                'AMLDRINF_HREC_STD' => 0,
                'AMLDRINF_HREC_LSTDT' => date('Y-m-d H:i:s')

            ];

            DB::table('AM_LDR_INFOHREC_TBL')
                ->insert($insert_info);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data processed successfully',
                'data' => $insert_info
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * todo : 2026-03-09
     * * FN: สำหรับบันทึกข้อมูลลงในตาราง AM_LDR_ACTIONHREC_TBL
     */
    #[OA\Post(
        path: "/action/insert",
        tags: ["Action"],
        summary: "Insert action record",
        responses: [
            new OA\Response(
                response: 200,
                description: "Success"
            )
        ]
    )]
    public function DataActionInsert(Request $request)
    {
        try {
            DB::beginTransaction();

            $payload = $request->except('image');
            $YM = date('Ym');
            $uploadedImages = [];

            if ($request->hasFile('image')) {
                $files = $request->file('image');

                // Handle both single file and array of files
                $files = is_array($files) ? $files : [$files];

                foreach ($files as $file) {
                    $extension = $file->getClientOriginalExtension();
                    // Use uniqid to prevent collisions
                    $fileName = 'IMG-' . $YM . '-' . uniqid() . '.' . $extension;
                    $destinationPath = public_path('images_action/');

                    $file->move($destinationPath, $fileName);
                    $uploadedImages[] = $fileName;
                }
            }

            // If multiple images were uploaded, return them as an array, 
            // otherwise returning as a single string (or null) to maintain compatibility if possible
            $payload['image'] = count($uploadedImages) === 1 ? $uploadedImages[0] : (empty($uploadedImages) ? null : $uploadedImages);

            $AMLDRACT_HREC_ID = "";

            /**
             * TODO: Auto Generate Key
             */

            $findPreviousMaxID = DB::table('AM_LDR_ACTIONHREC_TBL')
                ->select('AMLDRACT_HREC_ID')
                ->orderBy('AMLDRACT_HREC_ID', 'DESC')
                ->first();

            if (empty($findPreviousMaxID)) {
                $AMLDRACT_HREC_ID = 'AMLDRACT-' . $YM . '-000001';
            } else {
                $AMLDRACT_HREC_ID = AutogenerateKey('AMLDRACT', $findPreviousMaxID->AMLDRACT_HREC_ID);
            }



            // TODO: Perform database insertion here
            // Example: InfoHRec::create($payload);
            $insert_action = [
                'AMLDRACT_HREC_ID' => $AMLDRACT_HREC_ID,
                'AMLDRINF_HREC_ID' => $payload['inf_hrec_id'],
                'AMLDRACT_HREC_EDITTYPE' => $payload['editType'],
                'AMLDRACT_HREC_RTCAUSE' => $payload['root_cause'],
                'AMLDRACT_HREC_ACTION' => $payload['action'],
                'AMLDRACT_HREC_IMAGE' => $payload['image'],
                'AMLDRACT_HREC_ACTIONEMP' => $payload['empno'],
                'AMLDRACT_HREC_STD' => 0,
                'AMLDRACT_HREC_LSTDT' => date('Y-m-d H:i:s')

            ];

            DB::table('AM_LDR_ACTIONHREC_TBL')
                ->insert($insert_action);

            DB::table('AM_LDR_INFOHREC_TBL')
                ->where('AMLDRINF_HREC_ID', $payload['inf_hrec_id'])
                ->update([
                    'AMLDRINF_HREC_STD' => 3
                ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Insert Action successfully'

            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
