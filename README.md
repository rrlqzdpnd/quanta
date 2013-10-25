# quanta
Online reviewer for college entrance tests in the Philippines (UPCAT, ACET, DLSUCET, etc.)

### To do:
#### Admin
+ Finish ManageQuestions module
+ Add a WYSIWYG editor in Announcements module
+ More features for the ManageUsers module

#### User
+ More detailed statistics page

-----

### Quanta?
(from [Wikipedia][0]) In physics, a __quantum__ (plural: __quanta__) is the minimum amount of any physical entity involved in an interaction.

### Team Members
+ Acezon Cay
+ Errol Pineda
+ Jadurani Davalos
+ Jeru Mercado
+ Kiefer Yap

### Specs
+ __Front-end__: Twitter Bootstrap 3
+ __Back-end__: CodeIgniter 2.1

### How to install
1.  Install [WAMP][1], [XAMPP][2], or [Apache][3] on your local machine.
    I would suggest you install XAMPP because of the ease of installing.
2.  Install [PostgreSQL][4] with following credentials:
    * username: __postgres__
    * password: any password you wish
3.  Clone this repository:
    * go to the working directories:
        * www/ in WAMP
        * html/ in Apache
        * htdocs/ in XAMMP
    * create a folder inside the directory: `mkdir <folder name>`
    * clone this git using:
        `git clone https://github.com/itsacezon/quanta.git ./<name of created folder>`
4.  Configure the database in `./applications/config/database.php`
5.  Update database by running these in order:
	* `useranswerssupport.sql`
	* `newscripts.sql`

  [0]: http://en.wikipedia.org/wiki/Quantum "Wikipedia"
  [1]: http://www.wampserver.com/en/#download-wrapper "WAMPP"
  [2]: http://www.apachefriends.org/en/xampp.html "XAMPP"
  [3]: http://httpd.apache.org/download.cgi "Apache"
  [4]: http://www.postgresql.org/download/  "PostgreSQL"



