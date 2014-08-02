--- create main database
CREATE DATABASE attendance;

-- Table structure for table `courses`

CREATE TABLE IF NOT EXISTS `courses` (
  `course_no` varchar(10) NOT NULL,
  `course_name` varchar(32) NOT NULL,
  PRIMARY KEY (`course_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table structure for table `teachers`

CREATE TABLE IF NOT EXISTS `teachers` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `email` varchar(1024) NOT NULL,
  `email_code` varchar(32) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `password_recover` int(11) NOT NULL DEFAULT '0',
  `type` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- 
CREATE TABLE IF NOT EXISTS `student_id` (
  `roll_no` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  PRIMARY KEY (`roll_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;