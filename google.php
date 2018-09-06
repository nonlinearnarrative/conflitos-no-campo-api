<?php
require 'key.php';

define('GOOGLE_SCOPES',
	implode(' ',
		array(
			\Google_Service_Sheets::SPREADSHEETS_READONLY,
			\Google_Service_Drive::DRIVE,
			\Google_Service_Drive::DRIVE_FILE,
			\Google_Service_Drive::DRIVE_READONLY,
		)
	)
);

class GoogleFeed {

	public function getClient() {
		$client = new \Google_Client();
		$client->setDeveloperKey(API_KEY);
		$client->setScopes(GOOGLE_SCOPES);
		$client->setAccessType('offline');
		return $client;
	}

	public function getFolder($folderId){
		$client = $this->getClient();
		$service = new \Google_Service_Drive($client);

		$results = $service->files->listFiles([
			'pageSize' => 10,
			'fields' => "nextPageToken, files(contentHints/thumbnail,fileExtension,iconLink,id,name,size,thumbnailLink,webContentLink,webViewLink,mimeType,parents)",
			'q' => "'".$folderId."' in parents"
		]);

		return $results->files;
	}

	public function getDocument($documentId) {
		$client = $this->getClient();
		$service = new \Google_Service_Drive($client);
		$response = $service->files->get($documentId, [ 'alt' => 'media']);
		$content = $response->getBody()->getContents();

		$doc = new DOMDocument();
		$doc->loadHTML($content);
		$xpath = new \DOMXpath($doc);

		$properties = ['style', 'class', 'id'];
		foreach($properties as $prop) {
			$items = $xpath->query("//*[@" . $prop . "]");
			foreach($items as $item) {
				$item->removeAttribute("" . $prop . "");
			}
		}

		$html = '';
		foreach($doc->getElementsByTagName('body')->item(0)->childNodes as $node) {
			$html .= $node->ownerDocument->saveHTML($node);
		}

		return $html;
	}
}
