<?php
namespace DentalSleepSolutions\Helpers;

class ApiResponse
{
    /**
     * returned name of status http code
     *
     * @param $status
     * @return string
     */
    private static function getStatusesName($status)
    {
        return array_get(\Symfony\Component\HttpFoundation\Response::$statusTexts, $status, '');
    }

    /**
     * Create response for success
     *
     * @param string $message
     * @param array $data
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public static function responseOk($message = '', $data = null)
    {
        return response()->json(['status' => self::getStatusesName(200), 'message' => $message, 'data' => $data]);
    }

    /**
     * Create response for error
     *
     * @param string $message
     * @param int $status
     * @param array $data
     * @param bool|true $create_errors_array
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public static function responseError($message = '', $status = 404, $data = null, $create_errors_array = true)
    {
        if (!is_array($data) && $create_errors_array) {
            $data = [
                'errors' => [$data ? $data : $message]
            ];
        }
        return response()->json([
            'status' => self::getStatusesName($status),
            'message' => $message,
            'data' => $data
        ], $status);
    }

    /**
     * create response with selected type of message
     *
     * @param array $data
     * @param string $message_success
     * @param string $message_error
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public static function response($data, $message_success, $message_error)
    {
        if ($data['success']) {
            return self::responseOk($message_success, $data['data']);
        }

        return self::responseError($message_error, $data['status'], $data['data']);
    }
}
