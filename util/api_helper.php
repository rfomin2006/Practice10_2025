<?php header('Content-Type: application/json'); // тип возвращаемого ответа - JSON
// response to OPTIONS and HEAD 200 - OK
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS' || $_SERVER['REQUEST_METHOD'] === 'HEAD') {
    http_response_code(200);
    die;
}

/**
 * Sends a standardized JSON HTTP response.
 *
 * @param int   $res_code The HTTP status code to return (e.g., 200, 400, 500).
 * @param array $data     Optional. An array of data to include if the response is successful. Defaults to an empty array.
 * @param string $msg     Optional. An error message to include if the response is a failure. Defaults to an empty string.
 *
 * This function works as follows:
 * 1. Sets the HTTP response code using http_response_code($res_code).
 * 2. Checks if $data is not empty:
 *      - If $data contains elements, it returns a JSON object:
 *        {
 *          "success": true,
 *          "data": $data
 *        }
 *      - If $data is empty, it returns a JSON object:
 *        {
 *          "success": false,
 *          "error": $msg
 *        }
 *
 * This creates a consistent API response format where success responses carry data,
 * and failure responses carry an error message.
 *
 * Example usage:
 *   send_response(200, ['id' => 1, 'name' => 'Alice']); // Success
 *   send_response(400, [], 'Invalid request');           // Failure
 */
function send_response(int $res_code, array $data = [], string $msg = ''): void
{
    http_response_code($res_code);
    if (!empty($data)) {
        echo json_encode([
            'success' => true,
            'data' => $data
        ]);
    } else {
        if ($msg === '') {
            $msg = 'No data or message provided.';
        }
        echo json_encode([
            'success' => false,
            'error' => $msg
        ]);
    }
}
