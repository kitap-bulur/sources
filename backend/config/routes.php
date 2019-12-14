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
      post("app/detail", "app#detail");
      /* --- */
      post("app/all_news", "app#all_news");
      post("app/all_tops", "app#all_tops");
      post("app/all_search", "app#all_search");
      /* --- */
      /* --- */

      post("amazon/news", "amazon#news");
      post("amazon/tops", "amazon#tops");
      post("amazon/search", "amazon#search");
      post("amazon/detail", "amazon#detail");

      post("bkmkitap/news", "bkmkitap#news");
      post("bkmkitap/tops", "bkmkitap#tops");
      post("bkmkitap/search", "bkmkitap#search");
      post("bkmkitap/detail", "bkmkitap#detail");

      post("dr/news", "dr#news");
      post("dr/tops", "dr#tops");
      post("dr/search", "dr#search");
      post("dr/detail", "dr#detail");

      post("hepsiburada/news", "hepsiburada#news");
      post("hepsiburada/tops", "hepsiburada#tops");
      post("hepsiburada/search", "hepsiburada#search");
      post("hepsiburada/detail", "hepsiburada#detail");

      post("idefix/news", "idefix#news");
      post("idefix/tops", "idefix#tops");
      post("idefix/search", "idefix#search");
      post("idefix/detail", "idefix#detail");

      post("kidega/news", "kidega#news");
      post("kidega/tops", "kidega#tops");
      post("kidega/search", "kidega#search");
      post("kidega/detail", "kidega#detail");

      post("kitabevimiz/news", "kitabevimiz#news");
      post("kitabevimiz/tops", "kitabevimiz#tops");
      post("kitabevimiz/search", "kitabevimiz#search");
      post("kitabevimiz/detail", "kitabevimiz#detail");

      post("kitapkoala/news", "kitapkoala#news");
      post("kitapkoala/tops", "kitapkoala#tops");
      post("kitapkoala/search", "kitapkoala#search");
      post("kitapkoala/detail", "kitapkoala#detail");

      post("kitapsec/news", "kitapsec#news");
      post("kitapsec/tops", "kitapsec#tops");
      post("kitapsec/search", "kitapsec#search");
      post("kitapsec/detail", "kitapsec#detail");

      post("kitapsihirbazi/news", "kitapsihirbazi#news");
      post("kitapsihirbazi/tops", "kitapsihirbazi#tops");
      post("kitapsihirbazi/search", "kitapsihirbazi#search");
      post("kitapsihirbazi/detail", "kitapsihirbazi#detail");

      post("nobelkitap/news", "nobelkitap#news");
      post("nobelkitap/tops", "nobelkitap#tops");
      post("nobelkitap/search", "nobelkitap#search");
      post("nobelkitap/detail", "nobelkitap#detail");

      post("pandora/news", "pandora#news");
      post("pandora/tops", "pandora#tops");
      post("pandora/search", "pandora#search");
      post("pandora/detail", "pandora#detail");

      post("pelikankitabevi/news", "pelikankitabevi#news");
      post("pelikankitabevi/tops", "pelikankitabevi#tops");
      post("pelikankitabevi/search", "pelikankitabevi#search");
      post("pelikankitabevi/detail", "pelikankitabevi#detail");

      post("ucuzkitapal/news", "ucuzkitapal#news");
      post("ucuzkitapal/tops", "ucuzkitapal#tops");
      post("ucuzkitapal/search", "ucuzkitapal#search");
      post("ucuzkitapal/detail", "ucuzkitapal#detail");

    });
});
?>
