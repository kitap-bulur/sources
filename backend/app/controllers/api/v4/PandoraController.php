<?php

class PandoraController extends V4Controller {

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

  private static function _cache_bests($query_url) {
    $cache_name = "DR_BESTS_" . $query_url;

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

  public function news() {

    $data = self::_cache_search("https://www.pandora.com.tr/Yeni_Kitaplar");

    $json = self::_query_json_template(200, "En Yeniler", $data);
    return $this->render(["text" => $json], ["content_type" => "application/json"]);
  }

  public function tops() {

    $data = self::_cache_bests("https://www.pandora.com.tr/Cok_Satan_Kitaplar");

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
    $data = self::_cache_search("https://www.pandora.com.tr/Arama/?type=9&kitapadi=&yazaradi=&yayinevi=&isbn=" . $post_text . "&dil=&siteid=&kategori=&sirala=0");

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

    preg_match_all("'<img src=\'(.*?)\' alt=\'(.*?)\' >\s*</div>\s*</div>\s*<p class=\"edebiyatIsim\"><a href=\"(.*?)\"><strong>(.*?)</strong></a></p>\s*<p class=\"edebiyatYazar\"><a href=\"(.*?)\">(.*?)</a></p>\s*<p class=\"edebiyatYayinEvi\">(.*?)</p>\s*<p class=\"edebiyatFiyat\"><span class=\"eskiFiyat\">(.*?)</span></p>\s*<p class=\"indirimliFiyat\">Site Fiyatı: (.*?)</p>'si", $file, $cards);

    $_images = $cards[1];
    $_links = $cards[3];
    $_names = $cards[4];
    $_authors = $cards[6];
    $_publishers = $cards[7];
    $_prices_old = $cards[8];
    $_prices = $cards[9];

    foreach ($_links as $i => $value) {
      $_links[$i] = "https://www.pandora.com.tr" . $_links[$i];
      $_images[$i] = "https://www.pandora.com.tr" . $_images[$i];
    }

    preg_match_all("'<span class=\"indirimYuzde\">%<strong>(.*?)</strong></span>'si", $file, $prices_percent);
    $_prices_percent = $prices_percent[1];

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
  private static function _query_bests($query_url) {
    $context = stream_context_create(
      array(
        "http" => array(
          "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
          )
        )
      );

    $file = file_get_contents($query_url, false, $context);

    preg_match_all("'<h4 class=\"yeniKitapBaslik\">(.*?)</h4>'si", $file, $names);
    $_names = $names[1];

    preg_match_all("'<span class=\"indirimYuzde\">%<strong>(.*?)</strong></span>'si", $file, $prices_percent);
    $_prices_percent = $prices_percent[1];

    preg_match_all("'<a href=\"(.*?)\" class=\"urunCover\">\s*<span class=\"urunDetayIkon posAbs border-radius\">Ürün detayı</span>\s*</a>'mi", $file, $links);
    $_links = $links[1];

    preg_match_all("'</button>\s*<img src=\'(.*?)\' alt=\'(.*?) - (.*?)\' >'si", $file, $cards);
    $_images = $cards[1];

    foreach ($_links as $i => $value) {
      $_links[$i] = "https://www.pandora.com.tr" . $_links[$i];
      $_images[$i] = "https://www.pandora.com.tr" . $_images[$i];
    }

    preg_match_all("'<p class=\"eskiFiyat\"><!--Fiyatı: --><span class=\"eskiFiyat\">(.*?)</span>TL</p>\s*<p class=\"yeniKitapIndirimli indirimliFiyat\">Site Fiyatı:  (.*?)</p>'si", $file, $cards);
    $_prices_old = $cards[1];
    $_prices = $cards[2];

    preg_match_all("'<p class=\"yeniKitapYazar\"><a href=\"(.*?)\">(.*?)</a></p>\s*<p class=\"yeniKitapYayinEvi\">(.*?)</p>'si", $file, $cards);
    $_authors = $cards[1];
    $_publishers = $cards[1];

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
