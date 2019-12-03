<?php

class AppController extends V4Controller {

  const SERVICES = [
    [
      "id" => "0",
      "name" => "D&R Store",
      "image" => "http://www.akgenseeds.com/app/assets/img/1.png",
      "subname" => "dr"
    ],
    [
      "id" => "1",
      "name" => "Idefix",
      "image" => "http://www.akgenseeds.com/app/assets/img/3.png",
      "subname" => "idefix"
    ],
    [
      "id" => "2",
      "name" => "Pandora",
      "image" => "http://www.akgenseeds.com/app/assets/img/4.png",
      "subname" => "pandora"
    ],
    [
      "id" => "3",
      "name" => "Kidega",
      "image" => "http://www.akgenseeds.com/app/assets/img/5.png",
      "subname" => "kidega"
    ],
    [
      "id" => "4",
      "name" => "Bkm",
      "image" => "http://www.akgenseeds.com/app/assets/img/6.png",
      "subname" => "bkm"
    ],
    [
      "id" => "5",
      "name" => "Kitapsec",
      "image" => "http://www.akgenseeds.com/app/assets/img/7.png",
      "subname" => "kitapsec"
    ],
    [
      "id" => "6",
      "name" => "Ucuz Kitap Al",
      "image" => "http://www.akgenseeds.com/app/assets/img/8.png",
      "subname" => "uka"
    ],
    [
      "id" => "7",
      "name" => "Amazon",
      "image" => "http://www.akgenseeds.com/app/assets/img/9.png",
      "subname" => "amazon"
    ],
    [
      "id" => "8",
      "name" => "Kitap Koala",
      "image" => "http://www.akgenseeds.com/app/assets/img/10.png",
      "subname" => "koala"
    ],
    [
      "id" => "9",
      "name" => "Nobel Kitap",
      "image" => "http://www.akgenseeds.com/app/assets/img/11.png",
      "subname" => "nobelkitap"
    ],
    [
      "id" => "10",
      "name" => "Kitap Sihirbazı",
      "image" => "http://www.akgenseeds.com/app/assets/img/12.png",
      "subname" => "kitapsihirbazi"
    ],
    [
      "id" => "11",
      "name" => "Pelikan Kitap Evi",
      "image" => "http://www.akgenseeds.com/app/assets/img/13.png",
      "subname" => "pelikankitabevi"
    ],
    [
      "id" => "12",
      "name" => "Hepsiburada",
      "image" => "http://www.akgenseeds.com/app/assets/img/2.png",
      "subname" => "hb"
    ]
  ];

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

  public function services() {
    $json = self::_query_json_template(200, "Servis Listeleri", self::SERVICES);
    return $this->render(["text" => $json], ["content_type" => "application/json"]);
  }

  public function news() {

    if (!isset($_POST["service"])) {
      $json = self::_query_json_template(429, "Verilerde eksiklik var!");
      return $this->render(["text" => $json], ["content_type" => "application/json"]);
    }

    $post_service = $_POST["service"];
    $service = self::SERVICES[$post_service];
    $subname = $service["subname"];

    $http = new ApplicationHttp();
    $response = $http->post("http://www.akgenseeds.com/api/v4/" . $subname . "/news", $_POST);
    $result = $response->body;

    return $this->render(["text" => $result], ["content_type" => "application/json"]);
  }

  public function tops() {

    if (!isset($_POST["service"])) {
      $json = self::_query_json_template(429, "Verilerde eksiklik var!");
      return $this->render(["text" => $json], ["content_type" => "application/json"]);
    }

    $post_service = $_POST["service"];
    $service = self::SERVICES[$post_service];
    $subname = $service["subname"];

    $http = new ApplicationHttp();
    $response = $http->post("http://www.akgenseeds.com/api/v4/" . $subname . "/tops", $_POST);
    $result = $response->body;

    return $this->render(["text" => $result], ["content_type" => "application/json"]);
  }

  public function search() {

    if (!isset($_POST["service"])) {
      $json = self::_query_json_template(429, "Verilerde eksiklik var!");
      return $this->render(["text" => $json], ["content_type" => "application/json"]);
    }

    $post_service = $_POST["service"];
    $service = self::SERVICES[$post_service];
    $subname = $service["subname"];

    $http = new ApplicationHttp();
    $response = $http->post("http://www.akgenseeds.com/api/v4/" . $subname . "/search", $_POST);
    $result = $response->body;

    return $this->render(["text" => $result], ["content_type" => "application/json"]);
  }

  public function detail() {

    if (!isset($_POST["service"])) {
      $json = self::_query_json_template(429, "Verilerde eksiklik var!");
      return $this->render(["text" => $json], ["content_type" => "application/json"]);
    }

    $post_service = $_POST["service"];
    $service = self::SERVICES[$post_service];
    $subname = $service["subname"];

    $http = new ApplicationHttp();
    $response = $http->post("http://www.akgenseeds.com/api/v4/" . $subname . "/detail", $_POST);
    $result = $response->body;

    return $this->render(["text" => $result], ["content_type" => "application/json"]);
  }

  public function all_news() {
    $datas = [];
    foreach (self::SERVICES as $id => $service) {

      $subname = $service["subname"];

      $http = new ApplicationHttp();
      $response = $http->post("http://www.akgenseeds.com/api/v4/" . $subname . "/news", $_POST);
      $result = $response->body;
      $datas[$subname] = json_decode($result);
    }

    $json = self::_query_json_template(200, "Tüm En Yeniler", $datas);
    return $this->render(["text" => $json], ["content_type" => "application/json"]);
  }

  public function all_tops() {
    $datas = [];
    foreach (self::SERVICES as $id => $service) {

      $subname = $service["subname"];

      $http = new ApplicationHttp();
      $response = $http->post("http://www.akgenseeds.com/api/v4/" . $subname . "/tops", $_POST);
      $result = $response->body;
      $datas[$subname] = json_decode($result);
    }

    $json = self::_query_json_template(200, "Tüm En Gözdeler", $datas);
    return $this->render(["text" => $json], ["content_type" => "application/json"]);
  }

  public function all_search() {
    $datas = [];
    foreach (self::SERVICES as $id => $service) {

      $subname = $service["subname"];
      $id = $service["id"];
      $name = $service["name"];
      $image = $service["image"];

      $http = new ApplicationHttp();
      $response = $http->post("http://www.akgenseeds.com/api/v4/" . $subname . "/search", $_POST);
      $result = $response->body;

      $datas[] = [
        "id" => $id,
        "name" => $name,
        "image" => $image,
        "result" => json_decode($result)
      ];
    }


    $json = self::_query_json_template(200, "Tüm Aramalar", $barcodes);
    return $this->render(["text" => $json], ["content_type" => "application/json"]);
  }

}
?>
