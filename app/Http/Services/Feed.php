<?php

namespace App\Http\Services;

use Goutte\Client;

class Feed
{
    protected $stopwords = array();

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Normalize string.
     *
     * @param  string $string
     * @return string
     */
    public function normalizeString($string)
    {
        $normalized = preg_replace('/[\pP]/u', '', trim(preg_replace('/\s\s+/iu', '', mb_strtolower($string))));

        return $normalized;
    }

    /**
     * Convert array to string.
     *
     * @param  array $array
     * @return string
     */
    public function convertMultiArray($array)
    {
        $out = '';
        foreach ($array as $key => $value) {
            $out .= strip_tags(strtolower($value->get_title() . ' ' . $value->get_description()));
        }

        return $this->normalizeString($out);
    }

    /**
     * Filter array items.
     *
     * @param  string $item
     * @return bool
     */
    public function filterWords($word)
    {
        $matches = ($word == '' || in_array($word, $this->stopwords) || mb_strlen($word) <= 2 || is_numeric($word)) ? false : true;

        return $matches;
    }

    /**
     * Match array words.
     *
     * @param  string $string
     * @param  array  $stopwords
     * @return array
     */
    public function matchWords($string, $stopwords)
    {
        $matchwords = array_filter(
            explode(' ', $string),
            array($this, 'filterWords')
        );

        return $matchwords;
    }

    /**
     * Count duplicate words and limit to top 10
     *
     * @param  array $items
     * @return array
     */
    public function countWords($items, $limit = 10)
    {
        $string = $this->convertMultiArray($items);
        $normalized = $this->normalizeString($string);
        $stopwords = $this->fetchStopWords(config('feeds.stopwords'), 50);
        $matchwords = $this->matchWords($string, $stopwords);
        $count = array_count_values($matchwords);
        arsort($count);

        return array_slice($count, 0, $limit);
    }

    /**
     * Fetch stop words from wiki table
     *
     * @param  string $url
     * @param  int    $limit
     * @return array
     */
    public function fetchStopWords($url, $limit = 50)
    {
        $crawler = $this->client->request('GET', $url);
        $crawler = $crawler->filter('table tbody tr td')->reduce(function ($node, $i) {
            return ($i % 6) == 0;
        });
        $crawler = $crawler->each(function ($node) {
            $this->stopwords[] = $node->text();
        });

        return array_slice($this->stopwords, 0, $limit, true);
    }

    /**
     * Parse feed.
     *
     * @param  string $url
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function parse($url)
    {
        $feed = \Feeds::make($url, true);
        $data = array(
            'title'     => $feed->get_title(),
            'permalink' => $feed->get_permalink(),
            'items'     => $feed->get_items(),
            'top'       => $this->countWords($feed->get_items(), 10),
        );

        return $data;
    }
}
