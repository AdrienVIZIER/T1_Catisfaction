<?php
/* Suiite à une erreur de manipulation, toutes les majuscules du fichier ont été perdues... */

function age($date_naissance)
{
    $am = explode('/', $date_naissance);
    $an = explode('/', date('d/m/y'));

    if(($am[1] < $an[1]) || (($am[1] == $an[1]) && ($am[0] <= $an[0])))
        return $an[2] - $am[2];

    return $an[2] - $am[2] - 1;
}

function affCompat($id_the_cat) {
    $prodbreed = 5;
    $prodcolor = 3;
    $prodtraits = 1;
    $prodsizemin = 3;
    $prodsizemax = 5;
    $prodcoatmin = 4;
    $prodcoatmax = 2;
    $prodpattern = 2;
    $prodweightmin = 4;
    $prodweightmax = 4;
    $prodagemin = 7;
    $prodagemax = 4;

    $res = "";

    $dbName = getenv('DB_NAME');
    $dbUser = getenv('DB_USER');
    $dbPassword = getenv('DB_PASSWORD');
    $connexion = new PDO("pgsql:host=postgres user=$dbUser dbname=$dbName password=$dbPassword");

<<<<<<< HEAD
    $the_cat = $connexion->query("SELECT *
                                            FROM Cats
                                            WHERE id_cat = ".$id_the_cat)->fetch(PDO::FETCH_OBJ);
    $sexCh = $the_cat->sex;
    $breedCh = query("SELECT breed
                      FROM Cat_breed
                      WHERE cat = ".$id_the_cat)->fetch(PDO::FETCH_OBJ)->breed;
    $pureRace = $the_cat->purety;

    if($pureRace==1)
        $listeChats = $connexion->query("SELECT * 
                                          FROM Cats 
                                          JOIN Cat_breed ON cat=id_cat 
                                          WHERE sexe = ".$sexCh." 
                                            AND breed = ".$breedCh);
    else
        $listeChats = $connexion->query("SELECT * 
                                          FROM Cats 
                                          JOIN Cat_breed ON cat = id_cat 
                                          where sexe = ".$sexCh);
    $chatPot=$listeChats->fetch(PDO::FETCH_OBJ);
    while($chatPot){
        $chatsPot[] = $chatPot->id_cat;
        $score = 0;
        if (!is_null($the_cat->sage_min) && $the_cat->sage_min <= Age($chatPot->birthday_cat))
            $score += $prodAgeMin;
        if (!is_null($the_cat->sage_max) && $the_cat->sage_max <= Age($chatPot->birthday_cat))
            $score += $prodAgeMax;
        if (!is_null($the_cat->scsize_min) && $the_cat->scsize_min <= $chatPot->csize)
            $score += $prodSizeMin;
        if (!is_null($the_cat->scsize_max) && $the_cat->scsize_max <= $chatPot->csize)
            $score += $prodSizeMax;
        if (!is_null($the_cat->scoat_min) && $the_cat->scoat_min <= $chatPot->coat)
            $score += $prodCoatMin;
        if (!is_null($the_cat->scoat_max) && $the_cat->scoat_max <= $chatPot->coat)
            $score += $prodCoatMax;
        if (!is_null($the_cat->sweight_min) && $the_cat->sweight_min <= $chatPot->weight)
            $score += $prodWeightMin;
        if (!is_null($the_cat->sweight_max) && $the_cat->sweight_max <= $chatPot->weight)
            $score += $prodWeightMax;
        $score += $prodBreed * $connexion->query("SELECT COUNT(*)
                                                            FROM Cat_breed 
                                                            JOIN Searched_breeds ON Cat_breed.breed = Searched_breeds.breed
                                                            WHERE Searched_breeds.cat = ".$id_the_cat."
                                                              AND Cat_breed.cat=" . $chatPot->id_cat); /*->fetch ?? */
        $score += $prodColor * $connexion->query("SELECT COUNT(*)
                                                            FROM Cat_color 
                                                            JOIN Searched_colors ON Cat_color.color = Searched_colors.color
                                                            WHERE Searched_colors.cat = ".$id_the_cat."
                                                              AND Cat_color.cat = ".$chatPot->id_cat);
        $score += $prodTraits * $connexion->query("SELECT COUNT(*)
                                                            FROM Cat_trait 
                                                            JOIN Searched_traits ON Cat_trait.trait = Searched_traits.trait
                                                            WHERE Searched_traits.cat = ". $id_the_cat ."
                                                              AND Cat_trait.cat= ".$chatPot->id_cat);
        $score += $prodPattern * $connexion->query("SELECT COUNT(*)
                                                            FROM Searched_pattern 
                                                            WHERE cat = ".$id_the_cat ."
															AND pattern = ".$chatPot->pattern);
        $scoreChatsPot[] = $score;
=======
    $the_cat = $connexion->query("select *
                                            from Cats
                                            where id_cat=".$id_the_cat)->fetch(PDO::FETCH_OBJ);
    $sexch = $the_cat->sex;
    $breedch = query("select breed
                      from Cat_breed
                      where cat=".$id_the_cat)->fetch(PDO::FETCH_OBJ)->breed;
    $purerace = $the_cat->purety;

    if($purerace==1)
        $listechats = $connexion->query("select * 
                                          from Cats 
                                          join Cat_breed on cat=id_cat 
                                          where sexe=" . $sexch . " 
                                            and breed=" . $breedch);
    else
        $listechats = $connexion->query("select * 
                                          from Cats 
                                          join Cat_breed on cat=id_cat 
                                          where sexe=" . $sexch);
    $chatpot=$listechats->fetch(PDO::FETCH_OBJ);
    while($chatpot){
        $chatspot[] = $chatpot->id_cat;
        $score = 0;
        if (!is_null($the_cat->sage_min) && $the_cat->sage_min <= age($chatpot->birthday_cat))
            $score += $prodagemin;
        if (!is_null($the_cat->sage_max) && $the_cat->sage_max <= age($chatpot->birthday_cat))
            $score += $prodagemax;
        if (!is_null($the_cat->scsize_min) && $the_cat->scsize_min <= $chatpot->csize)
            $score += $prodsizemin;
        if (!is_null($the_cat->scsize_max) && $the_cat->scsize_max <= $chatpot->csize)
            $score += $prodsizemax;
        if (!is_null($the_cat->scoat_min) && $the_cat->scoat_min <= $chatpot->coat)
            $score += $prodcoatmin;
        if (!is_null($the_cat->scoat_max) && $the_cat->scoat_max <= $chatpot->coat)
            $score += $prodcoatmax;
        if (!is_null($the_cat->sweight_min) && $the_cat->sweight_min <= $chatpot->weight)
            $score += $prodweightmin;
        if (!is_null($the_cat->sweight_max) && $the_cat->sweight_max <= $chatpot->weight)
            $score += $prodweightmax;
        $score += $prodbreed * $connexion->query("select count(*)
                                                            from Cat_breed 
                                                            join Searched_breeds on Cat_breed.breed = Searched_breeds.breed
                                                            where Searched_breeds.cat=" . $id_the_cat ."
                                                              and Cat_breed.cat=" . $chatpot->id_cat); /*->fetch ?? */
        $score += $prodcolor * $connexion->query("select count(*)
                                                            from Cat_color 
                                                            join Searched_colors on Cat_color.color = Searched_colors.color
                                                            where Searched_colors.cat=" . $id_the_cat ."
                                                              and Cat_color.cat=" . $chatpot->id_cat);
        $score += $prodtraits * $connexion->query("select count(*)
                                                            from Cat_trait 
                                                            join Searched_traits on Cat_trait.trait = Searched_traits.trait
                                                            where Searched_traits.cat=" . $id_the_cat ."
                                                              and Cat_trait.cat=" . $chatpot->id_cat);
        $score += $prodpattern * $connexion->query("select count(*)
                                                            from Searched_pattern 
                                                            where cat=" . $id_the_cat .
                                                            "and pattern =" . $chatpot->pattern);
        $scorechatspot[] = $score;
>>>>>>> 2a701ab235ca5127afc8e2524c66a6c822facb84
    }
    if (empty($chatspot)) {
        $res .= "<h3> malheureusement, il ne semble qu'aucun chat ne corresponde à vos attentes </h3>";
        $res .= "<p> nous vous invitons à soit attendre que le chat donc vous rêvez la nuit apparaisse sur le site, soit à revoir vos critères de recherche </p>";
    }
    else {
<<<<<<< HEAD
        array_multisort($scoreChatsPot, $chatsPot);
        foreach($chatPot as $elu) {
            $num = $connexion->query("SELECT phone_number
									FROM Utilisateurs 
									WHERE cat = ".$id_the_cat .);
=======
        array_multisort($scorechatspot, $chatspot);
        foreach($chatpot as $elu) {
            $infoelu = $connexion->query("select phone_number, name_cat, 
                                                from Utilisateur
                                                natural join Cats 
                                                where cat=" . $chatpot)->fetch(PDO::FETCH_OBJ);
            $res.= "<tr> <td>".$infoelu->name_cat."</td><td>".$infoelu->phone_number."</td> </tr>";
>>>>>>> 2a701ab235ca5127afc8e2524c66a6c822facb84
        }
    }
    return $res;
}

/*
function affmenu(){
    $dbname = getenv('db_name');
    $dbuser = getenv('db_user');
    $dbpassword = getenv('db_password');
    $connexion = new pdo("pgsql:host=postgres user=$dbuser dbname=$dbname password=$dbpassword");
    $chatsPossédés = $connexion->query("SELECT id_cat,Cat_name
                                                  FROM cats
                                                  NATURAL JOIN utilisateur
                                                  WHERE id_user=".$_SESSION['id_user']);
    print "<script>
            <form name=\"choix\">
                <select name=\"liste\" onchange=\"document.getElementById('matchables').value\">'. foreach().'
                </select>
           </form>'
        </script>
    <table style='display:none;' id='matchables'>
    </table>";
}
*/


?>