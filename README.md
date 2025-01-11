Ein Weg Um Bücher zu verwalten!



Resourcen:
  php, php-mysql, mariadb, apache2

Mariadb einrichten:

	sudo mysql_secure_installation
		
1. Frage: "Dein Mariadb root Passwd."
2. Frage: No
3. Frage: No
4. Frage: Yes
5. Frage: Yes
6. Frage: Yes
7. Frage: Yes


Mariadb DB erstellen:
	
	sudo mysql -u root -p:

1. Frage: "Passwort von eben" 		

		CREATE DATABASE <Name>;
		CREATE USER '<User>'@'localhost' IDENTIFIED BY
    		'<Passwort>';	
		GRANT ALL PRIVILEGES ON <Name>.* TO '<User-Name>'@'localhost';
		USE <Name>;
		CREATE TABLE mediums (Autor VARCHAR(100), Title
    		VARCHAR(100), Standort
    		VARCHAR(100));
		FLUSH PRIVILEGES;
		EXIT;



Apache2 konfig:

	sudo nano /etc/apache2/sites-available/<Name>.conf:

	<VirtualHost *:80>
    		ServerAdmin webmaster@localhost
    		DocumentRoot /var/www/html/<Name>

    		<Directory /var/www/html/<Name>>
       			Require all granted
        		AllowOverride All
        		Options FollowSymLinks MultiViews
        		<IfModule mod_dav.c>
            			Dav off
        		</IfModule>
    		</Directory>
    		ErrorLog ${APACHE_LOG_DIR}/error.log
    		CustomLog ${APACHE_LOG_DIR}/access.log combined
	</VirtualHost>


Konfig Updaten:

	sudo a2ensite <Name>
	sudo a2enmod rewrite headers env dir mime
	sudo systemctl restart apache2
