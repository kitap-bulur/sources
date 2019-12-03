<?php

class AmazonController extends V4Controller {

  private static function _cache_search($query_url) {
    $cache_name = "Amazon_search_" . $query_url;

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
    $cache_name = "Amazon_bests_" . $query_url;

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

  private static function _cache_detail($query_url) {
    $cache_name = "Amazon_detail_" . $query_url;

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

    $data = self::_cache_bests("https://www.amazon.com.tr/gp/new-releases/books");

    $json = self::_query_json_template(200, "En Yeniler", $data);
    return $this->render(["text" => $json], ["content_type" => "application/json"]);
  }

  public function tops() {

    $data = self::_cache_bests("https://www.amazon.com.tr/gp/bestsellers/books");

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
    $data = self::_cache_search("https://www.amazon.com.tr/s?k=" . $post_text);

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

    preg_match_all("'<li><b>ISBN-13:</b> (.*?)-(.*?)</li>'si", $file, $barcode);
    $_barcode = $barcode[1][0] . $barcode[2][0];

    return [
      "barcode" => $_barcode
    ];
  }

  private static function _query_search($query_url) {

    $file = file_get_contents($query_url);

    preg_match_all("'<div class=\"a-section aok-relative s-image-fixed-height\">\s*<img src=\"(.*?)\"'si", $file, $images);
    $_images = $images[1];

    preg_match_all("'<a class=\"a-link-normal a-text-normal\" href=\"(.*?)\">\s*<span class=\"a-size-medium a-color-base a-text-normal\">\s*(.*?)\s*</span>\s*</a>'si", $file,$cards);
    $_links = $cards[1];
    $_names = $cards[2];

    preg_match_all("'<span class=\"a-size-base\">(.*?)</span>\s*<span class=\"a-size-base\">(.*?)</span>'si", $file, $authors);
    $_authors = $authors[2];

    preg_match_all("'<span class=\"a-price\" data-a-size=\"l\" data-a-color=\"base\">\s*<span class=\"a-offscreen\">(.*?)</span>'si", $file, $prices);
    $_prices = $prices[1];

    preg_match_all("'<span class=\"a-price\" data-a-size=\"b\" data-a-strike=\"true\" data-a-color=\"secondary\"><span class=\"a-offscreen\">(.*?)</span>'si", $file, $prices_old);
    $_prices_old = $prices_old[1];

    $_prices_percent = [];
    $_publishers = [];
    foreach ($_prices_old as $i => $value) {
      $_publishers[]  = NULL;
      $_prices_percent[] = NULL;
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

  private static function _query_bests($query_url) {

    $file = file_get_contents($query_url);

    preg_match_all("'<img alt=\"(.*?)\" src=\"(.*?)\" height=\"200\" width=\"200\">'mi", $file, $cards);
    $_names = $cards[1];
    $_images = $cards[2];

    preg_match_all("'<span class=\"aok-inline-block zg-item\">\s*<a class=\"a-link-normal\" href=\"(.*?)\">\s*<span class=\"zg-text-center-align\">'si", $file, $links);
    $_links = $links[1];

    foreach ($_links as $i => $value)
      $_links[$i] = "https://www.amazon.com.tr" . $value;

    preg_match_all("'<div class=\"a-row a-size-small\">\s*<span class=\"a-size-small a-color-base\">(.*?)</span>\s*</div>'si", $file, $authors);
    $_authors = $authors[1];

    preg_match_all("'<li class=\"zg-item-immersion\" role=\"gridcell\">\s*(.*?)\s*</li>'si", $file, $prices_all);
    $_prices_all = $prices_all[0];

    $_prices = [];
    $_prices_old = [];
    $_prices_percent = [];
    $_publishers = [];
    foreach ($_prices_all as $key => $value) {
      preg_match_all("'<span class=\"a-size-base a-color-price\"><span class=\'p13n-sc-price\' >(.*?)</span></span>'si", $value, $output);

      if (!empty($output[0][0])) {
        $_prices[] = preg_replace("/[^0-9,.|]/", "", $output[1][0]);
      } else {
        $_prices[] = NULL;
      }
      $_publishers[]  = NULL;
      $_prices_percent[] = NULL;
      $_prices_old[] = NULL;
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

