<?php

class FolderIndexController {
  protected $container;
  protected $feed;

  public function __construct($container) {
     $this->container = $container;
     $this->feed = new GoogleFeed();
  }

  public function updateIndex($request, $response, $args) {
    // Set up JSON object
    $folderIndexes = (object)[];

    // Get JSON files
    foreach (new DirectoryIterator('./cases') as $file) {
      if ($file->getType() === "file" && $file->getExtension() === "json") {
        $caseName = $file->getBasename('.json');
        $case = json_decode(file_get_contents($file->getPathname()));

        if (count($case->folders) > 0) {
          foreach ($case->folders as $folder) {
            var_dump($this->feed->getFolder($folder));
          }
        }
      }
    }

    $response
      ->getBody()
      ->write(
        json_encode($folderIndexes)
      );

    return $response;
  }
}
