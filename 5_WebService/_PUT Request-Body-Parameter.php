$request = $_REQUEST;
if ($_SERVER["REQUEST_METHOD"] == "PUT") {
   parse_str(file_get_contents("php://input"), $body_parameters);
   $request = $request + $body_parameters;
}