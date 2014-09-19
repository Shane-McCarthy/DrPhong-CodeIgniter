<?php

/**
 * Skeleton Class for Blogs
 */
class cBlog extends cSkeleton implements iSaveable {

    protected static $TABLE_NAME = 'blogs';
    protected static $SERIALIZATION = array(
        'id' => array('Id', 'string'),
        'name' => array('Name', 'string'),
    );
    protected static $OBJECT_NAME = 'Blog';
    public $id = 0;
    public $approved = false;
    public $name = '';
    public $description = '';
    public $url = '';
    public $owner = '';
    public $feed_url = '';
    public $last_crawled = '';
    public $created = '';
    public $modified = '';

    protected static function getTableName() {
        return self::$TABLE_NAME;
    }

    public static function getSerializationAttributes() {
        return self::$SERIALIZATION;
    }

    public static function getObjectName() {
        return self::$OBJECT_NAME;
    }

    /**
     *
     */
    static function getByIdMulti($user_ids, $sort = 'name', $sort_direction = 'ASC') {

        $CI = get_instance();

        $CI->db->select('*');
        $CI->db->from(self::getTableName());
        $CI->db->where_in('id', $user_ids);
        $CI->db->order_by($sort, $sort_direction);
        $result = $CI->db->get();

        return cSkeleton::__applyNew('cBlog', $result->result());
    }

    /**
     * 
     */
    static function getAll() {

        $CI = get_instance();

        $CI->db->select('*');
        $CI->db->from(self::$TABLE_NAME);
        $result = $CI->db->get();

        return cSkeleton::__applyNew('cBlog', $result->result());
    }

    /**
     * 
     */
    static function getAllApproved() {

        $CI = get_instance();

        $CI->db->select('*');
        $CI->db->from(self::$TABLE_NAME);
        $CI->db->where('approved', true);
        $result = $CI->db->get();

        return cSkeleton::__applyNew('cBlog', $result->result());
    }

    /**
     * 
     */
    static function getAllUnapproved() {

        $CI = get_instance();

        $CI->db->select('*');
        $CI->db->from(self::$TABLE_NAME);
        $CI->db->where('approved', false);
        $result = $CI->db->get();

        return cSkeleton::__applyNew('cBlog', $result->result());
    }

    /**
     * 
     */
    static function findAll($offset = 0, $limit = 20) {

        $CI = get_instance();

        $CI->db->select('*');
        $CI->db->from(self::$TABLE_NAME);
        $CI->db->limit($limit, $offset);
        $result = $CI->db->get();

        echo $CI->db->last_query();

        return cSkeleton::__applyNew('cBlog', $result->result());
    }

    /**
     * Initiates the feed scraper
     * Returns nothing.
     * 
     */
    function parseFeed() {

        // Buffer to four hours
        $buffer = time() - 14400;

        // Check this blog has not been crawled within the buffer time
        // else skip it...
        
        if (strtotime($this->last_crawled) < $buffer) {
        //if ($buffer) {

            require_once(APPPATH . '/third_party/getid3/getid3.php');
            //require_once(APPPATH . '/third_party/parallelcurl/parallelcurl.php');
            //require_once(APPPATH . '/third_party/phpQuery/phpQuery.php');
            // Load the XML Feed for the Blog
            echo "<br /><strong>=================== Blog Start ===================</strong><br />";

            echo "<br />=================== Fetching: $this->feed_url ===================<br />";

            flush();

            //$feedUrl = 'http://doctorphong.com/x/rss_tracks.php';
            $feedUrl = $this->feed_url;


            $doc = new DOMDocument();
            // Get the feed xml, we don't want followed redirects in this case
            // as feedburner will give you an HTML page which is rubbish for us
            @$doc->load($feedUrl);
            //$body = $doc->getElementsByTagName('item');
            //print '<pre>' . $this->dom_dump($body) . '</pre>';
            //exit();
            //Get the Items from the feed we havent yet crawled
            $items = array();

            foreach ($doc->getElementsByTagName('item') as $node) {

                echo '<br />=================== RSS Item Start ===================<br />';

                $date = strtotime($this->get_inner_html($node->getElementsByTagName('pubDate')->item(0)));

                // Make sure the current post is newer than blog last crawl time
                if ($date > mysql_to_unix($this->last_crawled)) {
                //if($date){

                    echo "Searching RSS item for link to blog page...<br />";

                    $title = str_replace("'", "", $this->get_inner_html($node->getElementsByTagName('title')->item(0)));

                    // Get the Description can be in one of two places depending on the feed format
                    $desc = $this->get_inner_html($node->getElementsByTagName('summary')->item(0));
                    if (trim($desc) == '') {
                        $desc = $this->get_inner_html($node->getElementsByTagName('description')->item(0));
                    }

                    // Get the Link
                    $link = $this->get_inner_html($node->getElementsByTagName('link')->item(0));

                    $alreadySaved = cBlogPost::getByUrl($link);

                    if (empty($alreadySaved->_collection)) {

                        echo "Found link to blog page: $link<br />";

                        $categories = array();
                        foreach ($node->getElementsByTagName('category') as $category) {
                            $cat = trim(urldecode($this->get_inner_html($category)));
                            $cat = str_replace('<![CDATA[', '', $cat);
                            $cat = str_replace(']]>', '', $cat);
                            if (!empty($cat)) {
                                array_push($categories, strtolower($cat));
                            }
                        }


                        // Get the Page Media

                        echo "<strong>Looking for RSS media enclosure...</strong><br />";

                        $found = false;

                        $mediaTag = $node->getElementsByTagName('enclosure')->item(0);

                        // Check the tag exists
                        if(!empty($mediaTag)){

                            // Get the url attribute
                            $media = $mediaTag->getAttribute('url');

                        }

                        if (empty($media)) {

                            echo "<strong>Looking for mp3 link in RSS description...</strong><br />";

                            $found = $this->saveMp3LinkFromItem($desc, $title, $link, $categories, $date);
                        } else {

                            echo 'Found RSS media enclosure link: ' . $media . '<br />';

                            $found = $this->saveMp3($media, $title, $link, $categories, $date);
                        }

                        // Go and scrape the full page

                        if (!$found && !empty($link)) {

                            echo '<strong>RSS contained no mp3 links, going to blog page to look for mp3 links...</strong><br />';

                            // Get the page
                            $page = $this->get_final_url_and_contents($link);

                            $page = $page['content'];

                            // See if we have a simple meta tag with our mp3 link
                            $dom = new DOMDocument();
                            $dom->preserveWhiteSpace = false;
                            @$dom->loadHTML($page);


                            echo '<br />' . memory_get_usage() . '<br />';

                            // Now check to see if we have any SoundCloud iFrames on the page
                            // Look for iFrame content from SoundCloud
                            $iframes = $dom->getElementsByTagName('iframe');

                            // Var for iframeUrl
                            $iframeUrls = array();

                            for ($i = 0; $i < $iframes->length; $i++) {
                                $iframe = $iframes->item($i);
                                $iframeUrls[] = $iframe->attributes->getNamedItem('src')->value;
                            }

                            $soundCloudFound = false;
                            /*
                              // Loop and resubmit any found content (this could be slooowww).
                              // This does not actually work as SoundCloud's iFrame contains
                              // obfuscated JS without any track ID.
                             * 
                              foreach ($iframeUrls as $iframeUrl) {
                              // If we have a soundcloud iFrame url, let's load that bad-boy up.
                              if (!empty($iframeUrl) && preg_match_all('/soundcloud/', $iframeUrl, $matches)) {

                              $soundCloudFound = true;

                              // Make a call to get url and contents
                              echo '<strong>SoundCloud IFrame found: ' . $iframeUrl . '</strong><br />';

                              $page = $this->get_final_url($iframeUrl);

                              $page = $page['content'];

                              $this->saveMp3LinkFromItem($page, $title, $link, $categories, $date);
                              }
                              }
                             */
                            // If we didn't find any SoundCloud iFrames go looking for other stuff...
                            // We could load in both SoundCloud and other stuff but that will add even more
                            // overhead and wait time...
                            if (empty($soundCloudFound)) {

                                $tagName = 'meta';
                                $attrName = 'property';
                                $attrValue = 'og:audio';

                                $meta = $this->getTags($dom, $tagName, $attrName, $attrValue);

                                // If we have a meta link then use this as our HTML
                                if (!empty($meta)) {
                                    $page = $meta;
                                }

                                $this->saveMp3LinkFromItem($page, $title, $link, $categories, $date);
                            }


                            // Try and free up some memory
                            unset($page);
                            unset($dom);
                        }
                    } else {
                        echo 'Item skipped, already saved post.<br />';
                    }
                } else {
                    echo 'Item skipped, already scanned.<br />';
                }

                echo '<br />=================== RSS Item End ===================<br />';
            }

            echo '<br /><strong>=================== Blog Done ===================</strong><br />';

            // Update the Last Crawled
            $this->last_crawled = cSkeleton::__datetimeAsMysql();

            $this->save();
        } else {

            echo "===================<br />Recent scrape, skipping: $this->feed_url<br />===================<br />";
        }

        // Free up memory
        unset($doc);
    }

    /*
     * getTags()
     * 
     * Takes a $dom[object] and searches based on 
     * $tagName[string], $attrName[string], $attrValue[string]
     * 
     * Returns $html[string]
     * 
     */

    private function getTags($dom, $tagName, $attrName, $attrValue) {
        $html = '';
        $domxpath = new DOMXPath($dom);
        $newDom = new DOMDocument;
        $newDom->formatOutput = true;

        $filtered = $domxpath->query("//$tagName" . '[@' . $attrName . "='$attrValue']");

        $i = 0;
        while ($myItem = $filtered->item($i++)) {
            $node = $newDom->importNode($myItem, true);    // import node
            $newDom->appendChild($node);                    // append node
        }
        $html = $newDom->saveHTML();
        return trim($html);
    }

    /*
     * saveMp3LinkFromItem()
     * 
     * Takes $item, searches for MP3 urls and passes any found to saveMp3().
     * 
     * Passes $title[string], $link[string], $categories[array] and $date[string] through to saveMp3()
     * 
     */

    private function saveMp3LinkFromItem($item, $title, $link, $categories, $date) {

        echo 'Searching for possible mp3 link...<br />';

        $matches = $this->findMp3Locations($item);

        if (!empty($matches)) {

            echo 'Found a possible mp3 link...<br />';

            //echo '<pre>';
            //var_dump($matches);
            //echo '</pre>';
            //echo '<br />';
            // Set up limit for how many mp3s to grab per post
            $limit = 4;
            $count = 0;

            echo '<pre>';
            var_dump($matches[0]);
            echo '</pre>';

            // Loop matched urls
            foreach ($matches[0] as $url) {

                if ($count < $limit) {

                    echo '<div class="saveit">Going for a save...</div><br />';

                    // Do the actual save
                    $this->saveMp3($url, $title, $link, $categories, $date);
                } else {

                    echo 'Item skipped, too many mp3s on page.<br />';
                }

                $count++;
            }
        } else {

            echo 'Item skipped, no mp3 links found.<br />';

            return false;
        }
    }

    /*
     * saveMp3()
     * 
     * Takes $url[string] and saves out mp3 data then makes a track object
     * to associate with the mp3.
     * 
     * 
     */

    private function saveMp3($url, $title, $link, $categories, $date) {

        // Fix js escaped strings
        $url = str_replace('\/', '/', $url);

        $finalUrl = $this->get_final_url($url);

        // Make a temp filename
        $tempFile = tempnam(STATICDIR . '/tmp/', "PHONG");

        // Save a temp file
        $this->save_file($finalUrl, $tempFile);

        $getID3 = new getID3;
        $track_data = $getID3->analyze($tempFile);

        if (!empty($track_data['id3v2'])) {

            // Get the artist and title of track
            $artist = $this->utf16_to_utf8($track_data['id3v2']['comments']['artist'][0]);
            $track = $this->utf16_to_utf8($track_data['id3v2']['comments']['title'][0]);

            if (!empty($artist) && !empty($track)) {

                echo '<strong>Ready to save track ' . $track . ' - by - ' . $artist . '</strong><br />';

                // If the tune already exists get it, otherwise add it.

                $db_track = cTrack::getByArtistTrack($artist, $track);
                if (!$db_track) {
                    $db_track = new cTrack();
                    $db_track->artist = strip_tags($artist);
                    $db_track->track = strip_tags($track);
                    $db_track->save();
                }

                $newFilename = md5($artist . $track) . '.mp3';

                // Make directory if it doesn't exist
                if (!is_dir(STATICDIR . '/audio/' . date('Y'))) {
                    mkdir(STATICDIR . '/audio/' . date('Y'));
                }

                if (!is_dir(STATICDIR . '/audio/' . date('Y') . '/' . date('m'))) {
                    mkdir(STATICDIR . '/audio/' . date('Y') . '/' . date('m'));
                }

                if (!is_dir(STATICDIR . '/audio/' . date('Y') . '/' . date('m') . '/' . date('d'))) {
                    mkdir(STATICDIR . '/audio/' . date('Y') . '/' . date('m') . '/' . date('d'));
                }

                // Create the Post and Link it to the Track
                $directory = '/audio/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';

                $inPath = $tempFile;
                $outPath = STATICDIR . $directory . $newFilename;

                // Copy the temp file to the final destination
                copy($inPath, $outPath);

                echo 'Saved mp3 link: ' . $inPath . ' --> ' . $outPath . '<br />';

                $media_url = urldecode('/static' . $directory . $newFilename);

                $post = new cBlogPost();
                $post->blog_id = $this->id;
                $post->track_id = $db_track->id;
                $post->title = strip_tags($title);
                $post->url = $link;
                $post->media_url = $media_url;
                $post->posted = cSkeleton::__datetimeAsMysql($date);
                $post->save();

                // Save the Tags

                foreach ($categories as $category) {

                    $category = strip_tags($category);

                    $tag = cTag::getByName($category);
                    if (!$tag) {
                        $tag = new cTag();
                        $tag->tag_name = $category;
                        $tag->soundex = soundex($category);
                        $tag->save();
                    }
                    $post->assignTag($tag->id);
                    $db_track->assignTag($tag->id);
                }

                echo 'Post ' . $post->id . ' saved.<br />';
            } else {
                echo 'Not saved, id3 artist/track name missing.<br />';
            }

            $status = true;
        } else {

            echo 'Not saved, mp3 link found but no id3 found.<br />';

            $status = false;
        }

        // Remove tempfile
        unlink($tempFile);

        return $status;
    }

    private function findMp3Locations($item) {

        $matches = array();

        // Match for our MP3 strings
        if (preg_match_all("/(http:\/\/soundcloud.com)([^\" >]*?)\/download/siU", $item, $matches)) {

            echo 'Found SoundCloud[type-0] link...<br />';
        } elseif (preg_match_all('/http:\\\\[\/]\\\\[\/]api.soundcloud.com\\\\[\/]tracks\\\\[\/]([0-9]*)\\\\[\/]stream\?\&consumer_key=(.*)(",\'),/siU', $item, $matches)) {


            // Wrangle the matches array a little
            $formattedMatches = array();

            // All matched urls made from matched parts into a single new constructed url
            foreach ($matches[0] as $matchKey => $match) {
                $formattedMatches[0][$matchKey] = 'http://api.soundcloud.com/tracks/' . $matches[1][$matchKey] . '/stream?&consumer_key=' . $matches[2][$matchKey];
            }

            echo 'Found SoundCloud[type-1] link...<br />';

            echo '<pre>';
            var_dump($item);
            echo '<br />';
            var_dump($matches);
            echo '</pre>';
            echo '<br />';

            $matches = $formattedMatches;

            //Null this out for now, test shows no id3s on this type.
            //$matches = null;
        } elseif (preg_match_all('/(http[^\" >]*?)\.mp3/siU', $item, $matches)) {

            echo 'Found mp3 link...<br />';
        } else {

            $matches = false;
        }

        // Try and free up memory
        unset($item);

        return $matches;
    }

    /**
     * get_redirect_url()
     * Gets the address that the provided URL redirects to,
     * or FALSE if there's no redirect. 
     *
     * @param string $url
     * @return string
     */
    private function get_redirect_url($url) {
        $redirect_url = null;

        $url_parts = @parse_url($url);
        if (!$url_parts)
            return false;
        if (!isset($url_parts['host']))
            return false; //can't process relative URLs
        if (!isset($url_parts['path']))
            $url_parts['path'] = '/';

        $sock = fsockopen($url_parts['host'], (isset($url_parts['port']) ? (int) $url_parts['port'] : 80), $errno, $errstr, 30);
        if (!$sock)
            return false;

        $request = "HEAD " . $url_parts['path'] . (isset($url_parts['query']) ? '?' . $url_parts['query'] : '') . " HTTP/1.1\r\n";
        $request .= 'Host: ' . $url_parts['host'] . "\r\n";
        $request .= "Connection: Close\r\n\r\n";
        fwrite($sock, $request);
        $response = '';

        $count = 0;

        // Limit to 100k - should be enough to find redirect info
        while (!feof($sock) && $count <= 12) {
            $count++;
            $response .= fread($sock, 8192);
        }
        fclose($sock);

        if (preg_match('/^Location: (.+?)$/m', $response, $matches)) {
            if (substr($matches[1], 0, 1) == "/")
                return $url_parts['scheme'] . "://" . $url_parts['host'] . trim($matches[1]);
            else
                return trim($matches[1]);
        } else {
            return false;
        }

        unset($response);
    }

    /**
     * get_all_redirects()
     * Follows and collects all redirects, in order, for the given URL. 
     *
     * @param string $url
     * @return array
     */
    private function get_all_redirects($url) {
        $redirects = array();
        while ($newurl = $this->get_redirect_url($url)) {
            if (in_array($newurl, $redirects)) {
                break;
            }
            $redirects[] = $newurl;
            $url = $newurl;
        }
        return $redirects;
    }

    /**
     * get_final_url()
     * Gets the address that the URL ultimately leads to. 
     * Returns $url itself if it isn't a redirect.
     *
     * @param string $url
     * @return string
     */
    private function get_final_url($url) {

        echo '<strong>Deriving final url from: ' . $url . '</strong><br />';

        $redirects = $this->get_all_redirects($url);
        if (count($redirects) > 0) {
            return array_pop($redirects);
        } else {

            echo '<strong>Final url: ' . $url . '</strong><br />';

            return $url;
        }
    }

    // Unlike get_final_url this method will return contents
    // of final url, probably not best to use for getting mp3s as it does
    // loads contents into memory.
    private function get_final_url_and_contents($url) {

        echo '<strong>Deriving final url from: ' . $url . '</strong><br />';

        $res = array();
        $options = array(
            CURLOPT_RETURNTRANSFER => true, // return web page 
            CURLOPT_HEADER => true, // return headers 
            CURLOPT_FOLLOWLOCATION => true, // follow redirects 
            CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6", // who am i 
            CURLOPT_AUTOREFERER => true, // set referer on redirect 
            CURLOPT_CONNECTTIMEOUT => 120, // timeout on connect 
            CURLOPT_TIMEOUT => 120, // timeout on response 
            CURLOPT_MAXREDIRS => 10, // stop after 10 redirects
        );
        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        $err = curl_errno($ch);
        $errmsg = curl_error($ch);
        $header = curl_getinfo($ch);
        curl_close($ch);

        $res['content'] = $content;
        $res['url'] = $header['url'];

        echo '<strong>Final url: ' . $res['url'] . '</strong><br />';

        return $res;
    }

    private function save_file($inPath, $outPath) {
        set_time_limit(0);
        $fp = fopen($outPath, 'w+');
        $ch = curl_init($inPath);
        curl_setopt($ch, CURLOPT_TIMEOUT, 75);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
    }

    /*
      private function save_file($inPath, $outPath) {
      $in = fopen($inPath, "rb");
      $out = fopen($outPath, "wb");
      while ($chunk = fread($in, 8192)) {
      fwrite($out, $chunk, 8192);
      }
      fclose($in);
      fclose($out);

      return;
      }
     */

    /**
     *
     */
    private function get_inner_html($node) {
        $innerHTML = '';
        if (!empty($node->childNodes)) {
            $children = $node->childNodes;
            foreach ($children as $child) {
                $innerHTML .= $child->ownerDocument->saveXML($child);
            }
        }
        return $innerHTML;
    }

    /**
     *
     */
    private function expandShortUrl($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_RANGE, '0-500');
        $data = curl_exec($ch);
        $pdata = $this->http_parse_headers($data);
        if (array_key_exists('location', $pdata)) {
            return $pdata['location'];
        } else {
            return $url;
        }
    }

    /**
     *
     */
    private function http_parse_headers($header) {
        $retVal = array();
        $fields = explode("\r\n", preg_replace('/\x0D\x0A[\x09\x20]+/', ' ', $header));
        foreach ($fields as $field) {
            if (preg_match('/([^:]+): (.+)/m', $field, $match)) {
                $match[1] = preg_replace('/(\?\< =^|[\x09\x20\x2D])./e', 'strtoupper("")', strtolower(trim($match[1])));
                if (isset($retVal[$match[1]])) {
                    $retVal[$match[1]] = array($retVal[$match[1]], $match[2]);
                } else {
                    $retVal[$match[1]] = trim($match[2]);
                }
            }
        }
        return $retVal;
    }

    // Useful for debugging DOM objects
    private function dom_dump($obj) {
        if ($classname = get_class($obj)) {
            $retval = "Instance of $classname, node list: \n";
            switch (true) {
                case ($obj instanceof DOMDocument):
                    $retval .= "XPath: {$obj->getNodePath()}\n" . $obj->saveXML($obj);
                    break;
                case ($obj instanceof DOMElement):
                    $retval .= "XPath: {$obj->getNodePath()}\n" . $obj->ownerDocument->saveXML($obj);
                    break;
                case ($obj instanceof DOMAttr):
                    $retval .= "XPath: {$obj->getNodePath()}\n" . $obj->ownerDocument->saveXML($obj);
                    //$retval .= $obj->ownerDocument->saveXML($obj);
                    break;
                case ($obj instanceof DOMNodeList):
                    for ($i = 0; $i < $obj->length; $i++) {
                        $retval .= "Item #$i, XPath: {$obj->item($i)->getNodePath()}\n" .
                                "{$obj->item($i)->ownerDocument->saveXML($obj->item($i))}\n";
                    }
                    break;
                default:
                    return "Instance of unknown class";
            }
        } else {
            return 'no elements...';
        }
        return htmlspecialchars($retval);
    }

    private function utf16_to_utf8($str) {
        $c0 = ord($str[0]);
        $c1 = ord($str[1]);

        if ($c0 == 0xFE && $c1 == 0xFF) {
            $be = true;
        } else if ($c0 == 0xFF && $c1 == 0xFE) {
            $be = false;
        } else {
            return $str;
        }

        $str = substr($str, 2);
        $len = strlen($str);
        $dec = '';
        for ($i = 0; $i < $len; $i += 2) {
            $c = ($be) ? ord($str[$i]) << 8 | ord($str[$i + 1]) :
                    ord($str[$i + 1]) << 8 | ord($str[$i]);
            if ($c >= 0x0001 && $c <= 0x007F) {
                $dec .= chr($c);
            } else if ($c > 0x07FF) {
                $dec .= chr(0xE0 | (($c >> 12) & 0x0F));
                $dec .= chr(0x80 | (($c >> 6) & 0x3F));
                $dec .= chr(0x80 | (($c >> 0) & 0x3F));
            } else {
                $dec .= chr(0xC0 | (($c >> 6) & 0x1F));
                $dec .= chr(0x80 | (($c >> 0) & 0x3F));
            }
        }
        return $dec;
    }

}
