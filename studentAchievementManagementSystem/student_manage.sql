SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for academy
-- ----------------------------
DROP TABLE IF EXISTS `academy`;
CREATE TABLE `academy` (
                           `id` int(11) NOT NULL AUTO_INCREMENT,
                           `academy_no` varchar(25) CHARACTER SET utf8 NOT NULL,
                           `name` varchar(25) CHARACTER SET utf8 NOT NULL,
                           `address` varchar(255) CHARACTER SET utf8 NOT NULL,
                           PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of academy
-- ----------------------------
INSERT INTO `academy` VALUES ('1', '9656AD21', 'College of Information Science and Technology', 'Building 5, University of Science and Technology');
INSERT INTO `academy` VALUES ('2', '9651AD23', 'College of Mathematics', 'Building 1, University of Science and Technology');
INSERT INTO `academy` VALUES ('3', '9585AD22', 'College of Mechanical Engineering', 'Building 2, University of Science and Technology');
INSERT INTO `academy` VALUES ('4', '9685AD21', 'College of Materials Science and Engineering', 'Building 3, University of Science and Technology');
INSERT INTO `academy` VALUES ('5', '9696AD12', 'Law School', 'Building 4, University of Science and Technology');
INSERT INTO `academy` VALUES ('6', '8541AD21', 'College of Energy and Power Engineering', 'Building 6, University of Science and Technology');
INSERT INTO `academy` VALUES ('7', '9652AD21', 'School of Stomatology', 'Building 7, University of Science and Technology');
INSERT INTO `academy` VALUES ('8', '9876AD25', 'School of Management', 'Building 8, University of Science and Technology');
INSERT INTO `academy` VALUES ('9', '9956AD23', 'Institute of Environmental Studies', 'Building 9, University of Science and Technology');
INSERT INTO `academy` VALUES ('10', '8796AD21', 'School of Control Science and Engineering', 'Building 10, University of Science and Technology');

-- ----------------------------
-- Table structure for bulletin
-- ----------------------------
DROP TABLE IF EXISTS `bulletin`;
CREATE TABLE `bulletin` (
                            `id` int(11) NOT NULL AUTO_INCREMENT,
                            `time` datetime NOT NULL,
                            `content` varchar(255) NOT NULL,
                            `publisher_id` int(11) NOT NULL,
                            PRIMARY KEY (`id`),
                            KEY `bulletin_fk0` (`publisher_id`),
                            CONSTRAINT `bulletin_fk0` FOREIGN KEY (`publisher_id`) REFERENCES `teacher` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bulletin
-- ----------------------------
INSERT INTO `bulletin` VALUES ('1', '2023-04-13 16:29:45', 'Student Party', '1');
INSERT INTO `bulletin` VALUES ('2', '2023-04-09 15:35:39', 'Cis party', '1');

-- ----------------------------
-- Table structure for class
-- ----------------------------
DROP TABLE IF EXISTS `class`;
CREATE TABLE `class` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `major_id` int(11) NOT NULL,
                         `year` varchar(4) CHARACTER SET utf8 NOT NULL,
                         `class_no` varchar(20) CHARACTER SET utf8 NOT NULL,
                         `num_people` int(11) NOT NULL,
                         PRIMARY KEY (`id`),
                         KEY `class_fk0` (`major_id`),
                         CONSTRAINT `class_fk0` FOREIGN KEY (`major_id`) REFERENCES `major` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of class
-- ----------------------------
INSERT INTO `class` VALUES ('1', '1', '4', '001', '30');
INSERT INTO `class` VALUES ('2', '2', '4', '002', '30');
INSERT INTO `class` VALUES ('3', '3', '4', '003', '30');
INSERT INTO `class` VALUES ('4', '4', '4', '004', '30');
INSERT INTO `class` VALUES ('5', '5', '4', '005', '30');
INSERT INTO `class` VALUES ('6', '6', '4', '006', '30');
INSERT INTO `class` VALUES ('7', '7', '4', '007', '30');
INSERT INTO `class` VALUES ('8', '8', '4', '008', '30');
INSERT INTO `class` VALUES ('9', '9', '4', '009', '30');
INSERT INTO `class` VALUES ('10', '10', '4', '010', '30');

-- ----------------------------
-- Table structure for course
-- ----------------------------
DROP TABLE IF EXISTS `course`;
CREATE TABLE `course` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `course_no` varchar(20) CHARACTER SET utf8 NOT NULL,
                          `name` varchar(20) CHARACTER SET utf8 NOT NULL,
                          `semester` varchar(20) NOT NULL,
                          `period` int(11) NOT NULL,
                          `teacher_id` int(11) NOT NULL,
                          `credit` float NOT NULL,
                          `if_optional` tinyint(1) NOT NULL DEFAULT '1',
                          PRIMARY KEY (`id`),
                          KEY `course_fk0` (`teacher_id`),
                          CONSTRAINT `course_fk0` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of course
-- ----------------------------
INSERT INTO `course` VALUES ('1', 'AC5124', 'CIS', '2016-2017', '120', '1', '2.5', '1');

-- ----------------------------
-- Table structure for major
-- ----------------------------
DROP TABLE IF EXISTS `major`;
CREATE TABLE `major` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `name` varchar(20) CHARACTER SET utf8 NOT NULL,
                         `major_num` varchar(20) CHARACTER SET utf8 NOT NULL,
                         `class_num` int(11) NOT NULL,
                         `academy_id` int(11) NOT NULL,
                         PRIMARY KEY (`id`),
                         KEY `major_fk0` (`academy_id`),
                         CONSTRAINT `major_fk0` FOREIGN KEY (`academy_id`) REFERENCES `academy` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of major
-- ----------------------------
INSERT INTO `major` VALUES ('1', 'Computer Science and Technology', '653232', '3', '1');
INSERT INTO `major` VALUES ('2', 'Information Security', '653322', '3', '1');
INSERT INTO `major` VALUES ('3', 'Network Engineering', '632133', '3', '1');
INSERT INTO `major` VALUES ('4', 'Communication Engineering', '562311', '4', '1');
INSERT INTO `major` VALUES ('5', 'Electronic Information Engineering', '635212', '5', '1');
INSERT INTO `major` VALUES ('6', 'Software Engineering', '653211', '4', '1');
INSERT INTO `major` VALUES ('7', 'Statistics', '653532', '4', '2');
INSERT INTO `major` VALUES ('8', 'Computational Mathematics', '653221', '5', '2');
INSERT INTO `major` VALUES ('9', 'Financial Mathematics', '654432', '5', '2');


-- ----------------------------
-- Table structure for student
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
                           `id` int(11) NOT NULL AUTO_INCREMENT,
                           `student_id` varchar(20) NOT NULL,
                           `name` varchar(20) NOT NULL,
                           `avatar` varchar(50) NOT NULL DEFAULT 'defult_user.jpg',
                           `dob` date NOT NULL,
                           `gender` varchar(2) NOT NULL,
                           `personalEmail` varchar(20) DEFAULT NULL,
                           `phone` varchar(20) DEFAULT NULL,
                           `workEmail` varchar(20) DEFAULT NULL,
                           `province` varchar(20) DEFAULT NULL,
                           `city` varchar(20) DEFAULT NULL,
                           `detail` varchar(20) DEFAULT NULL,
                           `enrolment` date NOT NULL,
                           `username` varchar(20) NOT NULL,
                           `password` varchar(20) NOT NULL DEFAULT '12345',
                           `class_id` int(11) NOT NULL,
                           PRIMARY KEY (`id`),
                           KEY `student_fk0` (`class_id`),
                           CONSTRAINT `student_fk0` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of student
-- ----------------------------
INSERT INTO `student` VALUES ('1', '201513130117', 'StudentJJ', 'defult_user.jpg', '1996-05-02', 'female', '', '13712345678', '123456@gmail.com', 'Shanghai', 'China', 'China', '2015-09-01', '001', '12345', '1');
INSERT INTO `student` VALUES ('2', '201513130101', 'KK', 'defult_user.jpg', '1996-05-01', 'male', '', '15612345678', '654321@gmail.com', 'Beijing', 'China', 'China', '2015-09-02', '002', '12345', '1');

-- ----------------------------
-- Table structure for student_course
-- ----------------------------
DROP TABLE IF EXISTS `student_course`;
CREATE TABLE `student_course` (
                                  `id` int(11) NOT NULL AUTO_INCREMENT,
                                  `student_id` int(11) NOT NULL,
                                  `course_id` int(11) NOT NULL,
                                  `grade` float DEFAULT NULL,
                                  `grade_point` float DEFAULT NULL,
                                  `score_type` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
                                  `storage_time` datetime DEFAULT NULL,
                                  `storage_staff` int(11) DEFAULT NULL,
                                  PRIMARY KEY (`id`),
                                  KEY `student_course_fk0` (`student_id`),
                                  KEY `student_course_fk1` (`course_id`),
                                  KEY `student_course_fk2` (`storage_staff`),
                                  CONSTRAINT `student_course_fk0` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`),
                                  CONSTRAINT `student_course_fk1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
                                  CONSTRAINT `student_course_fk2` FOREIGN KEY (`storage_staff`) REFERENCES `teacher` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for teacher
-- ----------------------------
DROP TABLE IF EXISTS `teacher`;
CREATE TABLE `teacher` (
                           `id` int(11) NOT NULL AUTO_INCREMENT,
                           `teacher_no` varchar(20) NOT NULL,
                           `name` varchar(20) CHARACTER SET utf8 NOT NULL,
                           `avatar` varchar(50) NOT NULL DEFAULT 'defult_user.jpg',
                           `academic_title` varchar(25) CHARACTER SET utf8 NOT NULL,
                           `dob` date NOT NULL,
                           `gender` varchar(2) CHARACTER SET utf8 NOT NULL,
                           `personalEmail` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
                           `phone` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
                           `workEmail` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
                           `inauguration_date` date NOT NULL,
                           `leave_date` date DEFAULT NULL,
                           `academy_id` int(11) NOT NULL,
                           `username` varchar(20) CHARACTER SET utf8 NOT NULL,
                           `password` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '12345',
                           `role` varchar(10) CHARACTER SET utf8 NOT NULL,
                           PRIMARY KEY (`id`),
                           KEY `teacher_fk0` (`academy_id`),
                           CONSTRAINT `teacher_fk0` FOREIGN KEY (`academy_id`) REFERENCES `academy` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of teacher
-- ----------------------------
INSERT INTO `teacher` VALUES ('2', '5621621212', 'Admin', 'defult_user.jpg', 'Teacher', '1957-01-21', 'male', '', '010-52412546', '52412@163.com', '1976-06-28', null, '2', 'admin', '12345', '2');
INSERT INTO `teacher` VALUES ('1', '5621621216', 'TeacherJ', 'defult_user.jpg', 'Teacher', '1959-05-12', 'male', '', '010-96585124', '9562412@gmail.com', '1979-06-10', null, '1', '01', '12345', '1');
