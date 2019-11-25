<?php

class DrController extends V4Controller {

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

  private static function _cache_bests($query_url) {
    $cache_name = "DR_BESTS_" . $query_url;

    if (ApplicationCache::exists("$cache_name")) {

      $data = ApplicationCache::read("$cache_name");

    } else {
      // text search, fetch [data, data] or NULL

      $data = self::_query_bests($query_url);

      if ($data) {
        ;// ApplicationCache::write("$cache_name", $data);
      } else {
        return NULL;
      }
    }

    return $data;
  }

  public function news() {

    $data = self::_cache_bests("https://www.dr.com.tr/Kategori_/Kitap/En-Yeniler/10001/3");

    $json = self::_query_json_template(200, "En Yeniler", $data);
    return $this->render(["text" => $json], ["content_type" => "application/json"]);
  }

  public function tops() {

    $data = self::_cache_bests("https://www.dr.com.tr/CokSatanlar/Kitap");

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
    $data = self::_cache_search("https://www.dr.com.tr/search?q=" . $post_text);

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

    preg_match_all("'<figure>\s*<a href=\"(.*?)\" class=\"item-name\">\s*<img src=\"(.*?)\" alt=\"(.*?)\"\s*/>\s*</a>\s*</figure>'si", $file, $cards);
    $_names = $cards[3];
    $_images = $cards[2];
    $_links = $cards[1];

    foreach ($_links as $i => $value)
      $_links[$i] = "https://www.dr.com.tr" . $value;

    preg_match_all("'<div class=\"prices\">\s*(.*?)\s*</div>'si", $file, $prices_all);
    $_prices_all = $prices_all[1];

    $_prices_old = [];
    $_prices = [];
    $_prices_percent = [];
    foreach ($_prices_all as $i => $value) {

      preg_match_all("'<span\s*.*?>(.*?)</span>'si", $value, $output);
      $_output = $output[1];
      if (count($_output) == 3) {
        $_prices_old[$i] = preg_replace("/[^0-9,.|]/", "", $_output[0]);
        $_prices[$i] = preg_replace("/[^0-9,.|]/", "", $_output[1]);
        $_prices_percent[$i] = preg_replace("/[%]/", "", $_output[2]);
      }
      else {
        $_prices_old[$i] = NULL;
        $_prices[$i] = preg_replace("/[^0-9,.|]/", "", $_output[0]);
        $_prices_percent[$i] = NULL;
      }
    }

    preg_match_all("'class=\"who mb10\">(.*?)</'si", $file, $publishers);
    $_publishers = $publishers[1];

    preg_match_all("'class=\"who\">(.*?)</'si", $file, $authors);
    $_authors = $authors[1];

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

  private static function _query_bests($query_url) {

    $file = file_get_contents($query_url);

    preg_match_all("'<a title=\"(.*?)\" href=\"(.*?)\">\s*<figure>\s*<img class=\"lazyload\" data-src=\"(.*?)\" alt=\"(.*?)\" />\s*<div class=\"p-info\">\s*</div>\s*</figure>\s*</a>'mi", $file, $cards);
    $_names = $cards[1];
    $_links = $cards[2];
    $_images = $cards[3];

    foreach ($_links as $i => $value)
      $_links[$i] = "https://www.dr.com.tr" . $value;

    preg_match_all("'<div class=\"content\">.*?<div class=\"p-info\">.*?</div>.*?<div class=\"media-type\">.*?</div>.*?<div class=\"media-type\">.*?</div>(.*?)</div>'si", $file, $prices_all);
    $_prices_all = $prices_all[1];

    $_prices_old = [];
    $_prices = [];
    $_prices_percent = [];
    foreach ($_prices_all as $i => $value) {

      preg_match_all("'<span\s*.*?>(.*?)</span>'si", $value, $output);

      $_output = $output[1];
      if (count($_output) == 3) {
        $_prices_old[$i] = preg_replace("/[^0-9,.|]/", "", $_output[0]);
        $_prices[$i] = preg_replace("/[^0-9,.|]/", "", $_output[2]);
        $_prices_percent[$i] = preg_replace("/[%]/", "", $_output[1]);
      } else {
        $_prices_old[$i] = NULL;
        $_prices[$i] = preg_replace("/[^0-9,.|]/", "", $_output[0]);
        $_prices_percent[$i] = NULL;
      }
    }

    preg_match_all("'class=\"who mb10\">(.*?)</'si", $file, $publishers);
    $_publishers = $publishers[1];

    preg_match_all("'class=\"who\">(.*?)</'si", $file, $authors);
    $_authors = $authors[1];

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
