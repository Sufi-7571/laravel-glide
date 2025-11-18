<?php

namespace App\Http\Glide;

use League\Glide\Responses\ResponseFactoryInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaravelResponseFactory implements ResponseFactoryInterface
{
    /**
     * Create the response.
     *
     * @param mixed $cache The cache filesystem.
     * @param string $path The cached file path.
     * @return StreamedResponse The response.
     */
    public function create($cache, $path)
    {
        $stream = $cache->readStream($path);

        $response = new StreamedResponse(function () use ($stream) {
            if (is_resource($stream)) {
                fpassthru($stream);
                fclose($stream);
            }
        });

        $response->headers->set('Content-Type', $cache->mimeType($path));
        $response->headers->set('Content-Length', $cache->fileSize($path));
        $response->headers->set('Cache-Control', 'max-age=31536000, public');
        $response->headers->set('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 31536000));

        return $response;
    }
}