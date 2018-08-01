
echo "[******] Copying and enable virtualhost 'site.conf'";
cp /var/www/salic-web/docker/salic-web/actions/apache2/sites-available/site.conf /etc/apache2/sites-available/site.conf

echo "[******] Copying configurations for security of apache.";
cp /var/www/salic-web/docker/salic-web/actions/apache2/conf-available/security.conf /etc/apache2/conf-available/security.conf

a2ensite site.conf

echo "[******] Disable default virtualhost '000-default.conf'";
a2dissite 000-default.conf

echo "[******] Enable Apache Mod Rewrite";
a2enmod rewrite

echo "[******] Enable Apache Mod Headers";
a2enmod headers