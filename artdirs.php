<?php

include_once('scraper.php');


class Ezine extends SiteScraper {

  function getArticle($keyword) {

    $keyword = str_replace(" ", "+", $keyword);

    $article = $this->makeArticle("http://www.google.com/custom?domains=EzineArticles.com&q=$keyword&sa=Google+Search&sitesearch=EzineArticles.com&client=pub-3754405753000444&forid=1&channel=4551525989&ie=ISO-8859-1&oe=ISO-8859-1&flav=0000&sig=pyZc_H88ghdJkBJ7&cof=GALT%3A%23008000%3BGL%3A1%3BDIV%3A%23FFFFF4%3BVLC%3A663399%3BAH%3Acenter%3BBGC%3AFFFFFF%3BLBGC%3AFFFFFF%3BALC%3A0000FF%3BLC%3A0000FF%3BT%3A000000%3BGFNT%3A0000FF%3BGIMP%3A0000FF%3BLH%3A50%3BLW%3A102%3BL%3Ahttp%3A%2F%2Fezinearticles.com%2Fimages%2Fea_logo_google.jpg%3BS%3Ahttp%3A%2F%2Fezinearticles.com%2F%3BFORID%3A10%3B&hl=en&ad=w9&num=10", 'div[id=body]');

    return $article;

  }
}


class Buzzle extends SiteScraper {

  function getArticle($keyword) {

    $keyword = str_replace(" ", "+", $keyword);

    $article = $this->makeArticle("http://www.google.com/cse?cx=partner-pub-9037304895410090%3Ag3smgk-qsxm&cof=FORID%3A10&ie=ISO-8859-1&q=$keyword&sa=Search&siteurl=www.buzzle.com%2Fauthors.asp%3Fauthor%3D22402&ad=w9&num=10&rurl=http%3A%2F%2Fwww.buzzle.com%2Fsearch%2Fgsearchengine.asp%3Fcx%3Dpartner-pub-9037304895410090%253Ag3smgk-qsxm%26cof%3DFORID%253A10%26ie%3DISO-8859-1%26q%3Dcat%26sa%3DSearch%26siteurl%3Dwww.buzzle.com%252Fauthors.asp%253Fauthor%253D22402", 'div[class=article]');

    return $article;

  }
}



class Dashboard extends SiteScraper {

  function getArticle($keyword) {

    $keyword = str_replace(" ", "+", $keyword);

    $article = $this->makeArticle("http://www.google.com/custom?domains=www.articledashboard.com&q=$keyword&sa=Google+Search&sitesearch=www.articledashboard.com&client=pub-8642343895325952&forid=1&channel=7388531767&ie=ISO-8859-1&oe=ISO-8859-1&safe=active&cof=GALT%3A%23008000%3BGL%3A1%3BDIV%3A%23ffffff%3BVLC%3A000080%3BAH%3Acenter%3BBGC%3AFFFFFF%3BLBGC%3Affffff%3BALC%3A000080%3BLC%3A000080%3BT%3A000000%3BGFNT%3A000080%3BGIMP%3A000080%3BLH%3A50%3BLW%3A365%3BL%3Ahttp%3A%2F%2Fwww.articledashboard.com%2Fimages%2Fadlogo2.gif%3BS%3Ahttp%3A%2F%2Fwww.articledashboard.com%3BFORID%3A11&hl=en&ad=w9&num=10", 'p[class=articletext]');

    $article = $this->stripJS($article);
    return $article;

  }
}


class Snatch extends SiteScraper {

  function getArticle($keyword) {

    $keyword = str_replace(" ", "+", $keyword);

    $article = $this->makeArticle("http://www.google.com/cse?cx=partner-pub-2050911826501646%3A1m6ue6-c897&cof=FORID%3A10&ie=ISO-8859-1&q=$keyword&sa=Search&siteurl=www.articlesnatch.com%2F&ad=w9&num=10&rurl=http%3A%2F%2Fwww.articlesnatch.com%2Fcse.php%3Fcx%3Dpartner-pub-2050911826501646%253A1m6ue6-c897%26cof%3DFORID%253A10%26ie%3DISO-8859-1%26q%3Dcats%26sa%3DSearch%26siteurl%3Dwww.articlesnatch.com%252F%26siteurl%3Dwww.articlesnatch.com%252F", 'div[class=articletext]');

    $article = $this->stripJS($article);
    return $article;

  }
}



class ABase extends SiteScraper {

  function makeSearchLink($articleUrl) {

    $htmlContents = $this->getHtml($articleUrl);
    $links = $this->getAllLinks($htmlContents);

    $links = array_filter($links, array($this, 'endsWithHtml'))  ; 
    return $links[array_rand($links)];

  }

  function getArticle($keyword) {

    $keyword = str_replace(" ", "+", $keyword);
    $article = $this->makeArticle("http://www.articlesbase.com/find-articles.php?q=$keyword", 'div[class=article_cnt KonaBody]');
    return $article;

  }
  
}


$n = new ABase();

print_r( $n->getArticle("pink floyd"));


?>