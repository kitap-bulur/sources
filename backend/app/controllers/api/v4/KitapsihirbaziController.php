<?php

class KitapsihirbaziController extends V4Controller {

  private static function _cache_search($query_url) {
    $cache_name = "Kitapsihirbazi_search_" . $query_url;

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
    $cache_name = "Kitapsihirbazi_bests_" . $query_url;

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
    $cache_name = "Kitapsihirbazi_detail_" . $query_url;

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

    $data = self::_cache_bests("https://www.kitapsihirbazi.com/yeni-cikanlar");

    $json = self::_query_json_template(200, "En Yeniler", $data);
    return $this->render(["text" => $json], ["content_type" => "application/json"]);
  }

  public function tops() {

    $data = self::_cache_bests("https://www.kitapsihirbazi.com/cok-satanlar-b41.html1");

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
    $data = self::_cache_search("https://www.kitapsihirbazi.com/index.php?p=Products&q_field_active=0&ctg_id=&q=" . $post_text);

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

    preg_match_all("'<div class=\"table-row table-body-row prd_custom_fields_0\">\s*<div class=\"table-cell prd-features-label\">Stok Kodu</div>\s*<div class=\"table-cell\">:</div>\s*<div class=\"table-cell\">(.*?)</div>\s*</div>'si", $file, $barcode);
    $_barcode = $barcode[1];

    return [
      "barcode" => $_barcode
    ];
  }

  private static function _query_search($query_url) {

    $file = file_get_contents($query_url);

    preg_match_all("'<a href=\"(.*?)\" class=\"fancybox\" id=\"main_img_link\">'mi", $file, $cards);
    $_images = $cards[1];

    preg_match_all("'<h1 class=\"contentHeader prdHeader\">(.*?)</h1>'si", $file, $names);
    $_names = $names[1];

    preg_match_all("'<link rel=\"canonical\" href=\"(.*?)\" />'si", $file, $links);
    $_links = $links[1];

    preg_match_all("'<a class=\"writer\" href=\"(.*?)\"><span>(.*?)</span></a>'si", $file, $authors);
    $_authors = $authors[2];

    preg_match_all("'<a class=\"publisher\" href=\"(.*?)\"><span>(.*?)</span></a>'si", $file, $publisher);
    $_publishers = $publisher[2];

    preg_match_all("'<div class=\"col2\">(.*?)</div>\s*<div class=\"col3\">'si", $file, $all_prices_old);
    $_all_prices_old = $all_prices_old[1];

    $_prices_old = [];
    foreach ($_all_prices_old as $key => $value) {

      preg_match_all("'<span class=\"prd_view_price_value price_cancelled\"><span id=\"prd_price_display\">(.*?)<sup>(.*?)</sup>'si", $value, $output);

      if (!empty($output[0][0])) {
        $_prices_old[$key] = preg_replace("/[^0-9,.|]/", "", $output[1][0]) . preg_replace("/[^0-9,.|]/", "", $output[2][0]);
      } else {
        $_prices_old[$key] = NULL;
      }
    }

    preg_match_all("'<span class=\"prd_view_price_value final_price\">\s*<span\s*id=\"prd_final_price_display\">(.*?)<sup>(.*?)</sup>'mi", $file, $prices);

    if (!empty($prices[0][0])) {
      $_prices[0] = $prices[1][0] . $prices[2][0];
    } else {
      $_prices = $prices;
    }

    preg_match_all("'<div class=\"prd_view_img_box\">(.*?)</div>\s*<div class=\"col2\">'si", $file, $all_prices_percent);
    $_all_prices_percent = $all_prices_percent[1];

    $_prices_percent = [];
    foreach ($_all_prices_percent as $key => $value) {

      preg_match_all("'<div class=\"discount_img\" title=\"(.*?)\"><sub>%</sub>(.*?)</div>'si", $value, $output);

      if (!empty($output[0][0])) {
        $_prices_percent[$key] = preg_replace("/[^0-9,.|]/", "", $output[2][0]);
      } else {
        $_prices_percent[$key] = NULL;
      }
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

    preg_match_all("'<a title=\"(.*?)\"\s*class=\"tooltip-ajax\"\s*href=\"(.*?)\">\s*<img class=\"prd_img prd_img_(.*?)\" width=\"100\" height=\"100\" src=\"(.*?)\"'mi", $file, $cards);
    $_names = $cards[1];
    $_links = $cards[2];
    $_images = $cards[4];

    preg_match_all("'<div class=\"prd_info\">(.*?)<div class=\"publisher\">'si", $file, $all_authors);
    $_all_authors = $all_authors[1];

    $_authors = [];
    foreach ($_all_authors as $key => $value) {

     preg_match_all("'<div class=\"writer\"><a href=\"(.*?)\">(.*?)</a></div>'si", $value, $output);

     if (!isset($output[0][0])) {
      $_authors[$key] = NULL;
    } else {
      $_authors[$key] = $output[2][0];
    }
  }

  preg_match_all("'<div class=\"publisher\"><a href=\"(.*?)\">(.*?)</a></div>'si", $file, $publisher);
  $_publishers = $publisher[2];

  preg_match_all("'<span class=\"price price_sale convert_cur\" data-price=\"(.*?)\" data-cur-code=\"(.*?)\">'si", $file, $prices);
  $_prices = $prices[1];

  preg_match_all("'<span class=\"price price_list convert_cur\" data-price=\"(.*?)\" data-cur-code=\"(.*?)\"></span>'si", $file, $prices_old);
  $_prices_old = $prices_old[1];

  foreach ($_prices_old as $key => $value) {

    if ($value == $_prices[$key]) {
      $_prices_old[$key] = NULL;
    }
  }

  preg_match_all("'<div class=\"image_container\">(.*?)<div class=\"prd_info\">'si", $file, $all_prices_percent);
  $_all_prices_percent = $all_prices_percent[1];

  $_prices_percent = [];
  foreach ($_all_prices_percent as $key => $value) {

    preg_match_all("'<div class=\"discount\"><sub>%</sub>(.*?)</div>'si", $value, $output);

    if (!empty($output[0][0])) {
      $_prices_percent[$key] = preg_replace("/[^0-9,.|]/", "", $output[1][0]);
    } else {
      $_prices_percent[$key] = NULL;
    }
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
