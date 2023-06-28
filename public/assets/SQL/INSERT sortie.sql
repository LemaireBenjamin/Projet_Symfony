INSERT INTO `status` (`id`, `status_no`, `status_label`)
VALUES (1, 1, 'Créée'),
       (2, 2, 'Ouverte'),
       (3, 3, 'Clôturée'),
       (4, 4, 'En cours'),
       (5, 5, 'Passée'),
       (6, 6, 'Annulée');

INSERT INTO `site` (`id`, `site_no`, `site_name`)
VALUES (1, 1, 'Nantes'),
       (2, 2, 'Quimper'),
       (3, 3, 'Rennes'),
       (4, 4, 'Niort');

INSERT INTO `city` (`id`, `city_no`, `city_name`, `zipcode`)
VALUES (1, 1, 'Nantes', '44000'),
       (2, 2, 'Quimper', '29000'),
       (3, 3, 'Rennes', '35000'),
       (4, 4, 'Niort', '79000'),
       (5, 5, 'Concarneau', '29900');

INSERT INTO `participant` (`id`, `lastname`, `firstname`, `phone`, `organiser`, `active`)
VALUES (1, 'MEUNIER', 'Bertrand', '0664826290', 1, 1),
       (2, 'LE MAIRE ', 'Benjamin', '0651269584', 1, 1),
       (3, 'SONZIA TEUTSONG', 'Marie-Audrey', '0625176054', 1, 1),
       (4, 'DANIEL', 'Sylvain', '0759401532', 0, 1),
       (5, 'ENNEB', 'Hadhemi', '0648539865', 0, 1),
       (6, 'GAONACH', 'Tiphaine', '0751643258', 0, 1),
       (7, 'GLIPPA', 'Sébastien', '0685931245', 0, 1),
       (8, 'LAGADEC', 'Robin', '0759842635', 0, 1),
       (9, 'LE GOFF', 'François', '0684521548', 1, 1),
       (10, 'FONSAT', 'Dimitri', '0658413278', 1, 1),
       (11, 'CLOAREC', 'David', '0652964185', 0, 1),
       (12, 'POULMARCH', 'Ken', '0741586312', 0, 1),
       (13, 'JULIEN', 'Maïwenn', '0685413695', 0, 1),
       (14, 'CHIRON', 'Sebastien', '0678561245', 0, 1),
       (15, 'CAROFF', 'Gautier', '0645953215', 0, 1),
       (16, 'PRIGENT', 'Quentin', '0789653254', 1, 1);

INSERT INTO `place` (`id`, `place_id`, `place_name`, `place_street`, `latitude`, `longitude`, `city_id`)
VALUES (1, 1, 'Cinéville', 'Rue Marie de Kerstrat', NULL, NULL, 2),
       (2, 2, 'Aqua Plouf', '159 boulevard de Creac\'h Gwen', NULL, NULL, 2),
       (3, 3, 'Quai West', '30 quai Fernand Crouan', NULL, NULL, 1),
       (4, 4, 'V&B', '52 avenue De Keradennec', NULL, NULL, 2);

INSERT INTO `activity` (`id`, `name`, `start_date`, `duration`, `end_date`, `max_inscriptions`, `description`,
                        `activity_status`, `picture_url`, `organizer_id`, `site_id`, `place_id`, `status_id`)
VALUES (1, 'Cinéma', '2023-06-30 15:00:00', 180, '2023-06-30 18:00:00', 15, 'Film : Mais qui à tué Pamela Rose', 1,
        NULL, 1, 2, 1, 1);

INSERT INTO `participant_activity` (`participant_id`, `activity_id`)
VALUES (1, 1),
       (2, 1),
       (4, 1),
       (9, 1);









