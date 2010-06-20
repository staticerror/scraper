<?php

include_once('simple_html_dom.php');



class Google extends Scraper {

  function getSearchLinks($url) { // Gets all the links from a google search page -- useful for many sites
    
    $searchLinks = array();

      $htmlContent = $this->getHtml($url);
      $html = str_get_html($htmlContent);

      $h2elements = $html->find('h2[class=r]');
      foreach( $h2elements as $element ) {
	foreach( $element->find('a') as $link ) { 
	  array_push($searchLinks, $link->href);
	}
      }

      return $searchLinks;
  }


}


class SiteScraper extends Scraper {


  function makeSearchLink($url) {
    $n = new Google();
    $links = $n->getSearchLinks($url);
    return $links[array_rand($links)];

  }

  function makeArticle($searchUrl, $bodyAttribute) {

    $articleUrl = $this->makeSearchLink($searchUrl);
    $htmlPage = $this->getHtml($articleUrl);
    $title = $this->getTitle($htmlPage);
    $body = $this->parseHtml($bodyAttribute, $htmlPage);

    return array($title, $body, $articleUrl);
    
    
      }

}





// Base class -- contains many useful methods and stuff //
class Scraper {
  
  public $url;

  function getHtml($url) {
    
    $this->url = $url;
    $html = curl_init($this->url);
    curl_setopt($html, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($html, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($html, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($html, CURLOPT_USERAGENT,"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");
    curl_setopt($html, CURLOPT_VERBOSE, TRUE);

    $htmlContent = curl_exec($html);
    curl_close($html);
    return $htmlContent;
  }

  function getAllLinks($htmlContents) {
    $allLinks = array();
    $html = str_get_html($htmlContents);

    foreach($html->find('a') as $link) {
      array_push($allLinks, $link->href);
    }
    return $allLinks;
  }

  function getTitle($htmlContents) { 
    $html = str_get_html($htmlContents);
    $title = $html->find('title', 0)->plaintext;
    return $title;
  }

  function parseHtml($attribute, $text) {
    $result = array();
    $html = str_get_html($text);

    foreach($html->find($attribute) as $element) {
      array_push($result, $element);
    }
    $result = implode("\n", $result);
    return $result;
  }

  function startsWith($pattern, $target) {
    
    preg_match_all("/^$pattern/", $target, $matches);
    return $matches;
  }

  function endsWithHtml($target) {
    
    return preg_match("/.html$/", $target);
  }

     
  function stripJS($text) {

    return preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $text);    
  }

  function isUrl($link) {

    return preg_match('%https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?%', $link);

  }

}





?>
