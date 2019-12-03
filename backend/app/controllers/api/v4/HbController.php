<?php

class HbController extends V4Controller {

  private static function _cache_search($query_url) {
    $cache_name = "Hb_search_" . $query_url;

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
    $cache_name = "Hb_bests_" . $query_url;

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
    $cache_name = "Hb_detail_" . $query_url;

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

    $data = self::_cache_bests("https://www.hepsiburada.com/kampanyalar/yeni-cikan-kitaplar");

    $json = self::_query_json_template(200, "En Yeniler", $data);
    return $this->render(["text" => $json], ["content_type" => "application/json"]);
  }

  public function tops() {

    $data = self::_cache_bests("https://www.hepsiburada.com/kitaplar-c-2147483645?siralama=coksatan");

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
    $data = self::_cache_search("https://www.hepsiburada.com/ara?q=" . $post_text);

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

    preg_match_all("'\"barcode\":\"(.*?)\"'si", $file, $barcode);
    $_barcode = $barcode[1];

    return [
      "barcode" => $_barcode
    ];
  }

  private static function _query_search($query_url) {
    $context = stream_context_create(
      array(
        "http" => array(
          "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
        )
      )
    );

    $file = file_get_contents($query_url, false, $context);
    preg_match_all("'<div class=\"box product(.*?)hb-placeholder\" data-bind=\"(.*?)\">\s*<a href=\"(.*?)\"'si", $file, $links);
    $_links = $links[3];

    preg_match_all("'<div class=\"carousel-lazy-item\">\s*<img src=\'(.*?)\'\s*class=\"product-image owl-lazy hidden\"  alt=\"(.*?)\"\s*.*?\s*/>'si", $file, $cards);
    $_names = $cards[2];
    $_images = $cards[1];

    foreach ($_links as $i => $value)
      $_links[$i] = "https://www.hepsiburada.com" . $value;

    preg_match_all("'<div class=\"price-container(.*?)\">(.*?)<div class=\"badge-container\">'si", $file, $all_prices);
    $_all_prices = $all_prices[2];

    $_prices = [];
    $_prices_old = [];
    $_prices_percent = [];
    foreach ($_all_prices as $key => $value) {

      preg_match_all("'<div class=\"badge highlight discount-badge\">\s*<small>%</small><span>(.*?)</span>\s*</div>\s*<del class=\"price old product-old-price\">(.*?)</del>\s*<span class=\"price old product-old-price\" style=\"text-decoration: none;\">(.*?)</span>'si", $value, $output);

      if (isset($output[0][0])) {
        $_prices_percent[] = $output[1][0];
        $_prices_old[] = $output[2][0];
        $_prices[] = $output[3][0];
        continue;
      }

      preg_match_all("'<div class=\"badge highlight discount-badge\">\s*<small>%</small><span>(.*?)</span>\s*</div>\s*<del class=\"price old product-old-price\">(.*?)</del>\s*<span class=\"price product-price\">(.*?)</span>\s*</div>'si", $value, $output);

      if (isset($output[0][0])) {
        $_prices_percent[] = $output[1][0];
        $_prices_old[] = $output[2][0];
        $_prices[] = $output[3][0];
        continue;
      }

      preg_match_all("'<span class=\"price product-price\">(.*?)</span>'si", $value, $output);

      if (isset($output[0][0])) {
        $_prices_percent[] = NULL;
        $_prices_old[] = NULL;
        $_prices[] = $output[1][0];
        continue;
      }
    }

    foreach ($_prices as $i => $value) {
      $_prices[$i] = preg_replace("/[^0-9,.|]/", "", $_prices[$i]);
      $_prices_old[$i] = preg_replace("/[^0-9,.|]/", "", $_prices_old[$i]);

    }

    preg_match_all("'<div class=\"badge-container\">(.*?)</div>\s*</a>\s*</div>'si", $file, $all_publishers_and_authors);
    $_all_publishers_and_authors = $all_publishers_and_authors[1];

    $_publishers = [];
    $_authors = [];

    foreach ($_all_publishers_and_authors as $key => $value) {

      preg_match_all("'brandName&quot;:&quot;(.*?)&quot;,&quot;'si", $value, $output);

      if (isset($output[0][0])) {
        $_publishers[] = $output[1][0];
      } else {
        $_publishers[] = NULL;
      }

/*
      preg_match_all("'merchantName&quot;:&quot;(.*?)&quot;,&quot;'si", $value, $output);
     if (isset($output[0][0])) {
        $_authors[] = $output[1][0];
      } else {
        $_authors[] = NULL;
      }
*/
      $_authors[] = NULL;

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
          "publisher" => trim($_publishers[$i]),
          "author" => trim($_authors[$i])
        ];
      }

      $data = $datas;
    } else {
      $data = NULL;
    }

    return $data;
  }

  private static function _query_bests($query_url) {
    $context = stream_context_create(
      array(
        "http" => array(
          "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
        )
      )
    );

    $file = file_get_contents($query_url, false, $context);
    preg_match_all("'<div class=\"carousel-lazy-item\">\s*<img src=\'(.*?)\'\s*class=\"product-image owl-lazy hidden\"\s*alt=\"(.*?)\"\s*title=\"(.*?)\"'mi", $file, $cards);
    $_images = $cards[1];
    $_names_and_authors = $cards[2];

    $_names = [];
    $_authors = [];
    foreach ($_names_and_authors as $i => $value) {
      $values = explode("–", $value);
      if (count($values) != 2)
        $values = explode("-", $value);

      $_names[] = trim($values[0]);
      $_authors[] = isset($values[1]) ? $values[1] : NULL;
    }

    preg_match_all("'<a href=\"(.*?)\"\s*data-sku=\"(.*?)\"\s*data-bind=\"(.*?)\"\s*data-productid=\"(.*?)\"\s*data-rrclickurl=\"\">'mi", $file, $links);
    $_links = $links[1];

    foreach ($_links as $i => $value)
      $_links[$i] = "https://www.hepsiburada.com" . $value;

    // preg_match_all("'<div class=\"badge highlight discount-badge\">\s*<small>%</small><span>(.*?)</span>\s*</div>\s*<del class=\"price old product-old-price\">(.*?)</del>\s*<span class=\"price product-price\">(.*?)</span>'mi", $file, $prices);

    preg_match_all("'</h3>\s*(.*?)\s*<span class=\"title small placeholder\"></span>'si", $file, $all_prices);
    $_all_prices = $all_prices[1];

    $_prices_old = [];
    $_prices = [];
    $_prices_percent = [];

    foreach ($_all_prices as $key => $value) {

      preg_match_all("'<div class=\"badge highlight discount-badge\">\s*<small>%</small><span>(.*?)</span>\s*</div>\s*<del class=\"price old product-old-price\">(.*?)</del>\s*<span class=\"price product-price\">(.*?)</span>\s*</div>'si", $value, $output);

      if (!empty($output[0][0])) {

        $_prices_percent[] = $output[1][0];
        $_prices[] = preg_replace("/[^0-9,.|]/", "", $output[3][0]);
        $_prices_old[] = preg_replace("/[^0-9,.|]/", "", $output[2][0]);
      }

      preg_match_all("'<div class=\"badge highlight discount-badge\">\s*<small>%</small><span>(.*?)</span>\s*</div>\s*<del class=\"price old product-old-price\">(.*?)</del>\s*<span class=\"price old product-old-price\" style=\"text-decoration: none;\">(.*?)</span>\s*</div>'mi", $value, $output);

      if (!empty($output[0][0])) {

        $_prices_percent[] = $output[1][0];
        $_prices[] = preg_replace("/[^0-9,.|]/", "", $output[3][0]);
        $_prices_old[] = preg_replace("/[^0-9,.|]/", "", $output[2][0]);
      }

      preg_match_all("'<div class=\"price-container highlight-badge no-discount hb-pl-cn\">\s*<span class=\"price product-price\">(.*?)</span>'mi", $value, $output);

      if (!empty($output[0][0])) {

        $_prices[] = preg_replace("/[^0-9,.|]/", "", $output[1][0]);;
        $_prices_percent[] = NULL;
        $_prices_old[] = NULL;
      }
    }

    // preg_match_all("'brandName&quot;:&quot;(.*?)&quot;,&quot;'mi", $file, $publishers);
    // $_publishers = $publishers[1];

    $_publishers = [];
    foreach ($_names as $key => $value) {
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
          "author" => trim($_authors[$i])
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
