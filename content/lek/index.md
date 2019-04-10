Test och lek
===========================

Detta innehåll är skrivet i markdown och du hittar innehållet i filen `content/lek/index.md`.

Tanken är att du kan ha en samlingssida där du kan länka till egna testsidor och testroutes, inom eller utom din me-sida.



Testssida i `content/` {#ts}
---------------------------

Här är en sida `content/lek/markdown.md`, bara för att visa hur du länkar till den och når den via `lek/markdown`.

* [Testsida `lek/markdown`](lek/markdown)


Ytterligare en testsida i `content/` {#ts}
---------------------------

Här är ytterligare en sida ,`content/lek/markdown2.md`, bara för att testa att det verkligen fungerar. Sidan nås via `lek/markdown2`.

* [Testsida `lek/markdown2`](lek/markdown2)



Testroute {#te}
---------------------------

Du kan skriva egna routes i filen `router/000_lek.php`, där finns några enklare routehanterare som du kan utgå ifrån när du bygger dina egna.

* [Hello world (utanför me-sidan)](lek/hello-world)
* [Hello world som JSON](lek/hello-world-json)
* [Hello world (inuti me-sidan)](lek/hello-world-page)
* [Länk till en testsida](lek/test-page)

Du kan även skapa nya filer under `router/`, de läses in i ordning.



Ytterligare en testroute {#te}
---------------------------

Då ska vi se om det fungerar att lägga till routes...

* [Länk till en testsida via routern](lek/test-page)



Testfiler {#tf}
---------------------------

Du kan också lägga till vanlig PHP-kod i filer under katalogen `htdocs/`, de kan du köra som vanliga PHP-program och du länkar direkt till dem.

* [Ett demo skript](demo/demo.php)
* [PHP info, detaljer om installationen](demo/phpinfo.php)



Ytterligare en testfil {#tf}
---------------------------

Vi testar att lägga in spelet "Guess my number" i `htdocs/demo/guess/index.php` och länka till det.

* [Guess my number](demo/guess/index.php)
