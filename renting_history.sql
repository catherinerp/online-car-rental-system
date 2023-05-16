CREATE DATABASE assignment2;
use assignment2;

-- ----------------------------
-- Table structure for renting history
-- ----------------------------
DROP TABLE IF EXISTS `renting_history`;
CREATE TABLE `renting_history` (
  `rent_id` int(10) unsigned DEFAULT NULL,
  `car_id` int(10) unsigned DEFAULT NULL,
  `user_email` varchar(50) DEFAULT NULL,
  `rent_date` date DEFAULT NULL,
  `rent_days` int(10) unsigned DEFAULT NULL,
  `bond_amount` float(8,2) unsigned DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of renting history
-- ----------------------------
BEGIN;
INSERT INTO `renting_history` VALUES (1000, 001, 'username@gmail.com', '2022/10/05', 10, 1500);
INSERT INTO `renting_history` VALUES (1001, 003, 'person@hotmail.com', '2022/12/02', 4, 750);
INSERT INTO `renting_history` VALUES (1002, 013, 'johnsmith@yahoo.com', '2023/01/23', 5, 500);
INSERT INTO `renting_history` VALUES (1003, 008, 'janedoe101@gmail.com', '2023/02/01', 6, 750);
INSERT INTO `renting_history` VALUES (1004, 012, 'johndoe@yahoo.com', '2023/04/15', 8, 1000);
INSERT INTO `renting_history` VALUES (1005, 007, 'alice123@gmail.com', '2023/05/01', 4, 500);
INSERT INTO `renting_history` VALUES (1006, 001, 'bobsmith@hotmail.com', '2023/06/10', 9, 1500);
INSERT INTO `renting_history` VALUES (1007, 004, 'susanmiller@gmail.com', '2023/07/03', 5, 750);
INSERT INTO `renting_history` VALUES (1008, 009, 'johndoe456@gmail.com', '2023/08/22', 5, 500);
INSERT INTO `renting_history` VALUES (1009, 011, 'janedoe789@hotmail.com', '2023/09/12', 10, 1000);


COMMIT;
