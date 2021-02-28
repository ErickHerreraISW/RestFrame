<?php 

    namespace Helper\HttpResponse;

    class HttpResponses {

        public static function success($data) {

            http_response_code(200);

            print json_encode(array(
                "status" => 200,
                "data"   => $data
            ), JSON_PRETTY_PRINT);
        }

        public static function notFound($data = null) {

            http_response_code(404);

            print json_encode(array(
                "status" => 404,
                "data"   => $data
            ), JSON_PRETTY_PRINT);
        }

        public static function failed($data = null) {

            http_response_code(417);

            print json_encode(array(
                "status" => 417,
                "data"   => $data
            ), JSON_PRETTY_PRINT);
        }

        public static function notAuthorized($data = null) {

            http_response_code(401);

            print json_encode(array(
                "status" => 401,
                "data"   => $data
            ), JSON_PRETTY_PRINT);
        }

        public static function internalError($data = null) {

            http_response_code(500);

            print json_encode(array(
                "status" => 500,
                "data"   => $data
            ), JSON_PRETTY_PRINT);
        }

        public static function methodNotAllowed($data = null) {

            http_response_code(405);

            print json_encode(array(
                "status" => 405,
                "data"   => $data
            ), JSON_PRETTY_PRINT);
        }

        public static function customResponse($response_code, $data = null) {

            http_response_code($response_code);

            print json_encode(array(
                "status" => $response_code,
                "data"   => $data
            ), JSON_PRETTY_PRINT);
        }
    }
?>