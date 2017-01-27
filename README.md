Ukljucite fajl sqlfile.sql u vasu bazu, bazu nazovite kako hocete i u application/config/database.php konfigurisite ime baze.


Koristite POSTMAN za testiranje aplikacije.

U svaki header je potrebno ukljuciti'Content-Type','Client-Service' i 'Auth-Key' sa vrednostima 'application/json','frontend-client' i 'fsdprojekat'.


Izlistavanje svih knjiga :

[GET] /book 

Search:

[GET] /book?search=knjizurda


Registracija:

[POST] /auth/register u body ide '{"username" : "ime", "password": "vasalozinka"} '

Login- dodaje kolonu u users_authentication tabelu i dodeljuje user_id i token. :

[POST] /auth/login json { "username" : "ime", "password" : "vasalozinka"}

Sada u responsu u json formatu dobijate user_id i token koje dalje ukljucujete u header kao 'User-ID' i 'Authorization'.


Pravljenje nove knjige:


[POST] /book/create json { "naziv" : "x", "autor" : "xx", "godina" : "xxxx", "jezik" : "xxx", "originalni jezik" : "xxx"}

Azuriranje knjige(potrebno je proslediti id odredjene knjige).

[PUT] /book/update/:id json { "naziv" : "y", "autor" : "yy"}

Brisanje odredjene knjige:

[DELETE] /book/delete/:id


Logout- brise kolonu iz users_authentication kolone. Naravno u headeru je potrebno proslediti 'User-ID' i 'Authorization'.

[POST] /auth/logout
