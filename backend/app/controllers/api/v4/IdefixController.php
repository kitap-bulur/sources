<?php

class IdefixController extends V4Controller {

  private static function _cache_search($query_url) {
    $cache_name = "DR_SEARCH_" . $query_url;

    if (ApplicationCache::exists("$cache_name")) {

      $data = ApplicationCache::read("$cache_name");

    } else {
      // text search, fetch [data, data] or NULL

      $data = self::_query_search($query_url);

      if ($data) {
        ;// ApplicationCache::write("$cache_name", $data);
      } else {
        return NULL;
      }
    }

    return $data;
  }

  public function news() {

    $data = self::_cache_search("https://www.idefix.com/Kategori_/Kitap/En-Yeniler/11693/3");

    $json = self::_query_json_template(200, "En Yeniler", $data);
    return $this->render(["text" => $json], ["content_type" => "application/json"]);
  }

  public function tops() {

    $data = self::_cache_search("https://www.idefix.com/CokSatanlar/Kitap");

    $json = self::_query_json_template(200, "En Gözdeler", $data);
    return $this->render(["text" => $json], ["content_type" => "application/json"]);
  }

  public function search() {

    if (!isset($_POST["text"])) {
      $json = self::_query_json_template(429, "Verilerde eksiklik var!");
      return $this->render(["text" => $json], ["content_type" => "application/json"]);
    }

    $post_text = $_POST["text"];
    $post_text = preg_replace("/ /", "%20", $post_text);
    $data = self::_cache_search("https://www.idefix.com/Search?q=" . $post_text);

    if ($data) {
      $json = self::_query_json_template(200, "Başarılı istek", $data);
      return $this->render(["text" => $json], ["content_type" => "application/json"]);
    } else {
      $json = self::_query_json_template(404, "Üzgünüm aradığım kaynaklarımda ürününüzü bulamadım.");
      return $this->render(["text" => $json], ["content_type" => "application/json"]);
    }
  }

  private static function _query_search($query_url) {

    $file = file_get_contents($query_url);

    preg_match_all("'<a style=\"box-shadow: none;\" title=\"(.*?)\" href=\"(.*?)\" class=\"product-image\">\s*<div class=\"image-area\">\s*<img class=\"lazyload\" data-src=\"(.*?)\" alt=\"(.*?)\"\s*/>\s*</div>\s*</a>'si", $file, $cards);
    $_names = $cards[1];
    $_images = $cards[3];
    $_links = $cards[2];

    foreach ($_links as $i => $value)
      $_links[$i] = "https://www.idefix.com" . $value;

    preg_match_all("'<div class=\"box-line-4\">\s*(.*?)\s*</div>'si", $file, $prices_all);
    $_prices_all = $prices_all[1];

    $_prices_old = [];
    $_prices = [];
    $_prices_percent = [];
    foreach ($_prices_all as $i => $value) {

      preg_match_all("'<span\s*.*?>(.*?)</span>'si", $value, $output);
      $_output = $output[1];
      if (count($_output) == 3) {
        $_prices_old[$i] = preg_replace("/[^0-9,.|]/", "", $_output[0]);
        $_prices_percent[$i] = preg_replace("/[%]/", "", $_output[1]);
        $_prices[$i] = preg_replace("/[^0-9,.|]/", "", $_output[2]);
      }
      else {
        $_prices_old[$i] = NULL;
        $_prices_percent[$i] = NULL;
        $_prices[$i] = preg_replace("/[^0-9,.|]/", "", $_output[0]);
      }
    }

    preg_match_all("'class=\"who\">(.*?)</'si", $file, $authors);
    $_authors = $authors[1];

    /*
    preg_match_all("'class=\"who2 alternate\">(.*?)</'si", $file, $publishers);
    $_publishers = $publishers[1];
    */

    foreach ($_authors as $key => $value) {
    	$_publishers[] = NULL;
    }

    if (isset($_names[0])) {

      $datas = [];
      foreach ($_names as $i => $value) {
        $datas[] = [
        "name" => $_names[$i],
        "price" => $_prices[$i],
        "price_old" => $_prices_old[$i],
        "price_percent" => $_prices_percent[$i],
        "image" => $_images[$i],
        "link" => $_links[$i],
        "publisher" => $_publishers[$i],
        "author" => $_authors[$i]
        ];
      }

      $data = $datas;
    } else {
      $data = NULL;
    }

    return $data;
  }
}
?>
