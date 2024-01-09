<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/DBApi.php';

$gridFSBucket = DBApi::getGridFS();

$fileId = $_GET['id'] ?? null;

if ($fileId) {
    $file = $gridFSBucket->findOne(['_id' => new MongoDB\BSON\ObjectID($fileId)]);
    if ($file) {
        // Set caching headers
        $lastModified = new DateTime("@{$file->uploadDate->toDateTime()->getTimestamp()}");
        $etag = md5($file->md5);

        header('Last-Modified: ' . $lastModified->format('D, d M Y H:i:s T'));
        header('Etag: "' . $etag . '"');

        // Check if the client has the same resource cached
        if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) &&
            strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $lastModified->getTimestamp()) {
            header('HTTP/1.1 304 Not Modified');
            exit;
        }

        if (isset($_SERVER['HTTP_IF_NONE_MATCH']) &&
            trim($_SERVER['HTTP_IF_NONE_MATCH'], '"') === $etag) {
            header('HTTP/1.1 304 Not Modified');
            exit;
        }

        header('Content-Type: ' . $file['metadata']->contentType);
        $fileId = new MongoDB\BSON\ObjectID($fileId);
        $stream = $gridFSBucket->openDownloadStream($fileId);

        if ($stream) {
            fpassthru($stream);
            fclose($stream);
            exit;
        } else {
            echo 'Error: Unable to open file stream.';
        }
    } else {
        echo 'Error: File not found.';
    }
} else {
    echo 'Error: Invalid file ID';
}
?>
