INSERT INTO `factions` (
`id`,
`faction_name`,
`description`
) VALUES (
1,
'MORDOR',
'Mordor es un país situado al sureste de la Tierra Media, que tuvo gran importancia durante la Guerra del Anillo por ser el lugar donde Sauron, el Señor Oscuro, decidió edificar su fortaleza de Barad-dûr para intentar atacar y dominar a todos los pueblos de la Tierra Media.'
);

INSERT INTO `equipments` (
`id`,
`name`,
`type`,
`made_by`
) VALUES (
1,
'Maza de Sauron',
'arma',
'desconocido'
);

INSERT INTO `characters` (
`id`,
`name`,
`birth_date`,
`kingdom`,
`equipment_id`,
`faction_id`
) VALUES (
1,
'SAURON',
'3019-03-25',
'AINUR',
1,
1
);

INSERT INTO `users` (
`id`,
`user_name`,
`user_password`
) VALUES (
1,
'admin',
'1f3d38abc5b698ad3c95341edefeb469'
);