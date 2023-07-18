<?php
$temps = floor(time()/60);


$TYPE_GUERRE = "guerre";
$TYPE_PNA = "pna";
$VALIDE_EN_COURS = "encours";
$VALIDE_EN_ATTENTE ="enattente";	// pour les pna pas encore validés et les demandes de redditions de guerre
$VALIDE_EN_NEGOCIA ="ennegocia";	// pour les propositions de paix par égalité
$VALIDE_BLOQUE = "bloque";
$VALIDE_TERMINE = "termine";

$nbrmindeclar = 3 ;

$type_condition = array(
	'default' 	=>	array(""		," - - - - - - "		,""),
	'spacer'	=>	array(""		," - première armada à...",""),
	'temps' 	=>	array("temps"		,"durée (jours)"	,"Durée (jours)"),
	'nbrcomb'	=>	array("nbrcomb"		,"nombre de combats"	,"Nombre de combats"),
	'nbratta' 	=>	array("nbratta"		,"nombre d'attaques"	,"Nombre d'attaques"),
	'nbrattareel' 	=>	array("nbrattareel"	,"nombre d'attaques (réel)"	,"Nombre d'attaques<br />(sans modificateurs)"),
	'nbrvict' 	=>	array("nbrvict"		,"nombre de victoires"	,"Nombre de victoires"),
	'nbrvictreel' 	=>	array("nbrvictreel"	,"nombre de victoires (réel)"	,"Nombre de victoires<br />(sans modificateurs)"),
	'xp'		=>	array("xp"		,"xp"			,"XP gagnée"),
	'pertePuiss'	=>	array("pertePuiss"	,"perte puissance"	,"Perte de puissance infligée"),
	'acres'		=>	array("acres"		,"acres volées"		,"Acres volées"),
	'prison'	=>	array("prison"		,"prisonniers capturés"	,"Prisonniers capturés"),
	'tues'		=>	array("tues"		,"villageois tués"	,"Villageois tués"),
	'detruits'	=>	array("detruits"	,"bâtiments détruits"	,"Bâtiments détruits"),
	'or'		=>	array("or"		,"or volé"		,"Or volé"),
	'ressources'	=>	array("ressources"	,"ressources"		,"Ressources volées")
);



// liste des conditions possibles pour fin de guerre
function conditionlist($select='')
{
	global $type_condition;
	$ans = '';
	$z='default';		$ans.='	<option value="'.$type_condition[$z][0].'"';	if ($select==$z) $ans.=' selected';	$ans.='>'.$type_condition[$z][1].'</option>';
	$z="temps";		$ans.='	<option value="'.$type_condition[$z][0].'"';	if ($select==$z) $ans.=' selected';	$ans.='>'.$type_condition[$z][1].'</option>';
	$z='nbrcomb';		$ans.='	<option value="'.$type_condition[$z][0].'"';	if ($select==$z) $ans.=' selected';	$ans.='>'.$type_condition[$z][1].'</option>';
	$z='spacer';		$ans.='	<option value="'.$type_condition[$z][0].'"';	if ($select==$z) $ans.=' selected';	$ans.='>'.$type_condition[$z][1].'</option>';
	$z='nbratta';		$ans.='	<option value="'.$type_condition[$z][0].'"';	if ($select==$z) $ans.=' selected';	$ans.='>'.$type_condition[$z][1].'</option>';
	$z='nbrvict';		$ans.='	<option value="'.$type_condition[$z][0].'"';	if ($select==$z) $ans.=' selected';	$ans.='>'.$type_condition[$z][1].'</option>';
	$z='xp';		$ans.='	<option value="'.$type_condition[$z][0].'"';	if ($select==$z) $ans.=' selected';	$ans.='>'.$type_condition[$z][1].'</option>';
	$z='pertePuiss';	$ans.='	<option value="'.$type_condition[$z][0].'"';	if ($select==$z) $ans.=' selected';	$ans.='>'.$type_condition[$z][1].'</option>';
	$z='acres';		$ans.='	<option value="'.$type_condition[$z][0].'"';	if ($select==$z) $ans.=' selected';	$ans.='>'.$type_condition[$z][1].'</option>';
	$z='prison';		$ans.='	<option value="'.$type_condition[$z][0].'"';	if ($select==$z) $ans.=' selected';	$ans.='>'.$type_condition[$z][1].'</option>';
	$z='tues';		$ans.='	<option value="'.$type_condition[$z][0].'"';	if ($select==$z) $ans.=' selected';	$ans.='>'.$type_condition[$z][1].'</option>';
	$z='detruits';		$ans.='	<option value="'.$type_condition[$z][0].'"';	if ($select==$z) $ans.=' selected';	$ans.='>'.$type_condition[$z][1].'</option>';
	$z='or';		$ans.='	<option value="'.$type_condition[$z][0].'"';	if ($select==$z) $ans.=' selected';	$ans.='>'.$type_condition[$z][1].'</option>';
	$z='ressources';	$ans.='	<option value="'.$type_condition[$z][0].'"';	if ($select==$z) $ans.=' selected';	$ans.='>'.$type_condition[$z][1].'</option>';
	return $ans."\n";
}


function depasseseuil ($data, $i, $nguilde)
{
	global $temps;
	$cond = $data['cond'.$i];
	$val  = $data['val'.$i];
	
//	echo "<br>$cond|$val|";
	
	//if ($data['dateDebut'] < 21060011)		// CF. guerres_details.php l.193
	
	if ($cond == "pertePuiss") {	// a cause d'une implantation malheureuse, faut inverser les guildes, flipper 1 et 2.
		$nguilde = 3 - $nguilde; 
	}


	if ($cond == "temps") {
		if ($temps >= $val)
			return $temps - $val;
	}
	else if ($cond == "nbrcomb") {
		//if ($data['dateDebut'] < 21060011)
		if ($data['nbratta1']+$data['nbratta2'] >= $val)
			return $data['nbratta1']+$data['nbratta2'] - $val;
	}
	else if (($nguilde==1)||($nguilde==2))
	{
		//if ($data['dateDebut'] < 21060011)
		if ($cond == "nbratta") {
			if ($data['nbratta'.$nguilde] >= $val)
				return $data['nbratta'.$nguilde] - $val;
		}
		else if ($cond == "nbrvict") {
			if ($data['nbrvict'.$nguilde] >= $val)
				return $data['nbrvict'.$nguilde] - $val;
		}
		else if (($nguilde==1)||($nguilde==2)) {
			if ($data[$cond.$nguilde] >= $val)
				return $data[$cond.$nguilde] - $val;
		}
	}
	return -1;
}


// bout de code pour déterminer si une guerre est terminée (comparaison avec les conditions de fin de guerre)
function checkguerreterminee($id, $butin=false)
{
//	if ($butin==true)	echo "butinOUI|";
//	else			echo "butinNON|";
	global $temps;
	global $TYPE_GUERRE, $TYPE_PNA, $VALIDE_EN_COURS, $VALIDE_EN_ATTENTE, $VALIDE_EN_NEGOCIA, $VALIDE_BLOQUE, $VALIDE_TERMINE;

	$tempsminguerre = 10080; // 10080 = 60*24*7 == une semaine
	
	$req = mysql_query("SELECT * FROM guerres WHERE id = '$id'") or die('Erreur SQL !<br>'.mysql_error());
	if ($data = mysql_fetch_assoc($req))
	{
		$deltat = $temps - $data['dateDebut'];
		if ( ($deltat>$tempsminguerre) AND ($data['type'] == $TYPE_GUERRE) && (($data['valide'] == $VALIDE_EN_COURS)||($data['valide'] == $VALIDE_EN_ATTENTE)||($data['valide'] == $VALIDE_EN_NEGOCIA)) )
		{
			$egalite = false;
			
//			echo $data['andor']."<br>";
			
			if ($data['andor'] == "AND")
			{
				// contrôle que les conditions soient toutes valides
				$flag1 = true;
				$flag2 = true;
				for ($j=1; $j<=3; $j++)							// boucle sur les 3 conditions
				{
					if ((strlen($data['cond'.$j])>0) && ($data['val'.$j]>0))	// condition existe effectivement
					{
						if (depasseseuil($data, $j, 1)<0)
							$flag1 = false;
						if (depasseseuil($data, $j, 2)<0)
							$flag2 = false;
					}
				}
//				if ($flag1)	echo "flag1OK<br>";	else	echo "flag1noooon<br>";
//				if ($flag2)	echo "flag2OK<br>";	else	echo "flag2noooon<br>";
				// y at-il un vainqueur? si oui, flag1 et/ou flag2 sont true.
				if (($flag1)&&(!$flag2))
					return termineguerre ($id, $data['guilde1'], $butin);
				if ((!$flag1)&&($flag2))
					return termineguerre ($id, $data['guilde2'], $butin);
				if (($flag1)&&($flag2))							// les 2 passent le seuil, on checke les conditions les unes après les autres pour voir laquelle est dépassée de plus en premier
				{
					for ($j=1; $j<=3; $j++)							// boucle sur les 3 conditions; la première a donc la priorité
					{
						if ((strlen($data['cond'.$j])>0) && ($data['val'.$j]>0))	// condition existe effectivement
						{
							$supp1 = depasseseuil($data, $j,1);
							$supp2 = depasseseuil($data, $j,2);
//							echo "$supp1|$supp2|";
							if (($supp1>=0)&&($supp1>$supp2))
								return termineguerre ($id, $data['guilde1'], $butin);
							else if (($supp2>=0)&&($supp2>$supp1))
								return termineguerre ($id, $data['guilde2'], $butin);
							else if (($supp2>=0)&&($supp2==$supp1))
								$egalite = true;
							// on ne fait rien si aucune des guildes dépasse le seuil
						}
					}

				}
			}
			else if ($data['andor'] == "OR")
			{
				for ($j=1; $j<=3; $j++)							// boucle sur les 3 conditions; la première a donc la priorité
				{
					if ((strlen($data['cond'.$j])>0) && ($data['val'.$j]>0))	// condition existe effectivement
					{
						$supp1 = depasseseuil($data, $j, 1);
						$supp2 = depasseseuil($data, $j, 2);
//						echo "supp1: ".$supp1."<br>";
//						echo "supp2: ".$supp2."<br>";
						if (($supp1>=0)&&($supp1>$supp2))
							return termineguerre ($id, $data['guilde1'], $butin);
						else if (($supp2>=0)&&($supp2>$supp1))
							return termineguerre ($id, $data['guilde2'], $butin);
						else if (($supp2>=0)&&($supp2==$supp1))
							$egalite = true;
						// on ne fait rien si aucune des guildes dépasse le seuil
					}
				}
			}
			if ($egalite)
			{
				// on checke si une des deux guildes a gagné plus d'xp que l'autre. priorité au défenseur en cas d'égalité :-P
				if ($data['xp1']>$data['xp2'])
					return termineguerre ($id, $data['guilde1'], $butin);
				else
					return termineguerre ($id, $data['guilde2'], $butin);
			}
		}
	}
	return false;
}

function termineguerre ($id, $guilde, $butin=false)
{
	// note: les indeps qui aident les armadas ne prennent part ni aux butins ni aux gains en fin de guerre, et n'ont pas non plus de missive
	
	global $temps;
	global $TYPE_GUERRE, $TYPE_PNA, $VALIDE_EN_COURS, $VALIDE_EN_ATTENTE, $VALIDE_EN_NEGOCIA, $VALIDE_BLOQUE, $VALIDE_TERMINE;
	$date = returndate ($temps*60);
	//	$date = $heure.'<br>'.$jour.' '.$mois;
	
	$req = mysql_query("SELECT * FROM guerres WHERE id = '$id'") or die('Erreur SQL !<br>'.mysql_error());
	if ($data = mysql_fetch_assoc($req))
	{
		$vainqueur = $guilde;
		$autre = '';
		if ($vainqueur == 'Aucun')
		{
			$guilde =	$data['guilde1'];
			$autre  =	$data['guilde2'];
			$flag = false;		// vérification que ya bien pas de butin en cas d'égalité
			$tit_vainq	= 'Une mauvaise paix vaut mieux qu\'une bonne guerre...';
			$tit_vainc	= $tit_vainq;
			$arc_vainc	= "La guerre que votre armada menait contre $guilde s'est terminée par un cessez-le-feu sans réel vainqueur.";
			$arc_vainq	= "La guerre que vous meniez contre l'armada $autre s'est terminée par un cessez-le-feu sans réel vainqueur.";
			$txt_even	= 'La guerre entre <b>'.$data['guilde1'].'</b> et <b>'.$guilde['guilde2'].'</b> s\'est soldée par un cessez-le-feu...';
		}
		else
		{
			if ($guilde==$data['guilde1'])	$autre = $data['guilde2'];
			if ($guilde==$data['guilde2'])	$autre = $data['guilde1'];
			$tit_vainq	= 'Votre armada a remporté une éclatante victoire!';
			$tit_vainc	= 'Votre armada a subi une cuisante humiliation!';
			$arc_vainq	= "La guerre que vous meniez contre l'armada $autre s'est terminée par votre éclatante victoire!";
			$arc_vainc	= "La guerre que votre armada menait contre $guilde s'est terminée par une misérable défaite.";
			$txt_even	= '<b>'.$guilde.'</b> a triomphé de <b>'.$autre.'</b> dans la guerre qui les opposait!';
		}
		
		// déclare la guerre terminée
		$req1 = mysql_query("SELECT puissance FROM guildes WHERE nom = '".$data['guilde1']."'") or die('Erreur SQL !<br>'.mysql_error());
		$req2 = mysql_query("SELECT puissance FROM guildes WHERE nom = '".$data['guilde2']."'") or die('Erreur SQL !<br>'.mysql_error());
		$puiss1 = mysql_fetch_row($req1);
		$puiss2 = mysql_fetch_row($req2);
		$req3 = mysql_query("UPDATE guerres SET valide = '$VALIDE_TERMINE', initiateur = '', vainqueur = '$vainqueur', dateFin = '$temps', puissFin1 = '$puiss1[0]', puissFin2 = '$puiss2[0]' WHERE id = '".$data['id']."'") or die('Erreur SQL !<br>'.mysql_error());
		
		// butin de guerre
		// on prend 30% de l'or aux vaincus; redistribués équitablement entre les gagnants
		// on considère que les indeps n'ont pas à être mêlés à des histoires de guerre. S'ils le sont, c'est juste des affaires de statistique...
		$fraction = 0.3;	// je pense que 0.3 est une bonne fraction pour la part de l'or mise comme butin
		$req2 = mysql_query("SELECT nom FROM joueurs_bonus WHERE guilde = '$autre'") or die('Erreur SQL !<br>'.mysql_error());
		$nbr = mysql_num_rows($req2);
		$or_tot = 0;
		// prise du butin
		while ($vaincu = mysql_fetch_row($req2))
		{
			$req3 = mysql_query("SELECT argent, id, nom FROM joueurs_stats WHERE nom = '$vaincu[0]'") or die('Erreur SQL !<br>'.mysql_error());
			if ($or = mysql_fetch_row($req3))
			{
				$archives_vaincu = $arc_vainc;
				if ($butin)
				{	// si ya prélèvement de butin, on met a jour l'or et on ajoute tit truc dans la missive
					// on va aussi chercher les mises sur le marché pour éviter la "fuite de capitaux"
					$offremarche = 0;
					$req4 = mysql_query("SELECT offre FROM foire_vente WHERE acheteur = '$vaincu[0]'") or die('Erreur SQL !<br>'.mysql_error());
					while ($offre = mysql_fetch_row($req4))
						$offremarche += $offre[0];
					// calcul du tribut
					$transfert = min($or[0], floor( ($or[0]+$offremarche) * $fraction)); 	// arrondi inférieur, ça évite des bugs potentiels
					$reste = $or[0] - $transfert;
					$or_tot += $transfert;
					mysql_query("UPDATE joueurs_stats SET argent = '$reste' WHERE id = '$or[1]';") or die('Erreur SQL !<br>'.mysql_error());
					$archives_vaincu.="\n\nAfin de vous accorder les bonnes grâces de vos vainqueurs, un tribut a été prélevé sur votre trésorerie, pour un montant de $transfert pièces d'or.";
				}
				envoie_missive($vaincu[0],  $tit_vainc, $archives_vaincu, 'joueur');
			}
		}
		/*
		// la moitié de la somme est versée au palatin du vainqueur
		$req1 = mysql_query("SELECT province FROM guildes WHERE nom = '$guilde'") or die('Erreur SQL !<br>'.mysql_error());
		$province1 = mysql_fetch_row($req1);
		$province = $province1[0];
		mysql_query("UPDATE `provinces_politiques` SET `argent` = `argent`+'".($or_tot/2)."' WHERE province = '$province'");
		*/
		
		// redistribution aux vainqueurs d'une somme égale à /*la moitié de*/ la moyenne de ce qu'on payé les vaincus
		$req2 = mysql_query("SELECT nom FROM joueurs_bonus WHERE guilde = '$guilde'") or die('Erreur SQL !<br>'.mysql_error());
		$part = min(1000000,ceil($or_tot/2/$nbr));				// part de butin que reçoit chaque vainqueur, arrondi sup, soyons généreux avec les vainqueurs, mais pas trop (dans la limite de 1 million, dans le cas par exemple de guere contre des pnj)
		while ($vainqueur = mysql_fetch_row($req2))
		{
			$req3 = mysql_query("SELECT argent, id FROM joueurs_stats WHERE nom = '$vainqueur[0]'") or die('Erreur SQL !<br>'.mysql_error());
			if ($or = mysql_fetch_row($req3))
			{
				$archives_vainqueur	= $arc_vainq;
				if ($butin)
				{	// si ya prélèvement de butin, on met a jour l'or et on ajoute tit truc dans la missive
					$or_nouveau = $or[0] + $part;
					mysql_query("UPDATE joueurs_stats SET argent = '$or_nouveau' WHERE id = '$or[1]'") or die('Erreur SQL !<br>'.mysql_error());
					$archives_vainqueur.="\n\nLes vaincus se sont fait fait une joie de vous offrir un tribut; votre part s'est élevée à un montant de $part pièces d'or.";
				}
				envoie_missive($vainqueur[0], $tit_vainq, $archives_vainqueur, 'joueur');
			}
		}
		// enregistrement dans la base du butin total, pour si jamais.
		mysql_query("UPDATE guerres SET prop1 = 'Butin total', valp1 = '$or_tot' WHERE id = '$id'") or die('Erreur SQL !<br>'.mysql_error());
//		echo "BOUH!!!";

		// message d'évènement sur la page d'accueil
		if ($part > 50000)
			$txt_even .= ' Les vainqueurs ont reçu un butin de '.$part.' pièces d\\\'or chacun.';
		ajouteEvenement ($txt_even);

		return true;
	}
	return false;
}



// Fonctions utile pour les envois par messagerie interne
function getMois($month){
	$mois = array();
	$mois["January"] = "Janvier";
	$mois["February"] = "Février";
	$mois["March"] = "Mars";
	$mois["April"] = "Avril";
	$mois["May"] = "Mai";
	$mois["June"] = "Juin";
	$mois["July"] = "Juillet";
	$mois["August"] = "Août";
	$mois["September"] = "Septembre";
	$mois["October"] = "Octobre";
	$mois["November"] = "Novembre";
	$mois["December"] = "Décembre";
	return $mois[$month];
}

// envoi de missives internes
function envoie_missive($dest, $titre, $message, $chef = 'seul')
{
	// $from et $desti doivent être des noms de guilde
	// pour envoyer à toute la guilde $chef doit être initialisé à 'tous'
	// dans le cas contraire la missive n'est envoyée qu'au chef
	// si $chef est initialisée à 'joueur', la missive est envoyée au joueur concerné
	global $temps;
	
	$auteur = 'Office des Affaires Etrangères';
	$titre   = str_replace("'", "`", $titre  );
	$message = str_replace("'", "`", $message);
	
	$date = Date('d').' '.getMois(Date('F'));
	// controle de validité des destinataires, puis envoi aux destinataires
	$req1 = mysql_query("SELECT id, chef FROM guildes WHERE nom = '$dest' LIMIT 1") or die('Erreur SQL !<br>'.mysql_error());
	if (mysql_num_rows($req1) > 0)
	{
		if ($chef != 'tous')	// seulement au chef de l'armada $dest
		{
			$data1 = mysql_fetch_row($req1);
			$sql = "INSERT INTO messagerie
						( `id`	, `auteur`	, `destinataire`, `titre`			, `message`			, `date`	, `temps`)
					VALUES 	(''	, '$auteur'	, '$data1[1]'	, '".addslashes($titre)."'	, '".addslashes($message)."'	, '$date'	, '$temps');";
			mysql_query($sql);
		}
		else if ($chef != 'joueur')			// à tous les joueurs de l'armada $dest
		{
			$req2 = mysql_query("SELECT nom FROM joueurs_bonus WHERE guilde = '$dest'") or die('Erreur SQL !<br>'.mysql_error());
			while ($data2 = mysql_fetch_row($req2))
			{
				$req = "INSERT INTO messagerie
						( `id`	, `auteur`	, `destinataire`, `titre`	, `message`	, `date`	, `temps`)
					VALUES 	(''	, '$auteur'	, '$data2[0]'	, '$titre'	, '$message'	, '$date'	, '$temps');";
				mysql_query($req);
			}		
		}
	}
	$req1 = mysql_query("SELECT nom FROM joueurs_stats WHERE nom = '$dest' LIMIT 1") or die('Erreur SQL !<br>'.mysql_error());
	if (($chef == 'joueur')&&(mysql_num_rows($req1) > 0))
	{
		$req = "INSERT INTO messagerie
						( `id`	, `auteur`	, `destinataire`, `titre`	, `message`	, `date`	, `temps`)
					VALUES 	(''	, '$auteur'	, '$dest'	, '$titre'	, '$message'	, '$date'	, '$temps');";
		mysql_query($req);
	}
}

function capturecondition($i, $guilde1='', $guilde2='')
{
	global $temps, $serveur;
	$cond = $_POST['cond'.$i];
	$val  = $_POST['val' .$i];
	
	// tenir compte de la diminution d'xp du serveur 3
	$facteurxp = 1;
	if ($serveur == 3)
		$facteurxp = 0.5;
	// le nombre de combats minimal espéré est de max ( 30, (# de joueurs dans les 2 guildes) = 2*(# joueurs dans une guilde) )
	// donc on impose deux combats par joueur comme approximation pour des conditions de victoires minimales, ce qui me parait raisonnable
	$req1 = mysql_query("SELECT nb_membres FROM guildes WHERE nom = '$guilde1' LIMIT 1") or die('Erreur SQL !<br>'.mysql_error());
	$req2 = mysql_query("SELECT nb_membres FROM guildes WHERE nom = '$guilde2' LIMIT 1") or die('Erreur SQL !<br>'.mysql_error());
	$nb = 0;
	if ($data = mysql_fetch_row($req1))	$nb += $data[0];
	if ($data = mysql_fetch_row($req2))	$nb += $data[0];
	$nb = max($nb, 30);
	
	if (($val == '') || (@is_NaN($val)) || ($cond == ""))
	{
		$val = 0;
		$cond = '';
	}
	if ($cond == "temps")		$val = max($val, 7) *24*60 + $temps;
	if ($cond == "nbrcomb")		$val = max($val, $nb*2);	// total combats
	if ($cond == "nbratta")		$val = max($val, $nb*1.5);	// attaques par guilde
	if ($cond == "nbrvict")		$val = max($val, $nb*1.5);	// victoires par guilde
	if ($cond == "xp")		$val = max($val, $nb  *1000*$facteurxp);
	if ($cond == "pertePuiss")	$val = max($val, $nb  *10000);
	if ($cond == "acres")		$val = max($val, $nb/2*5000);
	if ($cond == "prison")		$val = max($val, $nb/2*10000);
	if ($cond == "tues")		$val = max($val, $nb/2*5000);
	if ($cond == "detruits")	$val = max($val, 3);
	if ($cond == "or")		$val = max($val, $nb/2*20000);
	if ($cond == "ressources")	$val = max($val, $nb/2*5);

	return array($cond, $val);
}

function returndate ($timestamp)
{
	$mois = getMois(gmdate('F', $timestamp));
	$jour = gmdate('d', $timestamp);
	$heure = gmdate('H:i', $timestamp);
	$date = $jour.' '.$mois.', '.$heure;
	return $date;
}




// dire qu'un joueur est "banni" d'une guerre pour avoir quitté sa guilde au milieu d'une guerre
function etablirtraitre ($nom, $guilde)
{
	global $TYPE_GUERRE, $TYPE_PNA, $VALIDE_EN_COURS, $VALIDE_EN_ATTENTE, $VALIDE_EN_NEGOCIA, $VALIDE_BLOQUE, $VALIDE_TERMINE;
	
	// boucle sur guilde1 et guilde2
	for ($i=1; $i<=2; $i++)
	{
		$sql = "SELECT id, `leaver$i`, `guilde".(3-$i)."` FROM guerres
			WHERE		type = '$TYPE_GUERRE' AND cache = '0' AND ( valide = '$VALIDE_EN_COURS' OR valide = '$VALIDE_EN_ATTENTE' OR valide = '$VALIDE_EN_NEGOCIA' )
				AND 	`guilde$i` = '$guilde'";
		$req = mysql_query($sql) or die('Erreur SQL !<br>'.mysql_error());
		while ($data = mysql_fetch_row($req))
		{
			$id	= $data[0];
			$leaver	= $data[1];
			$ennemi	= $data[2];
			
			$leaver .= '|'.$nom.'|';
			$leaver = str_replace('||', '|', $leaver);
			
			$sq1 = "UPDATE guerres SET `leaver$i` = '$leaver' WHERE `id` = '$id'";
			$re1 = mysql_query($sq1) or die('Erreur SQL !<br>'.$sq1.'<br>'.mysql_error());
			echo $nom.' a été déclaré traître dans la guerre qui oppose '.$guilde.' à '.$ennemi.'.<br>';
		}
	}
}


// savoir si une guilde est actuellement en guerre
function estenguerre ($guilde)
{
	global $TYPE_GUERRE, $TYPE_PNA, $VALIDE_EN_COURS, $VALIDE_EN_ATTENTE, $VALIDE_EN_NEGOCIA, $VALIDE_BLOQUE, $VALIDE_TERMINE;
	
	$sql = "SELECT id FROM guerres
		WHERE		type = '$TYPE_GUERRE' AND cache = '0'
			AND (	`guilde1` = '$guilde' OR `guilde2` = '$guilde' )
			AND (	valide = '$VALIDE_EN_COURS' OR valide = '$VALIDE_EN_ATTENTE' OR valide = '$VALIDE_EN_NEGOCIA' )";
	$req = mysql_query($sql) or die('Erreur SQL !<br>'.mysql_error());
	$nbr = mysql_num_rows($req);
	if ($nbr != 0)
		return true;
	return false;
}

// si un guilde perd un membre et a donc 4 ou moins membres --> elle perd immédiatement TOUTES ses guerres
function perdreguerrepoureffectif ($guilde)
{
	// s'utilise pour: sortie d'armada / ban d'armada / delete de compte / resets
	global $nbrmindeclar;
	
	$sql = "SELECT nb_membres FROM `guildes` WHERE nom = '$guilde'";
	$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
	if ($data = mysql_fetch_row($req))
	{
		if ($data[0] < $nbrmindeclar)
		{
			// plus assez de membres: perd toutes ses guerres!!!
			global $TYPE_GUERRE, $TYPE_PNA, $VALIDE_EN_COURS, $VALIDE_EN_ATTENTE, $VALIDE_EN_NEGOCIA, $VALIDE_BLOQUE, $VALIDE_TERMINE;
			// guerres en tant qu'attaquant
			$sq1 = "SELECT id, guilde2 FROM guerres
				WHERE	type = '$TYPE_GUERRE' AND cache = '0' AND `guilde1` = '$guilde'
					AND (	valide = '$VALIDE_EN_COURS' OR valide = '$VALIDE_EN_ATTENTE' OR valide = '$VALIDE_EN_NEGOCIA' )";
			$re1 = mysql_query($sq1) or die('Erreur SQL !<br>'.mysql_error());
			while ($dat1 = mysql_fetch_row($re1))
			{
				$id = $dat1[0];
				$guilde2 = $dat1[1];
				termineguerre ($id, $guilde2, true);
			}
			// guerres en tant que défenseur
			$sq1 = "SELECT id, guilde1 FROM guerres
				WHERE	type = '$TYPE_GUERRE' AND cache = '0' AND `guilde2` = '$guilde'
					AND (	valide = '$VALIDE_EN_COURS' OR valide = '$VALIDE_EN_ATTENTE' OR valide = '$VALIDE_EN_NEGOCIA' )";
			$re1 = mysql_query($sq1) or die('Erreur SQL !<br>'.mysql_error());
			while ($dat1 = mysql_fetch_row($re1))
			{
				$id = $dat1[0];
				$guilde1 = $dat1[1];
				termineguerre ($id, $guilde1, true);
			}
		}
	}
}


// message d'évènement sur la page d'accueil
function ajouteEvenement ($texte)
{
	$temps = floor(time()/60);
	$sql = "INSERT INTO `evenement` ( `id` , `titre` , `texte` , `tempsdelete`, `tempspost` )
		VALUES ('', 'Guerres et PNA', '$texte', '".($temps+1440*1.5)."', '$temps')";
	$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
}

?>