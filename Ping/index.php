<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ping</title>
	<style>
		body{
			background: #FAFAFA;
			font-family: arial;
			margin: 0;
		}
		h1{
			background: #09C;
			color: #FFF;
			padding: 20px;
			margin: 0;
		}
		main{
			padding: 20px;
		}
		div{
			margin: 4px;
			padding: 10px;
			border-radius: 10px;
			border: 1px solid #AAA;
			background: #FFF;
		}
		span{
			font-weight: bold;
		}
	</style>
</head>
<body>
	<h1>Tester toutes les extention d'un nom de domaine</h1>
	<main>
		<form>
			<input type="text" value="disneyhd" placeholder="Nom de domaine sans l'extention">
			<input type="submit" value="Tester">
		</form>
	</main>
	
	<script>

		var limite = 1200; // Limite du nombre de fetch en même temps.

		var json = <?php include('tld-list.json'); ?>;
		var main = document.querySelector("main");

		var jsonLength = json.length;
		var cpt = 0;
		var nom = "";

		document.querySelector("form").addEventListener("submit", go);
		function go(){
			event.preventDefault();
			nom = document.querySelector("input[type=text]").value;
			while(limite > 0 && cpt < jsonLength){
				doFetch(nom+"."+json[cpt++]);
				limite--;
			}
		}
		

		function doFetch(nom){
		/* Créer une div pour montrer qu'on traite cette requête */
			let d = document.createElement("div");
			d.innerHTML = nom;
			main.appendChild(d);
		
		/* Envoyer la requête */
			fetch("testIP.php?nom="+nom, {cache: "no-cache"})
				.then(r=>{return r.text()})
				.then(t=>{
				/* Traiter la réponse */
					if(t != -1){
						d.innerHTML = t;
					}else{
						d.remove();
					}

				/* Relancer des requêtes s'il en reste */
					limite ++;
					if(limite > 0 && cpt < jsonLength){
						doFetch(nom+"."+json[cpt++]);
						limite--;
					}
				});
		}
	</script>
</body>
</html>
