<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     description="Contoh API doc menggunakan OpenAPI/Swagger",
 *     version="0.0.1",
 *     title="Contoh API documentation",
 *     termsOfService="http://swagger.io/terms/",
 *     @OA\Contact(
 *         email="choirudin.emchagmail.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/license/LICENSE-2.0.html"
 *     ),
 * )
 */

class GreetController extends Controller
{
/** 
 * @OA\Get(
 *     path="/api/greet",
 *     tags={"greeting"},
 *     summary="Returns a Sample API response",
 *     description="A sample greeting to test out the API",
 *     operationId="greet",
 *     @OA\Parameter(
 *          name="firstname",
 *          description="nama depan",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *     ),
 *     @OA\Parameter(
 *          name="lastname",
 *          description="nama belakang",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent
 *          (example={
 *              "success": true,
 *              "message": "Berhasil mengambil kategori berita",
 *              "data": {
 *                  "output": "Hallo John Doe",
 *                  "firstname": "John",
 *                  "lastname": "Doe"
 *              }
 *          }),
 *     )
 *  )
*/
    
    
    public function greet(Request $request)
    {
        $userData = $request->only([
            'firstname',
            'lastname',
        ]);
        if (empty($userData['firstname']) && empty($userData['lastname'])) {
            return new \Exception('Missing data', 404);
        }
        return response()->json(['message' => 'Berhasil memproses masukan user', 
        'success' => true, 'data' => [
            'output' => 'Halo ' . $userData['firstname'] . ' ' . $userData['lastname'],
            'firstname'=>$userData['firstname'],
            'lastname'=>$userData['lastname']
            ]], 200);
    }
}
