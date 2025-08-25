## 1. Créer une base de donnée en local avec PhpMyAdmin

Commande à potentiellement exécuter avec le PowerShell en mode admin

## 2. Installer le core de wordpress ainsi que les plugins

`wp core download --path=wp-root --locale=fr_FR`<br><br>
`cd ./wp-root; wp core config --dbname=francelink --dbuser=root --dbpass=root --dbhost=127.0.0.1:8889 --dbprefix=wp_ --locale=fr_FR; wp core install --url="http://localhost/francelink/wp-root" --title="Francelink" --admin_user="admin" --admin_password="admin" --admin_email="maintenance@francelink.fr"; wp plugin install ewww-image-optimizer fluent-smtp wordpress-seo safe-svg contact-form-7 --activate `

## 3. Créer un lien symbolique

Quitter le Powershell et faire ces manip avec cmd.exe en mode admin

MacOs :
`ln -s /Users/Sylvain1/www/AuraBio/wp-content/themes/contentify/ /Users/Sylvain1/www/AuraBio/wp-root/wp-content/themes/contentify`

Windows :
`mklink /D "D:\www\francelink\wp-root\wp-content\themes\contentify" "D:\www\francelink\wp-content\themes\contentify"`
`mklink /D "D:\www\francelink\wp-root\wp-content\plugins\acf_content_generator" "D:\www\francelink\wp-content\plugins\acf_content_generator"`

## 4. Configurer le thème

`wp theme activate contentify; cd ../wp-content/themes/contentify; npm install; npm run prod`

Dans le thème, dupliquer ".env.sample" et renommer en ".env", renseigner l'url local du projet.<br>
Ex: `LOCAL_CONFIG="localhost:8888/francelink/wp-root/"`

À partir de là, on peut travailler en local synchronisé avec `npm run dev`

