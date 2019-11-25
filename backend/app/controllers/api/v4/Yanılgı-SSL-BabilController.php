<?php

class BabilController extends V4Controller {

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

    $data = self::_cache_search("https://www.babil.com/kitap/yeni-kitaplar");

    $json = self::_query_json_template(200, "En Yeniler", $data);
    return $this->render(["text" => $json], ["content_type" => "application/json"]);
  }

  public function tops() {

    $data = self::_cache_search("https://www.babil.com/kitap/cok-satanlar");

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
    $data = self::_cache_search("https://www.babil.com/arama?q=" . $post_text);

    if ($data) {
      $json = self::_query_json_template(200, "Başarılı istek", $data);
      return $this->render(["text" => $json], ["content_type" => "application/json"]);
    } else {
      $json = self::_query_json_template(404, "Üzgünüm aradığım kaynaklarımda ürününüzü bulamadım.");
      return $this->render(["text" => $json], ["content_type" => "application/json"]);
    }
  }

  private static function _query_search($query_url) {
$file = file_get_contents($url, false, stream_context_create(array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false,            "allow_self_signed" => false,
))));

  //  $file = file_get_contents($query_url);

    preg_match_all("'<div class=\"plist-item clearfix\">\s*<div class=\"col-md-3 col-sm-3 col-xs-6 col-xs-offset-3 col-sm-offset-0 text-center\">\s*<div class=\"plist-image-wrapper\">\s*<a title=\"(.*?)\" href=\"(.*?)\">\s*<img data-src=\"(.*?)\" alt=\"(.*?)\" class=\"img-responsive plist-image lazy\" />\s*</a>\s*<span class=\"plist-indirim-badge hidden-xs\"><span class=\"degree\">\s*<span class=\"medium\">%(.*?)</span>\s*<span class=\"small\">indirim</span></span></span>\s*<!-- badges for xsmall viewport -->\s*<div class=\"text-center mb10\">\s*<div class=\"badge\" style=\"background-color: orange;\">%(.*?) indirimli!</div>\s*</div>\s*<!-- badges for xsmall viewport end -->\s*</div>\s*</div>\s*<div class=\"col-md-9 col-sm-9 col-xs-12\">\s*<div class=\"plist-info\">\s*<h2 itemprop=\"name\">\s*<a href=\"(.*?)\">(.*?)</a>\s*</h2>\s*<h3 class=\"author\">\s*<a href=\"(.*?)\">(.*?)</a>\s*</h3>\s*<h4 class=\"store\"><a href=\"(.*?)\">(.*?)</a></h4>\s*<div>\s*<span class=\"old-price\">(.*?)</span>\s*<span class=\"new-price\">(.*?)</span>
      'mi", $file, $cards);


    $_names = $cards[1];
    $_links = $cards[2];
    $_images = $cards[3];
    $_prices_percent = $cards[5];
    $_authors = $cards[10];
    $_publishers = $cards[12];;
    $_prices_old = $cards[13];
    $_prices = $cards[14];

      foreach ($_links as $i => $value)
        $_links[$i] = "https://www.nobelkitap.com" . $value;

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

