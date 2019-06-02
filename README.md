## Credits

Front-End: Unknown. Please contact me and I'll add your name.<br />
Back-End: Amanda Szampias.<br />
Database: Amanda Szampias.<br />

## Easy Install

I made an OVF file. It's available here: https://drive.google.com/open?id=1ICgas5IwjjsELe5dYljyebAJqihPX0j6

You can import this into VMWare or Virtualbox. Type in "localhost" into the browser and the website will appear. I did some basic security steps on this box which are documented in notes/QADocument.docx

<b>Ubuntu 18.04LTS:</b><br />
Username: aszampias<br />
Password: toor<br /><br />

<b>MySQL:</b><br />
Username: ise<br />
Password: password<br /><br />

## Install Yourself
Follow these commands. I used these for Ubuntu 18.04LTS.
<b>Ubuntu</b>
$ apt-get update<br />
$ apt-get upgrade<br />
$ apt-get install apache2<br />
$ apt-get install mysql-server<br />
$ apt-get install php<br />
$ apt install git<br />
$ apt install vim<br />
$ sudo apt-get install php7.2-gd<br />
$ sudo apt-get install php7.2-mbstring<br />
$ sudo apt-get install php-mysqli<br />
$/var/www/html/ git clone https://github.com/ASzampiasSWD/CCDC-InjectScoringEngine.git<br />
$/var/www/html/injectscoringengine: sudo apt install composer<br />
$/var/www/html/injectscoringengine: composer require mpdf/mpdf<br />
chmod -R 777 uploads/ (Note: mkdir() won’t work if uploads isn’t 777. I tried 766 and no work).<br />
chmod -R 777 vendor/<br />
chmod -R 777 CCDC_Injects/<br /><br />

<b>MySQL:</b><br />
sudo mysql -u root<br />
COPY ALL OF notes/tablenotes.sql and PASTE into mysql command line. This will create ALL the tables needed.<br /> 
INSERT INTO Category VALUES ('0', 'ISE Manager Admin', 'Fri, 31 May 2019 18:07:50 -0400', 'Fri, 31 May 2019 19:07:50 -0400', 0);<br />
INSERT INTO Team (group_id, team_name, team_password, team_score, creation_date)  VALUES('0', 'Amanda', 'duck', 0, 'Fri, 31 May 2019 19:07:50 -0400');<br />
CREATE USER 'ise'@'localhost' IDENTIFIED BY 'password';<br />
GRANT ALL PRIVILEGES ON *.* TO 'ise'@'localhost';<br />
FLUSH PRIVILEGES;<br /><br />

<b>Ubuntu:</b>
service mysql restart<br />
service apache2 restart<br />
Go to line 63 in functions.php and change path of config.ini. You should get an error about this when you first login.<br />
Go into /var/www/html/CCDC-InjectScoringEngine/config.ini and change username and password to ‘ise’ and ‘password’. (whatever you used).<br />


## More Info
Youtube Video: https://www.youtube.com/watch?v=YvPWPr0O0Dc<br />
BlogPost: http://amandaszampias.blogspot.com/2019/06/release-of-ccdc-ise-manager-website.html<br />
Questions, Features, and Bugs: Contact me. Email or LinkedIn is best.<br />
