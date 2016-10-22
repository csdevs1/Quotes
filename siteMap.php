<?php
require_once 'AppClasses/AppController.php';
$obj = new AppController();
$quotes = $obj->all('quotes_en');
$authors = $obj->all('authors');
$topics = $obj->all('topics_en');

echo htmlspecialchars('<?xml version="1.0" encoding="UTF-8"?>');
echo '<br>';
echo htmlspecialchars('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
  xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">');
echo '<br>';
echo htmlspecialchars('<url>');
echo '<br>';
//AUTHORS
foreach($authors as $key=>$val){
    if(isset($authors[$key]['authorName']) && !empty($authors[$key]['authorName'])){
        $split=explode(" ",strtolower($authors[$key]['authorName']));
        $seoURL = join("-",$split);
        echo htmlspecialchars('<loc>https://portalquote.com/author/quotes/'.$seoURL.'/1</loc>');
        echo '<br>';
    }
}
//TOPICS
foreach($topics as $key=>$val){
    if(isset($topics[$key]['topicName']) && !empty($topics[$key]['topicName'])){
        echo htmlspecialchars('<loc>https://portalquote.com/topic/quotes/'.$topics[$key]['seo_url'].'/1</loc>');
        echo '<br>';
    }
}
//QUOTES
foreach($quotes as $key=>$val){
    echo htmlspecialchars('<loc>https://portalquote.com/quotes/quotes/'.$quotes[$key]['quoteID'].'</loc>');
    echo '<br>';
    if(isset($quotes[$key]['quoteImage']) && !empty($quotes[$key]['quoteImage'])){
        echo htmlspecialchars('<image:image>');
        echo '<br>';
        echo htmlspecialchars('<image:loc>https://portalquote.com/images/quotes/'.$quotes[$key]['quoteImage'].'</image:loc>');
        echo '<br>';
        echo htmlspecialchars('<image:caption>'.$quotes[$key]['quote'].' - '.$quotes[$key]['author'].'</image:caption>');
        echo '<br>';
        echo htmlspecialchars('</image:image>');
        echo '<br>';
    }
}
echo htmlspecialchars('</url>');
echo '<br>';
echo htmlspecialchars('</urlset>');
echo '<br>';
?>