<?php

session_start();
header('Content-type: text/html; charset=utf-8');
include('../includes/config.php');
include('../includes/functions.php');
connexion_bdd();
actualiser_session();

$bd_nom_serveur='localhost';
$bd_login='root';
$bd_mot_de_passe='';
$bd_nom_bd='catisfaction';
$connexion = mysqli_connect($bd_nom_serveur, $bd_login, $bd_mot_de_passe);
mysqli_select_db($connexion,$bd_nom_bd);
mysqli_query($connexion,"set names 'utf8'");

if(isset($_SESSION['id_user']))
{
	$informations = Array(
					true,
					'Vous êtes déjà connecté',
					'Vous êtes déjà connecté avec le nom d\'utilisateur <span class="login">'.htmlspecialchars($_SESSION['login'], ENT_QUOTES).'</span>.',
					' - <a href="'.ROOTPATH.'/membres/deconnection.php">Se déconnecter</a>',
					ROOTPATH.'/index.php',
					5
					);
	
	require_once('../information.php');
	exit();
}

if($_POST['validate'] != 'ok') {
$titre = 'Connexion';
include('../includes/top.php');
?>	
		<div id="contenu">
					
			<h1>Formulaire de connexion</h1>
			<p>Pour vous connecter, indiquez votre nom d'utilisateur et votre mot de passe.<br/>
			Vous pouvez aussi cocher l'option "Me connecter automatiquement à mon
			prochain passage." pour laisser une trace sur votre ordinateur pour être
			connecté automatiquement.<br/></p>
			
			<form name="connexion" id="connexion" method="post" action="connexion.php">
				<fieldset><legend>Connexion</legend>
					<label for="login" class="float">Nom d'utilisateur :</label> <input type="text" name="login" id="login" value="<?php if(isset($_SESSION['connexion_login'])) echo $_SESSION['connexion_login']; ?>"/><br/>
					<label for="password" class="float">Mot de passe :</label> <input type="password" name="password" id="password"/><br/>
					<input type="hidden" name="validate" id="validate" value="ok"/>
					<input type="checkbox" name="cookie" id="cookie"/> <label for="cookie">Me connecter automatiquement à mon prochain passage.</label><br/>
					<div class="center"><input type="submit" value="Connexion" /></div>
				</fieldset>
			</form>
			
			<h1>Options</h1>
			<p><a href="inscription.php">Je ne suis pas inscrit.</a><br/>
			<a href="moncompte.php?action=reset">J'ai oublié mon mot de passe.</a>
			</p>
			<?php
}
			else
			{
				$result = sqlquery($connexion,"SELECT COUNT(id_user) AS nbr, id_user, login, password FROM Utilisateur WHERE
				login = '".mysqli_real_escape_string($connexion,$_POST['login'])."' GROUP BY id_user", 1);
				
				if($result['nbr'] == 1)
				{
					if(md5($_POST['password']) == $result['password'])
					{
						$_SESSION['id_user'] = $result['id_user'];
						$_SESSION['login'] = $result['login'];
						$_SESSION['password'] = $result['password'];
						unset($_SESSION['connexion_login']);
						
						if(isset($_POST['cookie']) && $_POST['cookie'] == 'on')
						{
							setcookie('id_user', $result['id_user'], time()+365*24*3600);
							setcookie('password', $result['password'], time()+365*24*3600);
						}
						
						$informations = Array(
										false,
										'Connexion réussie',
										'Vous êtes désormais connecté avec le nom d\'utilisateur <span class="login">'.htmlspecialchars($_SESSION['login'], ENT_QUOTES).'</span>.',
										'',
										ROOTPATH.'/index.php',
										3
										);
						//require_once('../information.php');
						exit();
					}
					
					else
					{
						$_SESSION['connexion_login'] = $_POST['login'];
						$informations = Array(
										true,
										'Mauvais mot de passe',
										'Vous avez fourni un mot de passe incorrect.',
										' - <a href="'.ROOTPATH.'/index.php">Index</a>',
										ROOTPATH.'/membres/connexion.php',
										3
										);
						//require_once('../information.php');
						exit();
					}
				}
				
				else if($result['nbr'] > 1)
				{
					$informations = Array(
									true,
									'Doublon',
									'Deux membres ou plus ont le même nom d\'utilisateur, contactez un administrateur pour régler le problème.',
									' - <a href="'.ROOTPATH.'/index.php">Index</a>',
									ROOTPATH.'/contact.php',
									3
									);
					//require_once('../information.php');
					exit();
				}
				
				else
				{
					$informations = Array(
									true,
									'Nom d\'utilisateur inconnu',
									'Le nom d\'utilisateur <span class="login">'.htmlspecialchars($_POST['login'], ENT_QUOTES).'</span> n\'existe pas dans notre base de données. Vous avez probablement fait une erreur.',
									' - <a href="'.ROOTPATH.'/index.php">Index</a>',
									ROOTPATH.'/membres/connexion.php',
									5
									);
					//require_once('../information.php');
					exit();
				}
			}
			?>			
		</div>

		<?php
		include('../includes/bottom.php');
		mysqli_close($connexion);
		?>