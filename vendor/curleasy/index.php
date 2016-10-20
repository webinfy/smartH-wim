<?php

include __DIR__ . '/vendor/autoload.php';

function asynCurl($url) {
// We will download info about YouTube video: http://youtu.be/_PsdGQ96ah4
    $request = new \cURL\Request($url);
    $request->getOptions()
            ->set(CURLOPT_TIMEOUT, 5)
            ->set(CURLOPT_RETURNTRANSFER, true);
    
//    $request->addListener('complete', function (\cURL\Event $event) {
//        $response = $event->response;
//        $feed = json_decode($response->getContent(), true);
//        echo $feed['entry']['title']['$t'];
//    });


    while ($request->socketPerform()) {
        // do anything else when the requests are processed
        $request->socketSelect();
        // line below pauses execution until there's new data on socket
    }
}
