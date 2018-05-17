<?php

namespace App\JoindIn;

use App\Entity\Talk;
use Psr\SimpleCache\CacheInterface;

class MockClient
{
    const CACHE_KEY = 'talks';

    /**
     * @var string
     */
    private $talksUrl;

    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * @param int $talksUrl
     * @param CacheInterface $cache
     */
    public function __construct(string $talksUrl, CacheInterface $cache)
    {
        $this->talksUrl = $talksUrl;
        $this->cache = $cache;
    }


    public function getTalks()
    {
        if (!$this->cache->has(static::CACHE_KEY)) {

            $json = file_get_contents($this->talksUrl);

            $apiData = json_decode($json, true);
            $talks = [];

            foreach ($apiData['talks'] as $talkData) {
                $talks[] = Talk::create(
                    $talkData['talk_title'],
                    $talkData['speakers'][0]['speaker_name']
                );
            }

            $this->cache->set(static::CACHE_KEY, $talks);
        }

        return $this->cache->get(static::CACHE_KEY);
    }
}
