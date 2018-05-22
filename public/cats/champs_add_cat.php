<?php

session_start();
header('Content-type: text/html; charset=utf-8');
include('../includes/config.php');

include('../includes/functions.php');
actualiser_session();

$_SESSION['erreurs'] = 0;
if(isset($_POST['name']))
{
	$name = trim($_POST['name']);
	if($name == '')
	{
		$_SESSION['name_info'] = '<span class="erreur">Vous n\'avez pas entré de nom pour votre chat.</span><br/>';
		$_SESSION['form_name'] = '';
		$_SESSION['erreurs']++;	
	}
	else
	{
		$_SESSION['name_info'] = '';
		$_SESSION['form_name'] = $name;
	}
}

else
{
	header('Location: ../index.php');
	exit();
}



if(isset($_POST['pattern']))
{
	$pattern = trim($_POST['pattern']);
	$_SESSION['form_pattern'] = $pattern;
}


else
{
	header('Location: ../index.php');
	exit();
}

if(isset($_POST['purity']))
{
	$purity = trim($_POST['purity']);
	$_SESSION['form_purity']=$purity;
	   
}

if(isset($_POST['birthdate']))
{
	$birthdate= trim($_POST['birthdate']);
	$_SESSION['form_birthdate'] = $birthdate;
}
	
if(isset($_POST['sexe']))
{
	$sexe= trim($_POST['sexe']);
	$_SESSION['form_sexe'] = $sexe;
	if($sexe == 1) {
		$ssexe = 0;
	}
	else {
		$ssexe = 1;
	}
}

else
{
	header('Location: ../index.php');
	exit();
}

if(isset($_POST['coat']))
{
	$coat = trim($_POST['coat']);
	$_SESSION['form_coat'] = $coat;
}

else
{
	header('Location: ../index.php');
	exit();
}

if(isset($_POST['size']))
{
	$size = trim($_POST['size']);
	$_SESSION['form_size'] = $size;
}

if(isset($_POST['weight']))
{
	$weight= trim($_POST['weight']);
	$_SESSION['form_weight'] = $weight;
}


if($_SESSION['erreurs'] > 0) $titre = 'Erreur lors de l\'ajout';
else $titre = 'Finalisation de l\'ajout';

include('../includes/top.php');?>
		
		<div id="contenu">
			<?php
			if($_SESSION['erreurs'] == 0)
			{
				$dbName = getenv('DB_NAME');
				$dbUser = getenv('DB_USER');
				$dbPassword = getenv('DB_PASSWORD');
				$connexion = new PDO("pgsql:host=postgres user=$dbUser dbname=$dbName password=$dbPassword");
				$retour = $connexion->query("SELECT max(id_cat) AS max_id FROM cats");
				$fetch = $retour -> fetch(PDO::FETCH_OBJ);
				
				if($connexion->exec("INSERT INTO Cats VALUES(".$connexion->quote($fetch->max_id+1).",".$_SESSION['id_user'].",".$connexion->quote($name).",
				".$connexion->quote($purity).",".$connexion->quote($pattern).",".$connexion->quote($birthdate).",'0','13',".$connexion->quote($sexe).",".$connexion->quote($ssexe).",
				".$connexion->quote($size).",'0','5',".$connexion->quote($coat).",'0','3',".$connexion->quote($weight).",'0','15')"))
				{
					$queries++;
				?>
				<h1>Chat enregistré !</h1>
				<?php
				}
				
				else
				{
					echo "Push raté";
					if($_SESSION['form_name'] !== FALSE)
					{
						unset($_SESSION['form_name']);
						$_SESSION['name_info'] = '<span class="erreur">Vous n\'avez pas renseigné de nom de chat</span><br/>';
						$_SESSION['erreurs']++;
					}
					
					if($_SESSION['erreurs'] == 0)
					{
						$sqlbug = true;
						$_SESSION['erreurs']++;
					}
				}
			}
			if($_SESSION['erreurs'] > 0)
			{
				if($_SESSION['erreurs'] == 1) {
					$_SESSION['nb_erreurs'] = '<span class="erreur">Il y a eu 1 erreur.</span><br/>';
				}
				else {
					$_SESSION['nb_erreurs'] = '<span class="erreur">Il y a eu '.$_SESSION['erreurs'].' erreurs.</span><br/>';
				}
			?>
			<h1>Ajout non validée.</h1>
			<p>Vous avez rempli le formulaire d'ajout de chat du site et nous vous en remercions, cependant, nous n'avons
			pas pu valider votre inscription, en voici les raisons :<br/>
			<?php
				echo $_SESSION['nb_erreurs'];
				echo $_SESSION['name_info'];
				
				if(1)
				{
			?>
				Nous vous proposons donc de revenir à la page précédente pour corriger les erreurs.</p>
				<div class="center"><a href="add_cat.php">Retour vers l'ajout</a></div>
			<?php
				}
				
				else
				{
			?>
			Une erreur est survenue dans la base de données, votre formulaire semble ne pas contenir d'erreurs, donc
			il est possible que le problème vienne de notre côté, nous vous conseillons de réessayer d'ajouter votre chat.</p>
			
			<div class="center"><a href="add_cat.php">Retenter un ajout</a>
			<?php
				}
			}
			?>
		</div>

		<?php
		include('../includes/bottom.php');
		?>
