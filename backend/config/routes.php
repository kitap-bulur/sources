<?php

ApplicationRoutes::draw(function() {

  scope("api", function() {
    scope("v2", function() {
      post("dr/pages", "dr#pages");
      post("dr/top_news", "dr#top_news");
      post("dr/top_books", "dr#top_books");
      post("dr/search_text", "dr#search_text");
    });
    scope("v4", function() {
      post("app/pages", "app#pages");
      post("app/services", "app#services");
      post("app/news", "app#news");
      post("app/tops", "app#tops");
      post("app/search", "app#search");
      /* --- */
      post("isbn/search", "isbn#search");
      post("app/all_news", "app#all_news");
      post("app/all_tops", "app#all_tops");
      post("app/all_search", "app#all_search");
      /* --- */
      /* --- */
      post("dr/news", "dr#news");
      post("dr/tops", "dr#tops");
      post("dr/search", "dr#search");

      post("idefix/news", "idefix#news");
      post("idefix/tops", "idefix#tops");
      post("idefix/search", "idefix#search");

      post("hb/news", "hb#news");
      post("hb/tops", "hb#tops");
      post("hb/search", "hb#search");

      post("pandora/news", "pandora#news");
      post("pandora/tops", "pandora#tops");
      post("pandora/search", "pandora#search");

      post("kidega/news", "kidega#news");
      post("kidega/tops", "kidega#tops");
      post("kidega/search", "kidega#search");

      post("bkm/news", "bkm#news");
      post("bkm/tops", "bkm#tops");
      post("bkm/search", "bkm#search");

      post("kitapsec/news", "kitapsec#news");
      post("kitapsec/tops", "kitapsec#tops");
      post("kitapsec/search", "kitapsec#search");

      post("uka/news", "uka#news");
      post("uka/tops", "uka#tops");
      post("uka/search", "uka#search");

      post("amazon/news", "amazon#news");
      post("amazon/tops", "amazon#tops");
      post("amazon/search", "amazon#search");

      post("koala/news", "koala#news");
      post("koala/tops", "koala#tops");
      post("koala/search", "koala#search");

      post("nobelkitap/news", "nobelkitap#news");
      post("nobelkitap/tops", "nobelkitap#tops");
      post("nobelkitap/search", "nobelkitap#search");

      post("babil/news", "babil#news");
      post("babil/tops", "babil#tops");
      post("babil/search", "babil#search");

      post("kitapsihirbazi/news", "kitapsihirbazi#news");
      post("kitapsihirbazi/tops", "kitapsihirbazi#tops");
      post("kitapsihirbazi/search", "kitapsihirbazi#search");

      post("pelikankitabevi/news", "pelikankitabevi#news");
      post("pelikankitabevi/tops", "pelikankitabevi#tops");
      post("pelikankitabevi/search", "pelikankitabevi#search");
    });
  });

});
?>
