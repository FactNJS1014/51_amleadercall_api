<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class APIUpdateandDeleteController extends Controller
{


    #[OA\Put(
        path: "/update/check/{id}",
        tags: ["Info"],
        summary: "Insert info record",
        responses: [
            new OA\Response(
                response: 200,
                description: "Success"
            )
        ]
    )]

    public function UpdateCheckRecordInformation($id)
    {
        try {
            //code...
            DB::beginTransaction();

            $update_data = [
                'AMLDRINF_HREC_STD' => 1
            ];

            DB::table('AM_LDR_INFOHREC_TBL')
                ->where('AMLDRINF_HREC_ID', $id)
                ->update($update_data);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Update check record successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update check record',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    #[OA\Put(
        path: "/info/update",
        tags: ["Info"],
        summary: "Update info record",
        responses: [
            new OA\Response(
                response: 200,
                description: "Success"
            )
        ]
    )]
    public function UpdateInfoRecord(Request $request)
    {
        try {
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

            // กรณีอัพโหลดรูปใหม่ → ใช้ชื่อไฟล์ใหม่
            // กรณีไม่เปลี่ยนรูป → ใช้ existing_image ที่ส่งมาจาก frontend
            // กรณีไม่มีรูปเลย → null
            if (count($uploadedImages) === 1) {
                $payload['image'] = $uploadedImages[0];
            } elseif (!empty($uploadedImages)) {
                $payload['image'] = $uploadedImages;
            } elseif ($request->filled('existing_image')) {
                $payload['image'] = $request->input('existing_image');
            } else {
                $payload['image'] = null;
            }

            $update_data = [
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
                'AMLDRINF_HREC_UPDATESTD' => 1,
                'AMLDRINF_HREC_UPDATELSTDT' => date('Y-m-d H:i:s')
            ];



            DB::table('AM_LDR_INFOHREC_TBL')
                ->where('AMLDRINF_HREC_ID', $payload['id_hrec'])
                ->update($update_data);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Update info record successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update check record',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    #[OA\Delete(
        path: "/info/delete/{id}",
        tags: ["Info"],
        summary: "Delete info record",
        responses: [
            new OA\Response(
                response: 200,
                description: "Success"
            )
        ]
    )]
    public function DeleteInfoRecord($id)
    {
        try {
            DB::beginTransaction();

            $update_std = [
                'AMLDRINF_HREC_STD' => 2
            ];

            DB::table('AM_LDR_INFOHREC_TBL')
                ->where('AMLDRINF_HREC_ID', $id)
                ->update($update_std);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Delete info record successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete info record',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    #[OA\Put(
        path: "/action/update",
        tags: ["Action"],
        summary: "Update action record",
        responses: [
            new OA\Response(
                response: 200,
                description: "Success"
            )
        ]
    )]
    public function UpdateActionRecord(Request $request)
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

            // กรณีอัพโหลดรูปใหม่ → ใช้ชื่อไฟล์ใหม่
            // กรณีไม่เปลี่ยนรูป → ใช้ existing_image ที่ส่งมาจาก frontend
            // กรณีไม่มีรูปเลย → null
            if (count($uploadedImages) === 1) {
                $payload['image'] = $uploadedImages[0];
            } elseif (!empty($uploadedImages)) {
                $payload['image'] = $uploadedImages;
            } elseif ($request->filled('existing_image')) {
                $payload['image'] = $request->input('existing_image');
            } else {
                $payload['image'] = null;
            }




            // TODO: Perform database insertion here
            // Example: InfoHRec::create($payload);
            $update_action = [
                'AMLDRACT_HREC_EDITTYPE' => $payload['editType'],
                'AMLDRACT_HREC_RTCAUSE' => $payload['root_cause'],
                'AMLDRACT_HREC_ACTION' => $payload['action'],
                'AMLDRACT_HREC_IMAGE' => $payload['image'],
                'AMLDRACT_HREC_ACTIONEMP' => $payload['empno'],
                'AMLDRACT_HREC_UPDATESTD' => 1,
                'AMLDRACT_HREC_UPDATELSTDT' => date('Y-m-d H:i:s')

            ];

            DB::table('AM_LDR_ACTIONHREC_TBL')
                ->where('AMLDRACT_HREC_ID', $payload['id'])
                ->update($update_action);



            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Insert Action successfully'

            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update action record',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    #[OA\Put(
        path: "/update/action-check/{id}",
        tags: ["Action"],
        summary: "Update action check record",
        responses: [
            new OA\Response(
                response: 200,
                description: "Success"
            )
        ]
    )]

    public function UpdateActionCheckRecord($id)
    {
        try {
            DB::beginTransaction();

            $update_action_std = [
                'AMLDRACT_HREC_STD' => 1
            ];

            DB::table('AM_LDR_ACTIONHREC_TBL')
                ->where('AMLDRACT_HREC_ID', $id)
                ->update($update_action_std);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Update action check record successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update action check record',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
