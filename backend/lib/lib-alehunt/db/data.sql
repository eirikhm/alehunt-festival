
INSERT INTO `beer_type` VALUES (1,'Ale',NULL),
                               (2,'Lager',NULL),
                               (3,'Pale Ale',1),
                               (4,'India Pale Ale',1),
                               (5,'Stout',1),
                               (6,'Porter',1),
                               (7,'Bitter',1),
                               (8,'Steamer',1)
;


INSERT INTO `brewer` VALUES (1,'Nøgne Ø',NULL,NULL,'NO'),
                            (2,'Kinn',NULL,NULL,'NO'),
                            (3,'Ægir',NULL,NULL,'NO'),
                            (4,'Brewdog',NULL,NULL,'NO'),
                            (5,'Flying Dog',NULL,NULL,'US'),
                            (6,'Slogen',NULL,NULL,'NO'),
                            (7,'Meantime',NULL,NULL,'GB')
;





INSERT INTO `beer` VALUES (1,'IPA',NULL,1,4,NULL),
                          (2,'Imperial Stout',NULL,1,5,NULL),
                          (3,'Pale Ale',NULL,1,3,NULL),
                          (4,'Punk IPA',NULL,4,4,NULL),
                          (5,'Hardcore IPA',NULL,4,4,NULL),
                          (6,'Nanny State',NULL,4,7,NULL),
                          (7,'Alpha Dog',NULL,4,3,NULL),
                          (8,'5 AM Saint',NULL,4,3,NULL),
                          (9,'Rip tide',NULL,4,5,NULL)
;


INSERT INTO `venue` VALUES (1,'Schouskjelleren',NULL,NULL,'NO'),
                           (2,'Grünerløkka Brygghus',NULL,NULL,'NO'),
                           (3,'Olympen',NULL,NULL,'NO'),
                           (4,'Haandverkerstuene',NULL,NULL,'NO'),
                           (5,'Tilt',NULL,NULL,'NO'),
                           (6,'Nighthawk Diner',NULL,NULL,'NO'),
                           (7,'Bar & Cigar',NULL,NULL,'NO');





INSERT INTO `venue_beer` VALUES (1,1,1,1,NOW(),NOW()),
                                (2,1,2,2,NOW(),NOW()),
                                (3,1,3,2,NOW(),NOW()),
                                (4,2,1,3,NOW(),NOW()),
                                (5,2,3,1,NOW(),NOW()),

                                (6,2,1,1,NOW(),NOW()),
                                (7,2,2,2,NOW(),NOW()),
                                (8,2,3,2,NOW(),NOW()),
                                (9,2,4,2,NOW(),NOW()),
                                (10,2,5,3,NOW(),NOW()),
                                (11,2,6,3,NOW(),NOW()),
                                (12,2,7,1,NOW(),NOW()),
                                (13,2,8,1,NOW(),NOW()),

                                (15,3,1,3,NOW(),NOW()),
                                (16,3,2,3,NOW(),NOW()),
                                (17,3,3,3,NOW(),NOW()),
                                (18,3,4,2,NOW(),NOW()),
                                (19,3,5,2,NOW(),NOW()),
                                (20,3,6,2,NOW(),NOW()),
                                (21,3,7,1,NOW(),NOW()),
                                (22,3,8,1,NOW(),NOW()),

                                (24,4,1,1,NOW(),NOW()),
                                (25,4,2,4,NOW(),NOW()),
                                (26,4,3,4,NOW(),NOW()),
                                (27,4,4,4,NOW(),NOW()),
                                (28,4,5,2,NOW(),NOW()),
                                (29,4,6,3,NOW(),NOW()),
                                (30,4,7,1,NOW(),NOW()),
                                (31,4,8,1,NOW(),NOW())
                                ;


                                CREATE TABLE `city` (
                                  `id` int(11) NOT NULL AUTO_INCREMENT,
                                  `name` varchar(255) NOT NULL,
                                  `code_name` int(11) DEFAULT NULL,
                                  `country_id` char(2) DEFAULT NULL,
                                  PRIMARY KEY (`id`),
                                  CONSTRAINT `city_ref_country` FOREIGN KEY (`country_id`) REFERENCES `country` (`iso`)
                                ) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT into city (name,code_name,country_id) VALUES ('Oslo','oslo','NO');
INSERT into city (name,code_name,country_id) VALUES ('Bergen','bergen','NO');
INSERT into city (name,code_name,country_id) VALUES ('Trondheim','trondheim','NO');
INSERT into city (name,code_name,country_id) VALUES ('Stavanger','stavanger','NO');