Ajaxový upload obrázků za pomocí Nette
=============

Obrázky se ukládají do databáze pomocí Doctrine2. Pokud obrázek obsahuje v exif datech GPS souřadnice, ty budou vytaženy a uloženy do DB k obrázku.

Pokud obrázek obsahuje GPS souřadnice, bude obrázek vykreslený taky v Google mapě.

Instalace
----------

- CMD -> cd "složka na kterou mám nalinkované Apache" -> git clone https://github.com/blikacka/netteImageUploader.git
- Upravit config.neon pro připojení k databázi
- CMD -> cd "složka se staženým obsahem" -> composer install -> viz https://getcomposer.org/download/
- CMD vygenerování DB -> cd www -> php index.php orm:schema-tool:create -> viz  http://doctrine-orm.readthedocs.io/projects/doctrine-orm/en/latest/reference/tools.html#command-overview
- Smazat složku (celou) cache a btfj.dat umístěné v temp
- Hotovo

License
-------
- @author Jakub Cieciala <jakub.cieciala@gmail.com>
- Nette: New BSD License or GPL 2.0 or 3.0 (https://nette.org/license)
- Adminer: Apache License 2.0 or GPL 2 (https://www.adminer.org)

