<?php

namespace App\Service;

use TheCodingMachine\Gotenberg\Client;
use TheCodingMachine\Gotenberg\ClientException;
use TheCodingMachine\Gotenberg\DocumentFactory;
use TheCodingMachine\Gotenberg\HTMLRequest;
use TheCodingMachine\Gotenberg\Request;
use TheCodingMachine\Gotenberg\RequestException;

class PdfGeneratorService
{
    private readonly Client $client;
    private array $manifest = [];

    public function __construct(string $endpoint, private readonly string $projectDir)
    {
        $this->client = new Client($endpoint);
        $this->manifest = json_decode(file_get_contents($this->projectDir.'/public/build/manifest.json'), true);
    }

    public function generate(string $html, string $filePath, array $options = []): void
    {
        $index = DocumentFactory::makeFromString('index.html', $html);

        $request = new HTMLRequest($index);
        $assets = [];

        if (isset($this->manifest['build/app.css'])) {
            $assets[] = DocumentFactory::makeFromPath('style.css', $this->projectDir.'/public/'.$this->manifest['build/app.css']);
        }

        if (isset($options['assets'])) {
            foreach ($options['assets'] as $asset => $assetPath) {
                $assets[] = DocumentFactory::makeFromPath($asset, $assetPath);
            }
        }

        $request->setAssets($assets);
        $request->setPaperSize($options['document_size'] ?? Request::A4);
        $request->setMargins($options['documents_margins'] ?? Request::NO_MARGINS);
        $request->setScale($options['documents_scale'] ?? 0.75);
        $request->setLandscape($options['landscape'] ?? false);

        $filePath = $this->projectDir.'/'.$filePath;
        $explodedFilePath = explode('/', $filePath);
        array_pop($explodedFilePath);

        $dirPath = implode('/', $explodedFilePath);
        if (!file_exists($dirPath)) {
            mkdir($dirPath, 0777, true);
        }
        $this->client->store($request, $filePath);
        // try {
        //     $this->client->store($request, $filePath);
        // } catch (RequestException $e) {
        //     dd($e);
        //     // this exception is thrown if given paper size or margins are not correct.
        // } catch (ClientException $e) {
        //     dd($e);
        //     // this exception is thrown by the client if the API has returned a code != 200.
        // }
    }
}
