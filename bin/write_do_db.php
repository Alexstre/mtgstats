<?php
    $host = "localhost";
    $user = "root";
    $password = "root";
    $database = "mtg";

    $mysqli = new Mysqli($host, $user, $password, $database);
    $prepare = $mysqli->prepare("INSERT INTO `cards`(`name`,`set`,`type`,`manacost`,`power`,`toughness`) VALUES (?,?,?,?,?,?)");


    $json_data = file_get_contents('JOU.json');
    $set = 'JOU';
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
        
        if (strpos($type,"Basic Land") === false) { /* Skip basic lands */
            echo $name . ' (' . $type . ') ' . $manaCost . '[' . (isset($power) ? $power : " ") . '/' . (isset($toughness) ? $toughness : " ") . ']<br>';
        }
        $prepare->bind_param("ssssii", $name, $set, $type, $manaCost, $power, $toughness);
        $prepare->execute();
        unset($power); unset($toughness);
    }

    $mysqli->close();
?>