<?php

use Illuminate\Support\Facades\Route;
use App\Observers\ArticleRepositoryObserver;
use Spatie\Crawler\Crawler;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    $observer = new ArticleRepositoryObserver();
    $observer->setLimit(3);
    
    $agent = request()->header('User-Agent');

    Crawler::create()
        ->setCrawlObserver($observer)
        ->setUserAgent($agent)
        ->startCrawling('https://journal.uny.ac.id/index.php/cp/oai?verb=ListRecords&metadataPrefix=oai_dc&set=driver');

    $xml = $observer->results;

    $json = json_encode($xml[1], JSON_PRETTY_PRINT);

    return response($json);
});
