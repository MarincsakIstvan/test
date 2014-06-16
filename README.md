Rest Test alkalmazás
====================

Ez az alkalmazás a FOS REST bundle segítségével készült és robotokat tart nyilván.
1) Telepítés
Git checkout után command line-ban:

    curl -sS https://getcomposer.org/installer | php -- --install-dir=bin

    php composer.phar install

2) Adatbázis létrehozása
Az alkalmazásnak szüksége van egy adatbázisra, ami az én esetemben ezt a nevet kapta:
`mi_api`. Ezt például phpMyAdmin segítségével is létre lehet hozni.

3) Táblák létrehozása
Az alkalmazás 2 adatbázis táblát használ. Ezek létrehozásához `app/console`-ban futtatni kell egy
`doctrine:schema:create` parancsot.

4) Használat
Ahhoz, hogy használni lehessen az alkamazást, a `type` táblába fel kell venni néhány "robot típust".
Ezek tetszőleges stringek lehetnek, a pk-juk automatikusan növekszik, így nem szükséges a
kitöltésük.

5) Elérhető api hívások
Az elérhető api hívások a [**RobotController**][1] osztályban találhatóak.


[1]:  https://github.com/MarincsakIstvan/test/blob/master/src/MarincsakIstvan/ApiBundle/Controller/RobotController.php