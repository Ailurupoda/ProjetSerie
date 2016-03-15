<?php
define('SRT_STATE_SUBNUMBER', 0);
define('SRT_STATE_TIME',      1);
define('SRT_STATE_TEXT',      2);
define('SRT_STATE_BLANK',     3);

$lines = file('C:\wamp\www\nextwatch\Alias S1E01.FR.srt');

$subs = array();
$state = SRT_STATE_SUBNUMBER;
$subText = '';


foreach($lines as $line) {
    switch($state) {
        case SRT_STATE_SUBNUMBER:
            $subNum = trim($line);
            $state  = SRT_STATE_TIME;
            break;

        case SRT_STATE_TIME:
            $subTime = trim($line);
            $state   = SRT_STATE_TEXT;
            break;

        case SRT_STATE_TEXT:
            if (trim($line) == '') {
                $sub = new stdClass;
                $sub->text   = $subText;
                $subText     = '';
                $state       = SRT_STATE_SUBNUMBER;

                $subs[]      = $sub->text;
            } else {
                $subText .= $line;
            }
            break;
    }
}


$imparfait = '#ai(s|t|ent)$#';
$present = '#e(s|z|nt)$|ons$#';
$futur = '#er(a(i|s))$|ons$|ez$|ent$#';
$passe_simple = '#a(i|s)$|â(m|t)es$|èrent$#';


$autres = '#er|é|ant$#';
$conjug_premier_groupe = '$indic_premier_groupe|$condi_premier_groupe|$subj_premier_groupe|$autres';



$caracexclus = array('-','.','?',',',';',':','!','/',')','(','[',']','{','}');

$motsaexclures = array('il','j\'','je','me','m\'','moi','tu','te','t\'','toi','nous','vous','il','elle','ils','elles','se','en','y','le','la',
'l\'','les','lui','soi','leur','eux','lui','leur','celui','celui-ci','celui-là','celle','celle-ci',
'celle-là','ceux','ceux-ci','ceux-là','celles','celles-ci','celles-là','ce','ceci','cela','ça',
'mien','tien','sien','mienne','tienne','sienne','miens','tiens',
'siens','miennes','tiennes','siennes','nôtre','vôtre','leur','des',
'nôtre','vôtre','leur','nôtres','vôtres','leurs','qui','que','quoi','dont','où','lequel',
'auquel','duquel','laquelle','à','laquelle','de','laquelle','lesquels','auxquels','desquels','lesquelles','auxquelles',
'desquelles','qui','que','quoi','qu\'est-ce','lequel','auquel','duquel','laquelle','à','laquelle','de','laquelle',
'lesquels','auxquels','desquels','lesquelles','auxquelles','desquelles','on','tout','un','une','l\'un','l\'une',
'uns','unes','autre','autre','d\'autres','l\'autre','autres','aucun','aucune','aucuns',
'aucunes','certains','certaine','certains','certaines','tel','telle','tels','telles','tout','toute','tous','toutes',
'même','même','mêmes','nul','nulle','nuls','nulles','quelqu\'un','quelqu\'une','quelques','uns',
'quelques','personne','aucun','autrui','quiconque','d\'aucuns','',' ','qu\'il','au','ton','mais','<','i>','à','a','est',
'oui','pour','bien','mon','merci','était','suis','sais');


$mots = array();
    foreach ($subs as $value) {
        $groupemots = array();
        $groupemots[] = preg_split('/[\t\r\n\v\f\s,-_:;.!"#$?`{|}~@%&\']+/', strtolower($value));
        //unset($groupemots[count($groupemots)-1]); str_replace($caracexclus, ' ', strtolower($value))
        foreach ($groupemots as $value2) { 
            foreach ($value2 as $value3) {
                if(in_array($value3,$motsaexclures)==false and strlen($value3)>2){
                    $mots[] = $value3;
                }
            }
        }   
    }

//print_r(preg_grep($imparfait,$mots));
//print_r(preg_grep($present,$mots));
//print_r(preg_grep($futur,$mots));
//print_r(preg_grep($passe_simple,$mots));
/*print_r($mots);
print_r($subs[6]);*/

        $host = 'localhost';
        $dbname = 'nextwatch';
        $login = 'root';
        $pass = ''; //pandas


        $conn = new mysqli($host,$login,$pass,$dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $v = "";
            foreach ($mots as $value) {
                $v .= "('".$value."', 1),";
            }
            $v = substr($v, 0, -1);
            $sql = "INSERT INTO keywords (word, nbOcc) VALUES $v ON DUPLICATE KEY UPDATE nbOcc=nbOcc+1";
            $result = $conn->query($sql);


            $conn->close();

            
?>