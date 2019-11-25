<?php

class NobelkitapController extends V4Controller {

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

    $data = self::_cache_search("https://www.nobelkitap.com/yeni_cikan_kitaplar");

    $json = self::_query_json_template(200, "En Yeniler", $data);
    return $this->render(["text" => $json], ["content_type" => "application/json"]);
  }

  public function tops() {

    $data = self::_cache_search("https://www.nobelkitap.com/cok_satan_kitaplar");

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
    $data = self::_cache_search("https://www.nobelkitap.com/arama?q=" . $post_text);

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

    preg_match_all("'<div class=\"nobel_newbook_item\">\s*<div class=\"nobel_newbook_item_discount\">\s*<span>%(.*?)<\/span>\s*İndirim\s*<\/div>\s*<div class=\"nobel_newbook_item_rw nobel_newbook_item_rsm\">\s*<a href=\"(.*?)\" title=\"(.*?)\">\s*<img class=\"lazy\" data-src=\"(.*?)\">\s*<\/a>\s*<\/div>\s*<div class=\"nobel_newbook_item_rw nobel_newbook_item_kadi\">\s*<a href=\"(.*?)\" title=\"(.*?)\">(.*?)</a>\s*</div>\s*<div class=\"nobel_newbook_item_rw nobel_newbook_item_yazar\">\s*<a href=\"(.*?)\">(.*?)</a>\s*</div>\s*<div class=\"nobel_newbook_item_rw nobel_newbook_item_ozellik\">\s*<span>(.*?)</span>\s*</div>\s*<div class=\"nobel_newbook_item_rw (.*?)\">\s*<span>(.*?)</span>\s*</div>\s*<div class=\"nobel_newbook_item_rw nobel_newbook_item_fiyat\">\s*<span class=\"nobel_newbook_e\"><font>(.*?)</font>(.*?)</span>\s*<span class=\"nobel_newbook_y\"><font>(.*?)</font>(.*?)</span>\s*</div>\s*<div class=\"nobel_newbook_item_rw nobel_newbook_item_button\">'mi", $file, $cards);

    $_prices_percent = $cards[1];
    $_links = $cards[2];
    $_images = $cards[4];
    $_names = $cards[7];
    $_authors = $cards[9];
    $_prices_old = $cards[13];
    $_prices = $cards[15];

    foreach ($_names as $key => $value) {
      $_publishers[$key] = NULL;
    }

    foreach ($_prices as $i => $value) {
      $_prices[$i] = preg_replace("/[^0-9,.|]/", "", $_prices[$i]);
      $_prices_old[$i] = preg_replace("/[^0-9,.|]/", "", $_prices_old[$i]);

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

