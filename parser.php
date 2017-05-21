<?php

/**
 * Class ParseCallPrice
 *
 * For parsing call price from site.
 */
class ParseCallPrice implements ParserInterface
{
    /**
     * @param $to string
     * @return    array
     */
    public function run($to)
    {
        /**
         *  Check $to param, if user will pass for example United Kingdom,
         *  we need to add %20 between two words, like United%20Kingdom;
         */
        $checkTo = explode(' ', $to);

        if (count($checkTo) > 1)
        {
            $processedTo = implode('%20', $checkTo);
        }

        // Get html from site
        $url = file_get_contents('http://www.vinota.com/search4.cfm?input1=' . $processedTo);
        // Paste html markup to phpQuery
        $htmlMarkup = phpQuery::newDocument($url);
        // Find all p tags with data
        $groupOfTags = $htmlMarkup->find('.row > .col-sm-12 > .col-sm-7 > .row.text-center p');
        // Array with val from p tag
        $groupOfTagsValue = [];

        foreach ($groupOfTags as $item) {
            $groupOfTagsValue[] = pq($item)->html();
        }
        
        /**
         *  array_chunk, because in response from site, we have data from 0 to 3 etc.
         *  var $stmt - PDO
         */
        foreach (array_chunk($groupOfTagsValue, 4) as $item)
        {
            $stmt = $db->prepare("
                INSERT INTO rates(id, destination, location, is_mobile, call_price, connection_fee, sms_price)
                VALUES(default, :destination, :location, :is_mobile, :call_price, :connection_fee, :sms_price)
           ");

            $location = explode('-', $item[0]);
            // on page sometimes we can see ' ' or ':' in titles of phone types
            $is_mobile = (str_replace([' ', ':'], '', $location[0]) == 'MOBILE') ? true : false;

            $stmt->bindValue(':destination', $to);
            $stmt->bindValue(':location', $location[1]);
            $stmt->bindValue(':is_mobile', $is_mobile);
            $stmt->bindValue(':call_price', floatval($item[1]));
            $stmt->bindValue(':connection_fee', floatval($item[3]));
            $stmt->bindValue(':sms_price', floatval($item[2]));

            $stmt->closeCursor();

            $stmt->execute();
        }

        return $groupOfTagsValue;
    }

}
