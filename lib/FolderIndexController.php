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
    $folderIndexes = [];

    // Get JSON files
    foreach (new DirectoryIterator('./cases') as $file) {
      if ($file->getType() === "file" && $file->getExtension() === "json") {
        $caseName = $file->getBasename('.json');
        $case = json_decode(file_get_contents($file->getPathname()));
        $case->documents = [];

        // Loop over all folders
        foreach ($case->folders as $folderName) {
          // Loop over all files
          foreach($this->feed->getFolder($folderName) as $file) {
            $processedFile = (object)[];
            // echo '<pre>';var_dump($file);echo '</pre>';
            $processedFile->thumbnail = $file->thumbnailLink;
            $processedFile->link = $file->webViewLink;
            $case->documents[] = $processedFile;
          }
        }

        // Add case to index
        $folderIndexes[$caseName] = $case;
      }
    }

    // Create final dataset
    $data = json_encode($folderIndexes, JSON_UNESCAPED_SLASHES);

    // Save to file
    file_put_contents('folderindex.json', $data);

    // Return data as response
    $response->getBody()->write($data);
    return $response;
  }

  /*
   * Return earlier scraped JSON file
   */
  public function returnJSON($request, $response, $args) {
    $response->getBody()->write(file_get_contents('folderindex.json'));
    return $response;
  }
}
