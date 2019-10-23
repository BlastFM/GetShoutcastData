<?php
//  Domain name or IP address of the stream
    $server = '45.33.5.23';
//  Port number of the stream
    $port = '8000';
//  Although our streams are secure, we will attempt to get the data using a non SSL connection
    $streamUrl = "http://".$server.":".$port."/stats?sid=1";
//  The regular expression that splits the song info into Artist/Title. Usually escaped space hyphon space.
    $splitSongRegex = "/\ \-\ /";
//  Attempt to get the stream data using a non SSL connection
    $streamData = @file_get_contents($streamUrl);
//  Exit if no data returned
if ($streamData === FALSE) {
    echo "Unable to read stream data from ".$streamUrl;
    exit();
}
//  Convert stream XML data to lowercase Json array
    $xml = simplexml_load_string(strtolower($streamData), "SimpleXMLElement", LIBXML_NOCDATA);
    $json = json_encode($xml);
    $streamDataArray = json_decode($json, TRUE);
//  Get song
    $song = ucwords($streamDataArray['songtitle']);
    $songArray = preg_split($splitSongRegex, $song, -1, PREG_SPLIT_DELIM_CAPTURE);
    $artist = $songArray[0];
    $track = $songArray[1];
    $rawArtist = decode($artist);
    $rawTrack = decode($track);
    $combined = decode($artist." - ".$track);
//  Get stream title
    $title  = ucwords($streamDataArray['servertitle']);
//  Get genre
    $genre  = ucwords($streamDataArray['servergenre']);
//  Get bitrate
    $bitrate = $streamDataArray['bitrate'];
//  Get samplerate
    $samplerate = $streamDataArray['samplerate'];
//  Get current listeners
    $listeners  = number_format($streamDataArray['currentlisteners']);
//  Get peak listeners
    $peakListeners = number_format($streamDataArray['peaklisteners']);
//  Get max listeners
    $maxListeners = number_format($streamDataArray['maxlisteners']);
//  Get unique listeners
    $uniqueListeners = $streamDataArray['uniquelisteners'];
//  Get average time
    $averageTime = $streamDataArray['averagetime'];
//  Get server url
    $serverUrl = $streamDataArray['serverurl'];
//  Get stream hits
    $streamHits = number_format($streamDataArray['streamhits']);
//  Get stream status
    $streamStatus = $streamDataArray['streamstatus'];
//  Get backup status
    $backupStatus = $streamDataArray['backupstatus'];
//  Get stream listed status (directory listing status)
    $streamListed = $streamDataArray['streamlisted'];
//  Get stream path
    $streamPath = $streamDataArray['streampath'];
//  Get stream uptime
    $streamUpTime = number_format($streamDataArray['streamuptime']);
//  All data can now be accessed using variables, let's show what's currently playing for example
    echo $combined;
//  FUNCTIONS
 function decode($str) {
    $find = array('&apos;', '&amp;apos;', '&quot;', ' &amp;amp; ', ' &amp; ');
    $replace = array('\'', '\'', '"', ' & ', ' & ');
    $str = str_replace($find, $replace, $str);
    unset($find, $replace);
    return $str;
    exit();
}
?>
