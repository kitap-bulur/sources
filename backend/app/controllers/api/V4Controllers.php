<?php

class V4Controller extends ApiController {

  protected $before_actions = [["require_login"]];

  public function require_login() {
    if (isset($_POST["appkey"])) {
      if ($_POST["appkey"] != "********") {
        $json = self::_query_json_template(500, "Parola yanlış!");
        return $this->render(["text" => $json], ["content_type" => "application/json"]);
      }
    } else {
      $json = self::_query_json_template(500, "Üzülerek söylüyorumki buraya erişmeye yetkiniz yok!");
      return $this->render(["text" => $json], ["content_type" => "application/json"]);
    }
  }

  public static function _query_json_template($status, $message, $datas = NULL) {
    $json_array = ["status" => $status, "message" => $message, "datas" => $datas];
     return json_encode($json_array, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
  }
}
?>
