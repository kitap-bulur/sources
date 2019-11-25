<?php

class OkuokuController extends V4Controller {

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

    $data = self::_cache_search("https://www.okuoku.com/urun/listele/yeni-cikanlar/2/sirala/2");

    $json = self::_query_json_template(200, "En Yeniler", $data);
    return $this->render(["text" => $json], ["content_type" => "application/json"]);
  }

  public function tops() {

    $data = self::_cache_search("https://www.okuoku.com/urun/listele/cok-satanlar/1");

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
    $data = self::_cache_search("https://www.okuoku.com/arama/?filter=" . $post_text);

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

    preg_match_all("'<span class=\"img-wrap img-wrap-visible\" style=\"width:145px;\">\s*<img style=\"display: block;\" width=\"145\" class=\"mx lazyload\" alt=\"(.*?)\" src=\"(.*?)\">\s*</span>'si", $file, $images);
    $_images = $images[2];
print_r($_images);

    preg_match_all("'<a style=\"text-decoration: none !important;\" class=\"u-url\" href=\"(.*?)\">\s*<h5 class=\"p-name\">(.*?)</h5>\s*</a>'si", $file, $cards);
    $_links = $cards[1];
    $_names = $cards[2];
    print_r($cards);

    preg_match_all("'<h6 class=\"p-brand\"><span><a href=\"(.*?)\">\s*<span>(.*?)\s*</span>\s*</a>\s*</span>\s*</h6>\s*<h6 class=\"p-brand\"><span><a href=\"(.*?)\">\s*<span>(.*?)\s*</span>\s*</a>\s*</span>\s*</h6>\s*<div class=\"stars clearfix\">'si", $file, $cards);

    $_authors = $cards[1];
    $_publishers = $cards[2];
    print_r($cards);
    exit();

    preg_match_all("'<span class=\"yuzde\">%(.*?)<span>indirim</span></span>'si", $file, $prices_percent);
    $_prices_percent = $prices_percent[1];

    preg_match_all("'<span class=\"ty-list-price ty-strike\" id=\"(.*?)\">(.*?)</span>'si", $file, $prices_old);
    $_prices_old = $prices_old[2];

    preg_match_all("'<div class=\"top-eksi\"><span class=\"old-price\">(.*?)</span>\s*<span class=\"p-price\">(.*?)</span></div>'si", $file, $all_prices);
    $_all_prices = $all_prices[2];
    $prices_old = $_all_prices[1];
    $prices = $_all_prices[2];

    foreach ($_prices_old as $i => $value) {
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

