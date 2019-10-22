<?php
//	Domain name or IP address of the stream
	$server = '45.33.5.23';
//	Port number of the stream
	$port = '8000';
//	The regular expression that splits the song info into Artist/Title. Usually escaped space hyphon space.
	$splitSongRegex = "/\ \-\ /";
//	Attempt to get stream data using a non SSL connection
    $streamUrl = "http://".$server.":".$port."/stats?sid=1";
    $streamData = @file_get_contents($streamUrl);
//	Exit if no data returned
if ($streamData === FALSE) {
    echo "<p>Unable to read stream data</p>";
    exit();
}
//	Get song
    $songTitleTag = strpos($streamData, "<SONGTITLE>") + 11;
    $songTitleCloseTag = strpos($streamData, "</SONGTITLE>");
    $songTitleLength = $songTitleCloseTag - $songTitleTag;
    $song = substr($streamData, $songTitleTag, $songTitleLength);
    $songArray = preg_split($splitSongRegex, $song, -1, PREG_SPLIT_DELIM_CAPTURE);
    $artist = $songArray[0];
    $track = $songArray[1];
    $rawArtist = decode($artist);
    $rawTrack = decode($track);
    $combined = decode($artist." - ".$track);
//	Get stream title
    $titleTag = strpos($streamData, "<SERVERTITLE>") + 13;
    $titleCloseTag = strpos($streamData, "</SERVERTITLE>");
    $titleLength = $titleCloseTag - $titleTag;
    $title = substr($streamData, $titleTag, $titleLength);
//	Get genre
    $genreTag = strpos($streamData, "<SERVERGENRE>") + 13;
    $genreCloseTag = strpos($streamData, "</SERVERGENRE>");
    $genreLength = $genreCloseTag - $genreTag;
    $genre = substr($streamData, $genreTag, $genreLength);
//	Get bitrate
    $bitrateTag = strpos($streamData, "<BITRATE>") + 9;
    $bitrateCloseTag = strpos($streamData, "</BITRATE>");
    $bitrateLength = $bitrateCloseTag - $bitrateTag;
    $bitrate = substr($streamData, $bitrateTag, $bitrateLength);
//	Get samplerate
    $samplerateTag = strpos($streamData, "<SAMPLERATE>") + 12;
    $samplerateCloseTag = strpos($streamData, "</SAMPLERATE>");
    $samplerateLength = $samplerateCloseTag - $samplerateTag;
    $samplerate = substr($streamData, $samplerateTag, $samplerateLength);
//	Get listeners
    $listenersTag = strpos($streamData, "<CURRENTLISTENERS>") + 18;
    $listenersCloseTag = strpos($streamData, "</CURRENTLISTENERS>");
    $listenersLength = $listenersCloseTag - $listenersTag;
    $listeners = substr($streamData, $listenersTag, $listenersLength);
//	Get peak listeners
    $peakListenersTag = strpos($streamData, "<PEAKLISTENERS>") + 15;
    $peakListenersCloseTag = strpos($streamData, "</PEAKLISTENERS>");
    $peakListenersLength = $peakListenersCloseTag  - $peakListenersTag;
    $peakListeners = substr($streamData, $peakListenersTag, $peakListenersLength);
//	All data can now be accessed using variables, let's show what's currently playing for example
    echo $combined;
//	FUNCTIONS
 function decode($str) {
 	$find = array('&apos;', '&amp;apos;', '&quot;', ' &amp;amp; ', ' &amp; ');
 	$replace = array('\'', '\'', '"', ' & ', ' & ');
	$str = str_replace($find, $replace, $str);
 	unset($find, $replace);
 	return $str;
 	exit();
}
?>
