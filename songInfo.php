<?php
//	Shoutcast2
	$server = '45.33.5.23';
	$port = '8000';
	$streamUrl = "http://{$server}:{$port}/currentsong?sid=1";
	$streamData = @file_get_contents($streamUrl);
if ($streamData === FALSE) {
	echo "Unable to read stream data from ".$streamUrl;
	exit();
}
//	The regular expression that splits the song info into Artist/Title. Usually escaped space hyphon space.
	$splitSongRegex = "/\ \-\ /";
	$songArray = preg_split($splitSongRegex, $streamData, -1, PREG_SPLIT_DELIM_CAPTURE);
	$artist = trim($songArray[0]);
	$track = trim($songArray[1]);
?>
