<?php

class KitapsecController extends V4Controller {

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

    $data = self::_cache_search("https://www.kitapsec.com/Yeni-Cikanlar/");

    foreach ($data as $key => $value) {
      $data[$key] = mb_convert_encoding($value, "UTF-8", "windows-1254");
    }

    $json = self::_query_json_template(200, "En Yeniler", $data);
    return $this->render(["text" => $json], ["content_type" => "application/json"]);
  }

  public function tops() {

    $data = self::_cache_search("https://www.kitapsec.com/Cok-Satanlar/");

    foreach ($data as $key => $value) {
      $data[$key] = mb_convert_encoding($value, "UTF-8", "windows-1254");
    }

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
    $data = self::_cache_search("https://www.kitapsec.com/Arama/index.php?a=" . $post_text);

    foreach ($data as $key => $value) {
      $data[$key] = mb_convert_encoding($value, "UTF-8", "windows-1254");
    }

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

    preg_match_all("'<img data-original=\"//(.*?)\" itemprop=\"image\"  src=\"//(.*?)\" class=\"lazy\" height=\"110\" border=\"0\" alt=\"\" title=\"(.*?)\"/>'si", $file, $cards);
    $_images = $cards[1];
    $_fullnames = $cards[3];

    preg_match_all("'<span style=\"display:none;\" itemprop=\"name\">(.*?)</span>'mi", $file, $publishers);
    $_publishers = $publishers[1];

    preg_match_all("'<div class=\"Ks_UrunSatir\"\s*itemscope\s*itemtype=\"http://schema.org/Book\" id=\"(.*?)\">\s*(.*?)\s*<div class=\"ribbon_blok\">'si", $file, $authors);
    $_authors = $authors[2];

    foreach ($_authors as $key => $value) {
      preg_match_all("'<a itemprop=\"url\"\s*class=\"alt\" href=\"(.*?)\">\s*<span itemprop=\"name\">\s*(.*?)\s*</span>'si", $value, $output);

      if (!empty($output[0][0])) {
        $_authors[$key] = $output[2][0];
      } else {
        $_authors[$key] = NULL;
      }
    }

    preg_match_all("'<div class=\"Ks_UrunSatir\"\s*itemscope\s*itemtype=\"http://schema.org/Book\" id=\"(.*?)\">'si", $file, $links);
    $_links = $links[1];

    $_names = [];
    foreach ($_fullnames as $key => $value) {
      $clear1 = str_replace($_publishers[$key], "", $value);
      $clear2 = str_replace($_authors[$key], "", $clear1);
      $_names[$key] = trim($clear2);
    }

    preg_match_all("'<a href=\"(.*?)\" class=\"hmnAl loadClick\">Hemen Al</a></div>(.*?)<a\s*href=\"(.*?)\"\s*border=\"0\" class=\"img\">'si", $file, $prices_percent);
    $_prices_percent = $prices_percent[2];
    foreach ($_prices_percent as $key => $value) {

      preg_match_all("'<span class=\"indirimOval\">(.*?)</span>'si", $value, $output);

      if (!empty($output[0][0])) {
        $_prices_percent[$key] = $output[1][0];
      } else {
        $_prices_percent[$key] = NULL;
      }
    }

    preg_match_all("'<span class=\"fiyat\"><font class=\"piyasa\".*?>(.*?)</font><font class=\"satis\">(.*?)</font>\s*</span>'si", $file, $prices);

    $_prices_old = $prices[1];
    $_prices = $prices[2];

    foreach ($_prices_old as $i => $value) {
      $_prices_percent[$i] = preg_replace("/[^0-9,.|]/", "", $_prices_percent[$i]);
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

