## Easy Install

I made an OVF file. It's available here: https://drive.google.com/open?id=1ICgas5IwjjsELe5dYljyebAJqihPX0j6

You can import this into VMWare or Virtualbox. Type in "localhost" into the browser and the website will appear. I did some basic security steps on this box which are documented in notes/QADocument.docx

<b>Ubuntu 18.04LTS:<b><br />
Username: aszampias<br />
Password: toor<br /><br />

<b>MySQL:</b><br />
Username: ise<br />
Password: password<br /><br />

## Install Yourself
Follow these commands. I used these for Ubuntu 18.04LTS.
<code>
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
chmod -R 777 CCDC_Injects/<br />
</code>
