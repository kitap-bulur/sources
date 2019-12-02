<?php

class IsbnController extends V4Controller {

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

  public function search() {

    if (!isset($_POST["text"])) {
      $json = self::_query_json_template(429, "Verilerde eksiklik var!");
      return $this->render(["text" => $json], ["content_type" => "application/json"]);
    }

    $post_text = $_POST["text"];
    $post_text = urlencode($post_text);
    $data = self::_cache_search("https://www.kitapyurdu.com/index.php?route=product/search&filter_name=" . $post_text);

    if ($data) {
      $json = self::_query_json_template(200, "Başarılı istek", $data);
      return $this->render(["text" => $json], ["content_type" => "application/json"]);
    } else {
      $json = self::_query_json_template(404, "Üzgünüm aradığım kaynaklarımda ürününüzü bulamadım.");
      return $this->render(["text" => $json], ["content_type" => "application/json"]);
    }
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

    preg_match_all("'<a href=\"(.*?)\"  >\s*<img itemprop=\"image\"  src=\"(.*?)\" alt=\"(.*?)\" /></a>'mi", $file, $cards);

    $_links = $cards[1];
    $_images = $cards[2];
    $_names = $cards[3];

    preg_match_all("'<span itemprop=\"publisher\" itemscope itemtype=\"http://schema.org/Organization\"><a itemprop=\"url\" class=\"alt\" href=\"(.*?)\"><span itemprop=\"name\">\s*(.*?)</span></a>'si", $file, $publishers);

    $_publishers = $publishers[2];

    preg_match_all("'<div class=\"author\">Yazar : <span itemscope itemtype=\"http://schema.org/Person\" itemprop=\"author\"><a itemprop=\"url\"  class=\"alt\" href=\"(.*?)\"> <span itemprop=\"name\">\s*(.*?)</span></a>'si", $file, $authors);

    $_authors = $authors[2];

    preg_match_all("'<meta itemprop=\"isbn\" content=\"(.*?)\" />'si", $file, $barcodes);

    $_barcodes = $barcodes[1];
    foreach ($_barcodes as $key => $value) {
      $_barcodes[$key] = "978" . $value;
    }

    if (isset($_names[0])) {

      $datas = [];
      foreach ($_names as $i => $value) {
        $datas[] = [
          "name" => $_names[$i],
          "image" => $_images[$i],
          "author" => $_authors[$i],
          "publishers" => $_authors[$i],
          "barcode" => $_barcodes[$i]
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
