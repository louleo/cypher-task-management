# Cypher Development Environment Setup  
1. `git clone` this repo.
2. `docker pull louleo/cypher:latest`.
3. `docker run -d -p 8082:8080 -p 3307:3306 -v repo_folder/cypher:/var/www/cypher --restart always --name cypher louleo/cypher:latest /start.sh`
4. `docker exec -it cypher bash`
5. `cd /var/www/cypher && composer install && php yii migrate`



# Cypher Docker Setup
1. Run docker base image Ubuntu 18.04
2. `docker run -it ubuntu bash`
3. `apt-get update && apt-get upgrade`
4. `apt-get install apache2`
5. `apt-get install mariadb-server`
6. `apt-get install php7.2`
7. `apt install curl php-cli php-mbstring git unzip`
8. `cd ~ && curl -sS https://getcomposer.org/installer -o composer-setup.php`
9. `php composer-setup.php --install-dir=/usr/local/bin --filename=composer`
10. `service apache2 start`
11. `service mysql start`
12. `mysql -u root -p`
13. `CREATE USER cypher IDENTIFIED BY 'cypher';`
14. `CREATE DATABASE cyper;`
15. `GRANT ALL PRIVILEGES ON cypher.* TO cypher;`
16. `FLUSH PRIVILEGES；`
17. Change the apache2 server virtual host file and port.conf. Create start.sh file and then `chmod +x start.sh`
18. Configure MariaDB conf, `vi /etc/mysql/my.cnf` and add `[mysqld] --skip-networking=0 --skip-bind-address` to allow user to access docker mysql database through tcp protocol.
Ref: https://mariadb.com/kb/en/library/configuring-mariadb-for-remote-client-access/

# Cypher Deployment Setup
