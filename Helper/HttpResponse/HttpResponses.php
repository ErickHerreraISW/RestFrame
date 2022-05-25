<?php 

    namespace Helper\HttpResponse;

    class HttpResponses {


        /**
         * @param mixed $data
         * @return void
         */
        public static function success($data) : void
        {

            http_response_code(200);

            print json_encode(array(
                "status" => 200,
                "data"   => $data
            ), JSON_PRETTY_PRINT);
        }

        /**
         * @param mixed|null $data
         * @return void
         */
        public static function notFound($data = null) : void
        {
            http_response_code(404);

            print json_encode(array(
                "status" => 404,
                "data"   => $data
            ), JSON_PRETTY_PRINT);
        }

        /**
         * @param mixed|null $data
         * @return void
         */
        public static function failed($data = null) : void
        {

            http_response_code(417);

            print json_encode(array(
                "status" => 417,
                "data"   => $data
            ), JSON_PRETTY_PRINT);
        }

        /**
         * @param mixed|null $data
         * @return void
         */
        public static function notAuthorized($data = null) : void
        {

            http_response_code(401);

            print json_encode(array(
                "status" => 401,
                "data"   => $data
            ), JSON_PRETTY_PRINT);
        }

        /**
         * @param mixed|null $data
         * @return void
         */
        public static function internalError($data = null) : void
        {

            http_response_code(500);

            print json_encode(array(
                "status" => 500,
                "data"   => $data
            ), JSON_PRETTY_PRINT);
        }

        /**
         * @param mixed|null $data
         * @return void
         */
        public static function methodNotAllowed($data = null) : void
        {

            http_response_code(405);

            print json_encode(array(
                "status" => 405,
                "data"   => $data
            ), JSON_PRETTY_PRINT);
        }

        /**
         * @param integer $response_code
         * @param mixed|null $data
         * @return void
         */
        public static function customResponse($response_code, $data = null) : void
        {

            http_response_code($response_code);

            print json_encode(array(
                "status" => $response_code,
                "data"   => $data
            ), JSON_PRETTY_PRINT);
        }
    }
?>