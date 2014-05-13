<?php
    function file_get_contents_utf8($fn) {
        $content = file_get_contents($fn);
        return mb_convert_encoding($content, 'UTF-8',
            mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
    }

    $host = "localhost";
    $user = "root";
    $password = "root";
    $database = "mtg";

    $mysqli = new Mysqli($host, $user, $password, $database);
    mysqli_query($mysqli, 'utf8');
    
    $prepare = $mysqli->prepare("INSERT INTO `cards`(`name`,`set`,`type`,`manacost`,`power`,`toughness`) VALUES (?,?,?,?,?,?)");

    $sets = array('BNG', 'DGM', 'GTC', 'JOU', 'M14', 'RTR', 'THS');
    
    foreach($sets as $set) {
        echo 'Adding ' . $set . '<br>';
        $json_data = file_get_contents_utf8($set . '.json');
        $cards = json_decode($json_data, true)['cards'];
        foreach($cards as $key => $value) {
            
            $name = $value['name']; /* Always defined */
            $type = str_replace('—', '-', $value['type']); /* Fixed encoding from mtgjson */

            /* We might not always have a mana cost, this'll fix it */
            if (isset($value['manaCost'])) $manaCost = $value['manaCost'];
            else $manaCost = NULL;

            /* Same with Power / Toughness */
            if (isset($value['power'])) $power = $value['power'];
            else $power = NULL;
            if (isset($value['toughness'])) $toughness = $value['toughness'];
            else $power = NULL;
            
            echo $name . ' (' . $type . ') ' . $manaCost . '[' . (isset($power) ? $power : " ") . '/' . (isset($toughness) ? $toughness : " ") . ']<br>';
            
            $prepare->bind_param("ssssii", $name, $set, $type, $manaCost, $power, $toughness);
            $prepare->execute();
            unset($power); unset($toughness);
        }
    }
    $mysqli->close();
?>