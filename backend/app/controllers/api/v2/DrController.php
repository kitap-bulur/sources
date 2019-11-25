<?php

class DrController extends V2Controller {

  public function pages() {
    $pages = [];

    $page1 = [
      "title" => "Kullanım Şartları",
      "content" => [
        [
          "subtitle" => "UYGULUMA MÜLKİYETİ; KULLANIM ŞEKLİ ANLAŞMASI",
          "subcontent" => "DR Store aracılığıyla sunulan hizmetlerin fikri ve sınai mülkiyet hakları DR Store'ye aittir. DR Store'nin içeriğini ve altyapısını oluşturan bölümlerinin, kaynak kodlarının, metinlerinin ve görsellerinin tümü ya da bir kısmı DR Store izni olmadan basılı ya da internet ortamında kullanılamaz, çoğaltılamaz. DR Store'ye ait ya da DR Store tarafından sağlanan tüm kurumsal logolar, görseller, fotoğraflar yazılı izin alınmadan basılı ya da internet ortamında kullanılamaz, çoğaltılamaz. Kullanıcılar tarafından, bu yönde bir olanak sağlanması halinde, DR Store'ye gönderilen, iletilen, kullanılan, oluşturulan ya da DR Store aracılığıyla 3. şahıslara iletilen her türlü kullanıcı içeriğinin gizlilik niteliğinin ortadan kalktığı ve herhangi bir fikri ve sınai hakkı/telif/lisans hakkını içermediği kabul edilir. Kullanıcılar gizli ya da üzerinde fikri ve sınai mülkiyet hakkı olduğu düşünülen herhangi bir içerik oluşturup hesabına eklediğinde bu içeriğin 'hukuki bir ayıp' içermediği ve bunları dijital iletim suretiyle yayınlama hakkı olduğu kabul edilir. Aksi halde tüm sorumluluk yasal ihlal oluşturan içeriği gönderen kullanıcıya aittir. DR Store tarafından sunulan dosyalar, yazılmış özgün içerik, görseller, açıklamalar ve benzeri ögeler ile tüm lisanslı tablo, lisanslı analiz ve lisanslı grafikler, kişisel bilgiler ve kurumsal şirket hakları nedeniyle DR Store'ın yazılı izni olmadan hiçbir ortamda yayınlanamaz, kullanılamaz, çoğaltılamaz. Kurumlar ile yapılan kiralama anlaşmaları gereği DR Store 'ın hak sahipliği ve yukarıda tanımlanan hakların ihlalinin tespiti sonucunda DR Store, yasal işlem başlatma hakkına sahiptir. Kullanıcıların DR Store'ye dahil olmasıyla bu telif hakkı bildirisini kabul ettiğini taahhüt eder."
        ],
        [
          "subtitle" => "İÇERİK",
          "subcontent" => "Tasarım, yapı, seçim, koordinasyon, ifade, sınırlama dahil olmak ancak bunlarla sınırlı olmaksızın tüm metin, grafik, kullanıcı arabirimleri, görsel arayüzler, fotoğraflar, ticari markalar, logolar, sesler, müzik, resim ve bilgisayar kodu (topluca 'İçerik' Uygulamada yer alan, İçerikte yer alan, kontrol edilen veya lisanslanan ve DR Store tarafından lisanslanan ve ticaret elbisesi, telif hakkı, patent ve ticari marka yasaları ile çeşitli fikri mülkiyet hakları ve haksız rekabet yasaları ile korunan, 'görünüş ve his' ve düzenlenmesi. Bu Kullanım Koşullarında açıkça belirtilmediği sürece, Uygulamanın hiçbir kısmı ve İçeriği, herhangi bir şekilde ('yansıtma' da dahil olmak üzere) kopyalanamaz, çoğaltılamaz, yeniden yayınlanamaz, yüklenemez, yayınlanır, kamuya açık şekilde görüntülenemez, kodlanmaz, tercüme edilemez, iletilemez veya dağıtılamaz. DR Store ürününü ve hizmetlerini (veri sayfaları, bilgi tabanı makaleleri ve benzeri materyaller gibi), Uygulamadan indirilmek üzere DR Store tarafından kullanılabilir hale getirmek için kullanabilirsiniz; ancak şu koşullar sağlanır: (1) tüm kopyalarında herhangi bir tescilli bildirim dilini kaldırmazsınız (2) bu tür bilgileri yalnızca kişisel, ticari olmayan bilgi amaçlı kullanın ve bu tür bilgileri ağa bağlı bir bilgisayara kopyalamayın veya yayınlamayın veya herhangi bir ortamda yayınlamayın, (3) bu tür herhangi bir bilgide herhangi bir değişiklik yapmayın ve (4) bu tür belgelerle ilgili ek beyan veya garanti vermeyin."
        ],
        [
          "subtitle" => "ÇEREZLER",
          "subcontent" => "Çerezler, DR Store'nin sağladığı işlevlerin sağlıklı çalışmasını sağlayan, kullanıcının bilgisayarına tarayıcı aracılığıyla yerleştirilen küçük bir dosyadır. DR Store çerezleri cihazları tanınması, güvenli bir şekilde erişim sağlanması, güvenlik kontrolleri gibi teknik alanlar ya da kullancının kullanımına göre özelleştirilmiş seçenekler sunmak dışında kullanılmaz. Çerezlere kişisel verileriniz asla yerleştirilmez."
        ],
      ]
    ];
    $page2 = [
      "title" => "Gizlilik Politikası",
      "content" => [
        [
          "subtitle" => "TELİF HAKLARI",
          "subcontent" => "DR Store aracılığıyla sunulan hizmetlerin fikri ve sınai mülkiyet hakları DR Store'ye aittir. DR Store'nin içeriğini ve altyapısını oluşturan bölümlerinin, kaynak kodlarının, metinlerinin ve görsellerinin tümü ya da bir kısmı DR Store izni olmadan basılı ya da internet ortamında kullanılamaz, çoğaltılamaz. DR Store'ye ait ya da DR Store tarafından sağlanan tüm kurumsal logolar, görseller, fotoğraflar yazılı izin alınmadan basılı ya da internet ortamında kullanılamaz, çoğaltılamaz. Kullanıcılar tarafından, bu yönde bir olanak sağlanması halinde, DR Store'ye gönderilen, iletilen, kullanılan, oluşturulan ya da DR Store aracılığıyla 3. şahıslara iletilen her türlü kullanıcı içeriğinin gizlilik niteliğinin ortadan kalktığı ve herhangi bir fikri ve sınai hakkı/telif/lisans hakkını içermediği kabul edilir. Kullanıcılar gizli ya da üzerinde fikri ve sınai mülkiyet hakkı olduğu düşünülen herhangi bir içerik oluşturup hesabına eklediğinde bu içeriğin 'hukuki bir ayıp' içermediği ve bunları dijital iletim suretiyle yayınlama hakkı olduğu kabul edilir. Aksi halde tüm sorumluluk yasal ihlal oluşturan içeriği gönderen kullanıcıya aittir. DR Store tarafından sunulan dosyalar, yazılmış özgün içerik, görseller, açıklamalar ve benzeri ögeler ile tüm lisanslı tablo, lisanslı analiz ve lisanslı grafikler, kişisel bilgiler ve kurumsal şirket hakları nedeniyle DR Store'nin yazılı izni olmadan hiçbir ortamda yayınlanamaz, kullanılamaz, çoğaltılamaz. Kurumlar ile yapılan kiralama anlaşmaları gereği DR Store'nin hak sahipliği ve yukarıda tanımlanan hakların ihlalinin tespiti sonucunda DR Store, yasal işlem başlatma hakkına sahiptir. Kullanıcıların DR Store'ye dahil olmasıyla bu telif hakkı bildirisini kabul ettiğini taahhüt eder."
        ],
        [
          "subtitle" => "GİZLİLİK",
          "subcontent" => "DR Store'de yer alan barkodlar sadece bilgilendirme amaçlıdır. Fiyat geçerlilik 'Türkiye Geneli' ise genel olarak satıldığı ortalama rakam fiyat olarak bulmaktadır. Uygulamada yer alan fiyatların ve fiyat geçerlilik yerinin bir kesinliği bulunmamakla beraber ürün-fiyat eşleşmesi de hatalı olabilir. Bu bilgilerin kullanımından doğacak sorumluluk kullanan kişiye aittir, DR Store herhangi bir sorumluluk kabul etmez. Kullanıcı bu uygulamayı kullanarak bu şartları kabul etmiş sayılır. DR Store bireylerin mahremiyetine saygı duyar ve kişilere ait toplanan verileri yasal zorunluluklar hali dışında üçüncü şahıslarla asla paylaşmaz; şahsi bilgilerinizin güvenliği için tüm tedbirlerin alındığını taahhüt eder. Kişisel verileriniz reklam, kampanya, veri madenciliği ve benzer maksatlarla satılması söz konusu değildir. Kurumların bilgi, sonuç, değerlendirme ve benzeri verileri DR Store tarafından kurumlara sunulan analizlerin dışında üçüncü kişilerle paylaşılmaz. Bu veriler geçmişe dönük olarak DR Store tarafından saklanabilir ve kurum için yapılacak uzun vadeli analizlerde tekrar kullanılabilir. DR Store ilgili verilerin güvenliği için tüm tedbirlerin alındığını taahhüt eder."
        ],
        [
          "subtitle" => "ÇEREZLER",
          "subcontent" => "Çerezler, DR Store'nin sağladığı işlevlerin sağlıklı çalışmasını sağlayan, kullanıcının bilgisayarına tarayıcı aracılığıyla yerleştirilen küçük bir dosyadır. DR Store çerezleri cihazları tanınması, güvenli bir şekilde erişim sağlanması, güvenlik kontrolleri gibi teknik alanlar ya da kullancının kullanımına göre özelleştirilmiş seçenekler sunmak dışında kullanılmaz. Çerezlere kişisel verileriniz asla yerleştirilmez."
        ],
      ]
    ];
    $pages[] = $page1;
    $pages[] = $page2;

    $json = self::_query_json_template(200, "Sayfa bilgileri getirildi", $pages);
    return $this->render(["text" => $json], ["content_type" => "application/json"]);
  }

  public function top_news() {

    $data = self::_cache_top("https://www.dr.com.tr/Kategori_/Kitap/En-Yeniler/10001/3");

    $json = self::_query_json_template(200, "Top Yeniler", $data);
    return $this->render(["text" => $json], ["content_type" => "application/json"]);
  }

  public function top_books() {

    $data = self::_cache_top("https://www.dr.com.tr/CokSatanlar/Kitap");

    $json = self::_query_json_template(200, "Top Kitaplar", $data);
    return $this->render(["text" => $json], ["content_type" => "application/json"]);
  }

  public function search_text() {

    if (!isset($_POST["text"])) {
      $json = self::_query_json_template(429, "Verilerde eksiklik var!");
      return $this->render(["text" => $json], ["content_type" => "application/json"]);
    }

    $post_text = $_POST["text"];

    $post_page = isset($_POST["page"]) ? $_POST["page"] : 1;

    $data = self::_cache_search($post_text, $post_page);

    if ($data) {
      $json = self::_query_json_template(200, "Başarılı istek", $data);
      return $this->render(["text" => $json], ["content_type" => "application/json"]);
    } else {
      $json = self::_query_json_template(404, "Üzgünüm aradığım kaynaklarımda ürününüzü bulamadım.");
      return $this->render(["text" => $json], ["content_type" => "application/json"]);
    }
  }

  private static function _cache_search($query_name, $page_number = 1) {
    $query_name = preg_replace("/ /", "%20", $query_name);
    $cache_name = "DR_SEARCH_" . $query_name . "#/page=" . $page_number;

    if (ApplicationCache::exists("$cache_name")) {

      $data = ApplicationCache::read("$cache_name");

    } else {
      // text search, fetch [data, data] or NULL
      $query_url = "https://www.dr.com.tr/search?q=" . $query_name . "#/page=" . $page_number . "/sort=relevance,desc/categoryid=0/parentId=0/lg=undefined/price=-1,-1/ldir=h";

      $data = self::_query_search($query_url);

      if ($data) {
        ; // ApplicationCache::write("$cache_name", $data);
      } else {
        return NULL;
      }
    }

    return $data;
  }

  private static function _cache_top($query_name) {
    $cache_name = "DR_TOP_" . $query_name;

    if (ApplicationCache::exists("$cache_name")) {

      $data = ApplicationCache::read("$cache_name");

    } else {
      // text search, fetch [data, data] or NULL
      $query_url = $query_name;

      $data = self::_query_top($query_url);

      if ($data) {
        ;// ApplicationCache::write("$cache_name", $data);
      } else {
        return NULL;
      }
    }

    return $data;
  }

  private static function _query_search($query_url) {

    $file = file_get_contents($query_url);

    preg_match_all("'<figure>\s*<a href=\"(.*?)\" class=\"item-name\">\s*<img src=\"(.*?)\" alt=\"(.*?)\"\s*/>\s*</a>\s*</figure>'si", $file, $cards);
    $_names = $cards[3];
    $_images = $cards[2];
    $_links = $cards[1];

    foreach ($_links as $i => $value)
      $_links[$i] = "https://www.dr.com.tr" . $value;

    preg_match_all("'<div class=\"prices\">\s*(.*?)\s*</div>'si", $file, $prices_all);
    $_prices_all = $prices_all[1];

    $_prices_old = [];
    $_prices = [];
    $_prices_percent = [];
    foreach ($_prices_all as $i => $value) {

      preg_match_all("'<span\s*.*?>(.*?)</span>'si", $value, $output);
      $_output = $output[1];
      if (count($_output) == 3) {
        $_prices_old[$i] = preg_replace("/[^0-9,.|]/", "", $_output[0]);
        $_prices[$i] = preg_replace("/[^0-9,.|]/", "", $_output[1]);
        $_prices_percent[$i] = preg_replace("/[%]/", "", $_output[2]);
      }
      else {
        $_prices_old[$i] = NULL;
        $_prices[$i] = preg_replace("/[^0-9,.|]/", "", $_output[0]);
        $_prices_percent[$i] = NULL;
      }
    }

    preg_match_all("'class=\"who mb10\">(.*?)</'si", $file, $publishers);
    $_publishers = $publishers[1];

    preg_match_all("'class=\"who\">(.*?)</'si", $file, $authors);
    $_authors = $authors[1];

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

  private static function _query_top($query_url) {

    $file = file_get_contents($query_url);

    preg_match_all("'<a title=\"(.*?)\" href=\"(.*?)\">\s*<figure>\s*<img class=\"lazyload\" data-src=\"(.*?)\" alt=\"(.*?)\" />\s*<div class=\"p-info\">\s*</div>\s*</figure>\s*</a>'mi", $file, $cards);
    $_names = $cards[1];
    $_links = $cards[2];
    $_images = $cards[3];

    foreach ($_links as $i => $value)
      $_links[$i] = "https://www.dr.com.tr" . $value;

    preg_match_all("'<div class=\"content\">.*?<div class=\"p-info\">.*?</div>.*?<div class=\"media-type\">.*?</div>.*?<div class=\"media-type\">.*?</div>(.*?)</div>'si", $file, $prices_all);
    $_prices_all = $prices_all[1];

    $_prices_old = [];
    $_prices = [];
    $_prices_percent = [];
    foreach ($_prices_all as $i => $value) {

      preg_match_all("'<span\s*.*?>(.*?)</span>'si", $value, $output);

      $_output = $output[1];
      if (count($_output) == 3) {
        $_prices_old[$i] = preg_replace("/[^0-9,.|]/", "", $_output[0]);
        $_prices[$i] = preg_replace("/[^0-9,.|]/", "", $_output[2]);
        $_prices_percent[$i] = preg_replace("/[%]/", "", $_output[1]);
      } else {
        $_prices_old[$i] = NULL;
        $_prices[$i] = preg_replace("/[^0-9,.|]/", "", $_output[0]);
        $_prices_percent[$i] = NULL;
      }
    }

    preg_match_all("'class=\"who mb10\">(.*?)</'si", $file, $publishers);
    $_publishers = $publishers[1];

    preg_match_all("'class=\"who\">(.*?)</'si", $file, $authors);
    $_authors = $authors[1];

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
