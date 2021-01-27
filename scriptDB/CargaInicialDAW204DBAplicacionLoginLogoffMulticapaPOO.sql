-- La contraseña de los usuarios, es el codUsuario concatenado con el password, en este caso paso. [$usuario . $pass]
-- Base de datos a usar
USE DAW204DB_API_REST;

-- Inserta el codigo de usuario y su contraseña
INSERT INTO Usuario VALUES
    ('nereaa',SHA2('nereaapaso',256)),
    ('miguel',SHA2('miguelpaso',256)),
    ('bea',SHA2('beapaso',256)),
    ('nerean',SHA2('nereanpaso',256)),
    ('cristinam',SHA2('cristinampaso',256)),
    ('susana',SHA2('susanapaso',256)),
    ('sonia',SHA2('soniapaso',256)),
    ('elena',SHA2('elenapaso',256)),
    ('nacho',SHA2('nachopaso',256)),
    ('raul',SHA2('raulpaso',256)),
    ('luis',SHA2('luispaso',256)),
    ('arkaitz',SHA2('arkaitzpaso',256)),
    ('rodrigo',SHA2('rodrigopaso',256)),
    ('javier',SHA2('javierpaso',256)),
    ('cristinan',SHA2('cristinanpaso',256)),
    ('heraclio',SHA2('heracliopaso',256)),
    ('amor',SHA2('amorpaso',256)),
    ('antonio',SHA2('antoniopaso',256)),
    ('leticia',SHA2('leticiapaso',256));

