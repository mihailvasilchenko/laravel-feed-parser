<?php

namespace App\Http\Services;

class Feed
{

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
            'top'       => $this->countWords($feed->get_items()),
        );

        return $data;
    }

    /**
     * Convert array to string.
     *
     * @param  array $array
     * @return string
     */
    public function convert_multi_array($array)
    {
        $out = '';
        foreach ($array as $key => $value) {
            $out .= strip_tags(strtolower($value->get_title() . ' ' . $value->get_description()));
        }

        return $out;
    }

    /**
     * Count duplicate words and limit to top 10
     *
     * @param  array $items
     * @return array
     */
    public function countWords($items)
    {
        $string = $this->convert_multi_array($items);
        mb_internal_encoding('UTF-8');
        $stopwords = array('the', 'be', 'to', 'of', 'and', 'a', 'in', 'that', 'have', 'I', 'it', 'for', 'not', 'on', 'with', 'he', 'as', 'you', 'do', 'at', 'this', 'but', 'his', 'by', 'from', 'they', 'we', 'say', 'her', 'she', 'or', 'an', 'will', 'my', 'one', 'all', 'would', 'there', 'their', 'what', 'so', 'up', 'out', 'if', 'about', 'who', 'get', 'which', 'go', 'me', 'when', 'make', 'can', 'like', 'time', 'no', 'just', 'him', 'know', 'take', 'people', 'into', 'year', 'your', 'good', 'some', 'could', 'them', 'see', 'other', 'than', 'then', 'now', 'look', 'only', 'come', 'its', 'over', 'think', 'also', 'back', 'after', 'use', 'two', 'how', 'our', 'work', 'first', 'well', 'way', 'even', 'new', 'want', 'because', 'any', 'these', 'give', 'day', 'most', 'us', 'are', 'has', 'was');
        $string = preg_replace('/[\pP]/u', '', trim(preg_replace('/\s\s+/iu', '', mb_strtolower($string))));
        $matchWords = array_filter(
            explode(' ', $string),
            function ($item) use ($stopwords) {
                return !($item == '' || in_array($item, $stopwords) || mb_strlen($item) <= 2 || is_numeric($item));
            }
        );
        $wordCountArr = array_count_values($matchWords);
        arsort($wordCountArr);

        return array_slice($wordCountArr, 0, 10);
    }
}
