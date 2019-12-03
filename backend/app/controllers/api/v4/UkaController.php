<?php

class UkaController extends V4Controller {

  private static function _cache_search($query_url) {
    $cache_name = "Uka_search_" . $query_url;

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

  private static function _cache_detail($query_url) {
    $cache_name = "Uka_detail_" . $query_url;

    if (ApplicationCache::exists("$cache_name")) {

      $data = ApplicationCache::read("$cache_name");

    } else {
      // text search, fetch [data, data] or NULL

      $data = self::_query_detail($query_url);

      if ($data) {
        ;// ApplicationCache::write("$cache_name", $data);
      } else {
        return NULL;
      }
    }

    return $data;
  }

  public function detail() {

    if (!isset($_POST["link"])) {
      $json = self::_query_json_template(429, "Verilerde eksiklik var!");
      return $this->render(["text" => $json], ["content_type" => "application/json"]);
    }

    $post_link = $_POST["link"];

    $data = self::_cache_detail($post_link);

    if ($data) {
      $json = self::_query_json_template(200, "Başarılı istek", $data);
      return $this->render(["text" => $json], ["content_type" => "application/json"]);
    } else {
      $json = self::_query_json_template(404, "Üzgünüm aradığım kaynaklarımda ürününüzü bulamadım.");
      return $this->render(["text" => $json], ["content_type" => "application/json"]);
    }
  }

  public function news() {

    $data = self::_cache_search("https://www.ucuzkitapal.com/yeni-urunler/");

    $json = self::_query_json_template(200, "En Yeniler", $data);
    return $this->render(["text" => $json], ["content_type" => "application/json"]);
  }

  public function tops() {

    $data = self::_cache_search("https://www.ucuzkitapal.com/cok-satanlar/");

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
    $data = self::_cache_search("https://www.ucuzkitapal.com/ara/?search_performed=Y&pcode=N&q=" . $post_text);

    if ($data) {
      $json = self::_query_json_template(200, "Başarılı istek", $data);
      return $this->render(["text" => $json], ["content_type" => "application/json"]);
    } else {
      $json = self::_query_json_template(404, "Üzgünüm aradığım kaynaklarımda ürününüzü bulamadım.");
      return $this->render(["text" => $json], ["content_type" => "application/json"]);
    }
  }


  private static function _query_detail($query_url) {
    $file = file_get_contents($query_url);

    preg_match_all("'<div class=\"urun-isbn\">(.*?)</div>'si", $file, $barcode);
    $_barcode = $barcode[1];

    return [
      "barcode" => $_barcode
    ];
  }

  private static function _query_search($query_url) {

    $file = file_get_contents($query_url);

    preg_match_all("'<div class=\"ty-grid-list__image\"> <a href=\"(.*?)\"> <img\s*class=\"ty-pict\s*cm-image\s*pt-image\" id=\"(.*?)\" src=\"(.*?)\" alt=\"(.*?)\" title=\"(.*?) - (.*?) - (.*?)\" width=\"160\" height=\"160\" />'mi", $file, $cards);
    $_links = $cards[1];
    $_images = $cards[3];
    $_names = $cards[5];
    $_authors = $cards[6];
    $_publishers = $cards[7];

    preg_match_all("'<span class=\"ty-list-price ty-strike\" id=\"(.*?)\">(.*?)</span>'si", $file, $prices_old);
    $_prices_old = $prices_old[2];

    preg_match_all("'<span id=\"(.*?)\" class=\"ty-price-bloklar\"><span>(.*?)</span>&nbsp;TL</span>'si", $file, $prices);
    $_prices = $prices[2];

    preg_match_all("'width=\"160\" height=\"160\" />(.*?)</div>'si", $file, $all_prices_percent);
    $_all_prices_percent = $all_prices_percent[1];

    $_prices_percent = [];
    foreach ($_all_prices_percent as $key => $value) {

      preg_match_all("'<span class=\"ty-discount-label__value\" id=\"(.*?)\">(.*?)</span>'si", $value, $output);

      if (!empty($output[0][0])) {
        $_prices_percent[$key] = preg_replace("/[^0-9,.|]/", "", $output[2][0]);
      } else {
        $_prices_percent[$key] = NULL;
      }
    }

    foreach ($_prices_old as $i => $value) {
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

