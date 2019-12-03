<?php

class KidegaController extends V4Controller {

  private static function _cache_search($query_url) {
    $cache_name = "Kidega_search_" . $query_url;

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
    $cache_name = "Kidega_bests_" . $query_url;

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

    $data = self::_cache_search("https://kidega.com/yeni-cikan-kitaplar");

    $json = self::_query_json_template(200, "En Yeniler", $data);
    return $this->render(["text" => $json], ["content_type" => "application/json"]);
  }

  public function tops() {

    $data = self::_cache_search("https://kidega.com/cok-satan-kitaplar");

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
    $data = self::_cache_search("https://kidega.com/arama?query=" . $post_text);

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

    preg_match_all("'<span itemprop=\"isbn\">(.*?)</span>'si", $file, $barcode);
    $_barcode = $barcode[1];

    return [
      "barcode" => $_barcode
    ];
  }

  private static function _query_search($query_url) {
    /*$context = stream_context_create(
      array(
        "http" => array(
          "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
          )
        )
      );
    */
    // $file = file_get_contents($query_url, false, $context);
      $file = file_get_contents($query_url);

      preg_match_all("'<div class=\"image\">\s*<a href=\"(.*?)\" title=\"(.*?)\">\s*<img class=\"lazyload\" src=\"(.*?)\" data-src=\"(.*?)\"'si", $file, $cards);

      $_links = $cards[1];
      //$_names = $cards[2];
      $_images = $cards[4];

      preg_match_all("'class=\"book-name\">(.*?)</a>'si", $file, $names);
      $_names = $names[1];

      preg_match_all("'</div>\s*<div class=\"authorArea\">(.*?)<div class=\"publisherArea\">'si", $file, $authors_all);
      $_authors_all = $authors_all[0];

      $_authors = [];
      foreach ($_authors_all as $key => $value) {
        preg_match_all("'<a href=\"(.*?)\" class=\"author\" title=\"(.*?)\">(.*?)</a>\s*</div>'si", $value, $output);

        if (!empty($output[0][0])) {
          $_authors[] = $output[2][0];
        } else {
          $_authors[] = NULL;
        }
      }

      preg_match_all("'<div class=\"publisherArea\">\s*<a href=\"(.*?)\" class=\"publisher\" title=\"(.*?)\">(.*?)</a>\s*</div>'si", $file, $publishers);
      $_publishers = $publishers[2];

      preg_match_all("'<div class=\"priceBar(.*?)\">(.*?)</div>'si", $file, $prices_all);
      $_prices_all = $prices_all[0];

      $_prices_old = [];
      $_prices = [];
      $_prices_percent = [];

      foreach ($_prices_all as $key => $value) {

        preg_match_all("'<div class=\"priceBar  sale \">\s*<span class=\"redDiscont\" title=\"(.*?) İndirim\"><span class=\"glyphicon glyphicon-arrow-down\"></span> (.*?)</span>\s*<u class=\"firstPrice\">(.*?)</u>\s*<b class=\"lastPrice\">(.*?)</b>\s*</div>'si", $value, $output);

        if (!empty($output[0][0])) {

          $_prices_percent[] = preg_replace("/[^0-9,.|]/", "", $output[1][0]);
          $_prices[] = preg_replace("/[^0-9,.|]/", "", $output[4][0]);
          $_prices_old[] = preg_replace("/[^0-9,.|]/", "", $output[3][0]);
        }

        preg_match_all("'<div class=\"priceBar \">\s*<b class=\"lastPrice\">(.*?)</b>\s*</div>'si", $value, $output);

        if (!empty($output[0][0])) {

          $_prices_percent[] = NULL;
          $_prices[] = preg_replace("/[^0-9,.|]/", "", $output[1][0]);
          $_prices_old[] = NULL;
        }
      }

      foreach ($_prices_old as $i => $value) {
        $_prices_old[$i] = preg_replace("/[^0-9,.|]/", "", $_prices_old[$i]);
        $_prices[$i] = preg_replace("/[^0-9,.|]/", "", $_prices[$i]);
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
