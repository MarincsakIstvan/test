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

 * Egy robot elkérése @GET("/robots/{id}")

 * Robot létrehozása @Post("/robot")

    {
        "name": "qqq",
        "type": "qqq",
        "year": "1999"
    }

 * Robot update @Put("/robots/{id}")

    {
        "name": "qqq1",
        "type": "qqq1",
        "year": "1999"
    }

 * Robot törlés (LOGIKAI törlés - GEDMO extension) @Delete("/robots/{id}")

 * Összes robot elkérése @GET("/robots")

 * Robot keresése név alapján @GET("/robots/search/{name}")

 * Összes robot type kíírása @GET("/robots/filter")

 * Robotok szűrése type neve alapján @GET("/robots/filter/{name}")


Automatikusan kezelve van a createdAt, updatedAt, valamint csak logikai törlés van a robot-okon.


[1]:  https://github.com/MarincsakIstvan/test/blob/master/src/MarincsakIstvan/ApiBundle/Controller/RobotController.php