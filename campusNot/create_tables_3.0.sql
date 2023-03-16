-- --------------------------------------------------------
-- CREATE TABLES
-- Alphabetically sorted, except Primary Keys at top
-- --------------------------------------------------------

--
-- Table structure for table `user_general`
--

CREATE TABLE `group10`.`user_general` ( 
  `userID` VARCHAR(256) NOT NULL, 
  `userName` VARCHAR(256) NOT NULL, -- login username*
  `userPersonalName` VARCHAR(256) NOT NULL,
  `userPassword` VARCHAR(256) NOT NULL, 
  `userEmail` VARCHAR(256) NOT NULL, 
  `userType` char(1) NOT NULL, 
  `userStatus` BOOLEAN NOT NULL DEFAULT TRUE, -- login permissions
  PRIMARY KEY (`userID`), UNIQUE (`userName`), 
  UNIQUE (`userEmail`)
) ENGINE = InnoDB;

-- --------------------------------------------------------

--
-- Table structure for table `announcement_general`
--

CREATE TABLE `announcement_general` (
  `announceID` VARCHAR(256) NOT NULL,
  `userID` VARCHAR(256) NOT NULL,
  `announceDate` TIMESTAMP(6) NOT NULL DEFAULT current_timestamp(6),
  `announceDescription` text NOT NULL,
  `announceViews` int(32) DEFAULT 0,
  `announceStatus` BOOLEAN NOT NULL DEFAULT TRUE,
  `announceRank` int(16) NOT NULL DEFAULT 1,
  PRIMARY KEY (announceID),
  FOREIGN KEY (userID) REFERENCES user_general(userID)
) ;

-- --------------------------------------------------------

--
-- Table structure for table `club_general`
--

CREATE TABLE `club_general` (
  `clubID` VARCHAR(256) NOT NULL,
  `clubName` VARCHAR(256) NOT NULL,
  `clubStatus` BOOLEAN NOT NULL DEFAULT TRUE,
  PRIMARY KEY (clubID), UNIQUE (`clubName`)
) ENGINE=InnoDB DEFAULT charSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `course_general`
--

CREATE TABLE `course_general` (
  `courseID` VARCHAR(256) NOT NULL,
  `courseName` VARCHAR(256) NOT NULL,
  `hasExam` BOOLEAN NOT NULL DEFAULT FALSE,
  `hasLab` BOOLEAN NOT NULL DEFAULT FALSE,
  `hasTutorial` BOOLEAN NOT NULL DEFAULT FALSE,
  `courseStatus` BOOLEAN NOT NULL DEFAULT TRUE,
  PRIMARY KEY (courseID)
) ENGINE=InnoDB DEFAULT charSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `event_general`
--

CREATE TABLE `event_general` (
  `eventID` VARCHAR(256) NOT NULL,
  `eventName` VARCHAR(256) NOT NULL,
  `eventLocation` VARCHAR(256) DEFAULT NULL,
  `eventRegistrations` int(32) DEFAULT 0,
  `eventMaxPeople` int(32) DEFAULT NULL,
  `eventTime` datetime DEFAULT NULL,
  `eventDescription` text DEFAULT NULL,
  `userID` VARCHAR(256) NOT NULL,
  `eventDocuments` longtext DEFAULT NULL,
  `eventStatus` BOOLEAN NOT NULL DEFAULT TRUE,
  PRIMARY KEY (eventID),
  FOREIGN KEY (userID) REFERENCES user_general(userID)
) ;

-- --------------------------------------------------------

--
-- Table structure for table `exam_general`
--

CREATE TABLE `exam_general` (
  `examID` VARCHAR(256) NOT NULL,
  `courseID` VARCHAR(256) NOT NULL,
  `examName` VARCHAR(256) NOT NULL,
  `examStatus` BOOLEAN NOT NULL DEFAULT TRUE,
  PRIMARY KEY (examID),
  FOREIGN KEY (courseID) REFERENCES course_general(courseID)
) ENGINE=InnoDB DEFAULT charSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lab_general`
--

CREATE TABLE `lab_general` (
  `labID` VARCHAR(256) NOT NULL,
  `courseID` VARCHAR(256) NOT NULL,
  `labName` VARCHAR(256) NOT NULL,
  `labRotation` int(2) NOT NULL DEFAULT 1, 
  `labStatus` BOOLEAN NOT NULL DEFAULT TRUE,
  PRIMARY KEY (labID),
  FOREIGN KEY (courseID) REFERENCES course_general(courseID)
) ENGINE=InnoDB DEFAULT charSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `major_general`
--

CREATE TABLE `major_general` (
  `majorID` VARCHAR(256) NOT NULL,
  `majorName` VARCHAR(256) NOT NULL,
  `majorStatus` BOOLEAN NOT NULL DEFAULT TRUE,
  PRIMARY KEY (majorID), UNIQUE (`majorName`)
) ENGINE=InnoDB DEFAULT charSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tutorial_general`
--

CREATE TABLE `tutorial_general` (
  `tutorialID` VARCHAR(256) NOT NULL,
  `tutorialName` VARCHAR(256) NOT NULL,
  `courseID` VARCHAR(256) NOT NULL,
  `isMandatory` BOOLEAN NOT NULL DEFAULT FALSE,
  `tutorialStatus` BOOLEAN NOT NULL DEFAULT TRUE,
  PRIMARY KEY (tutorialID), 
  FOREIGN KEY (courseID) REFERENCES course_general(courseID) 
) ENGINE=InnoDB DEFAULT charSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `admin_basic_general`
--

CREATE TABLE `admin_basic_general` (
  `userID` VARCHAR(256) NOT NULL,
  `adminStartYear` year NOT NULL,
  `adminEndYear` year DEFAULT NULL,
  `adminPermissionsCode` int(16) DEFAULT NULL,
  FOREIGN KEY (userID) REFERENCES user_general(userID)
) ENGINE=InnoDB DEFAULT charSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `club_details`
--

CREATE TABLE `club_details` (
  `clubID` VARCHAR(256) NOT NULL,
  `clubFunding` float NOT NULL DEFAULT 1,
  `clubRegistrationsStudents` int(32) NOT NULL DEFAULT 1,
  `clubMaxStudents` int(32) NOT NULL DEFAULT 1,
  `clubRegistrationProfessors` int(32) NOT NULL DEFAULT 1,
  `clubMaxProfessors` int(32) NOT NULL DEFAULT 1,
  `clubLocation` VARCHAR(256) DEFAULT NULL,
  `clubDescription` text DEFAULT NULL,
  `clubMentions` text DEFAULT NULL,
  FOREIGN KEY (clubID) REFERENCES club_general(clubID)
) ENGINE=InnoDB DEFAULT charSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `club_schedule`
--

CREATE TABLE `club_schedule` (
  `clubID` VARCHAR(256) NOT NULL,
  `clubStartdate` date NOT NULL DEFAULT current_timestamp(6),
  `clubEnddate` date DEFAULT NULL,
  `clubDayOne` time DEFAULT NULL,
  `clubDayTwo` time DEFAULT NULL,
  `clubDayThree` time DEFAULT NULL,
  `clubtimeSlotOne` time DEFAULT NULL,
  `clubtimeSlotTwo` time DEFAULT NULL,
  `clubtimeSlotThree` time DEFAULT NULL,
  `clubDurationOne` time DEFAULT NULL,
  `clubDurationTwo` time DEFAULT NULL,
  `clubDurationThree` time DEFAULT NULL,
  FOREIGN KEY (clubID) REFERENCES club_general(clubID)
) ENGINE=InnoDB DEFAULT charSET=utf8mb4;

-- -----------------------------------------------------------------
--

-- -- Table structure for table `club_users`

CREATE TABLE `club_users` (
  `clubID` VARCHAR(256) NOT NULL,
  `userID` VARCHAR(256) NOT NULL,
  `isOwner` BOOLEAN NOT NULL DEFAULT FALSE,
  `isOrganiser` BOOLEAN NOT NULL DEFAULT FALSE,
  FOREIGN KEY (clubID) REFERENCES club_general(clubID),
  FOREIGN KEY (userID) REFERENCES user_general(userID)
) ENGINE=InnoDB DEFAULT charSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `course_details`
--

CREATE TABLE `course_details` (
  `courseID` VARCHAR(256) NOT NULL,
  `courseCredits` double NOT NULL,
  `courseAttendance` BOOLEAN NOT NULL DEFAULT FALSE,
  `courseDescription` text DEFAULT NULL,
  `registeredStudents` int(32) NOT NULL DEFAULT 0,
  `maxStudents` int(32) DEFAULT NULL,
  `courseMaterials` longtext DEFAULT NULL,
  FOREIGN KEY (courseID) REFERENCES course_general(courseID)
) ENGINE=InnoDB DEFAULT charSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `course_prerequisite`
--

CREATE TABLE `course_prerequisite` (
  `courseID` VARCHAR(256) NOT NULL,
  `coursePreReqCourseOne` VARCHAR(256) DEFAULT NULL,
  `coursePreReqCourseTwo` VARCHAR(256) DEFAULT NULL,
  `coursePreReqLabOne` VARCHAR(256) DEFAULT NULL,
  `coursePreReqLabTwo` VARCHAR(256) DEFAULT NULL,
  FOREIGN KEY (courseID) REFERENCES course_general(courseID),
  FOREIGN KEY (coursePreReqCourseOne) REFERENCES course_general(courseID),
  FOREIGN KEY (coursePreReqCourseTwo) REFERENCES course_general(courseID),
  FOREIGN KEY (coursePreReqLabOne) REFERENCES lab_general(labID),
  FOREIGN KEY (coursePreReqLabTwo) REFERENCES lab_general(labID)
) ENGINE=InnoDB DEFAULT charSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `course_professors`
--

CREATE TABLE `course_professors` (
  `courseID` VARCHAR(256) NOT NULL,
  `userID` VARCHAR(256) NOT NULL,
  FOREIGN KEY (userID) REFERENCES user_general(userID),
  FOREIGN KEY (courseID) REFERENCES course_general(courseID)
) ENGINE=InnoDB DEFAULT charSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `course_schedule`
--

CREATE TABLE `course_schedule` (
  `courseID` VARCHAR(256) NOT NULL,
  `courseStart` date DEFAULT NULL,
  `courseEnd` date DEFAULT NULL,
  `courseDayOne` VARCHAR(64) NOT NULL,
  `courseDayTwo` VARCHAR(64) DEFAULT NULL,
  `courseDayThree` VARCHAR(64) DEFAULT NULL,
  `courseSlotOne` time(6) NOT NULL,
  `courseSlotTwo` time(6) DEFAULT NULL,
  `courseSlotThree` time(6) DEFAULT NULL,
  `courseDurationOne` time(6) NOT NULL,
  `courseDurationTwo` time(6) DEFAULT NULL,
  `courseDurationThree` time(6) DEFAULT NULL,
  FOREIGN KEY (courseID) REFERENCES course_general(courseID)
) ENGINE=InnoDB DEFAULT charSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `course_students (student_details_courses)`
--

CREATE TABLE `course_students` (
  `userID` VARCHAR(256) NOT NULL,
  `courseID` VARCHAR(256) NOT NULL,
  `status_registration` int(32) NOT NULL DEFAULT 0,
  `status_finish_course` BOOLEAN NOT NULL DEFAULT FALSE,
  FOREIGN KEY (userID) REFERENCES user_general(userID),
  FOREIGN KEY (courseID) REFERENCES course_general(courseID)
) ENGINE=InnoDB DEFAULT charSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `event_users`
--

CREATE TABLE `event_users` (
  `eventID` VARCHAR(256) NOT NULL,
  `userID` VARCHAR(256) NOT NULL,
  `isOwner` BOOLEAN NOT NULL DEFAULT FALSE,
  `isOrganiser` BOOLEAN NOT NULL DEFAULT FALSE,
  FOREIGN KEY (eventID) REFERENCES event_general(eventID),
  FOREIGN KEY (userID) REFERENCES user_general(userID)
) ENGINE=InnoDB DEFAULT charSET=utf8mb4;
-- --------------------------------------------------------

--
-- Table structure for table `exam_details`
--

CREATE TABLE `exam_details` (
  `examID` VARCHAR(256) NOT NULL,
  `examAttemptNum` int(2) NOT NULL DEFAULT 1, 
  `examDate` date DEFAULT NULL,
  `examTimeStart` time(6) DEFAULT NULL,
  `examTimeEnd` time(6) DEFAULT NULL,
  `examLocation` VARCHAR(128) DEFAULT NULL,
  `examComment` text DEFAULT NULL,
  FOREIGN KEY (examID) REFERENCES exam_general(examID)
) ENGINE=InnoDB DEFAULT charSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lab_details`
--

CREATE TABLE `lab_details` (
  `labID` VARCHAR(256) NOT NULL,
  `labCredits` double NOT NULL,
  `labAttendance` BOOLEAN NOT NULL DEFAULT TRUE,
  `labRegisteredStudents` int(64) NOT NULL DEFAULT 0,
  `labMaxStudents` int(64) DEFAULT NULL,
  `labDescription` text DEFAULT NULL,
  `labMaterials` longtext DEFAULT NULL,
  FOREIGN KEY (labID) REFERENCES lab_general(labID)
) ;

-- --------------------------------------------------------

--
-- Table structure for table `lab_schedule`
--

CREATE TABLE `lab_schedule` (
  `labID` VARCHAR(256) NOT NULL,
  `labStart` date DEFAULT NULL,
  `labEnd` date DEFAULT NULL,
  `labDayOne` VARCHAR(64) DEFAULT NULL,
  `labDayTwo` VARCHAR(64) DEFAULT NULL,
  `labDayThree` VARCHAR(64) DEFAULT NULL,
  `labSlotOne` time(6) DEFAULT NULL,
  `labSlotTwo` time(6) DEFAULT NULL,
  `labSlotThree` time(6) DEFAULT NULL,
  `labDurationOne` time(6) DEFAULT NULL,
  `labDurationTwo` time(6) DEFAULT NULL,
  `labDurationThree` time(6) DEFAULT NULL,
  FOREIGN KEY (labID) REFERENCES lab_general(labID)
) ENGINE=InnoDB DEFAULT charSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lab_users`
--

CREATE TABLE `lab_users` (
  `labID` VARCHAR(256) NOT NULL,
  `userID` VARCHAR(256) NOT NULL,
  `isProfessor` BOOLEAN NOT NULL DEFAULT FALSE,
  `isInstructor` BOOLEAN NOT NULL DEFAULT FALSE,
  `isTA` BOOLEAN NOT NULL DEFAULT FALSE,
  FOREIGN KEY (labID) REFERENCES lab_general(labID),
  FOREIGN KEY (userID) REFERENCES user_general(userID)
) ;

-- --------------------------------------------------------

--
-- Table structure for table `major_courses`
--

CREATE TABLE `major_courses` (
  `majorID` VARCHAR(256) NOT NULL,
  `courseID` VARCHAR(256) NOT NULL,
  `isCore` BOOLEAN NOT NULL DEFAULT FALSE,
  `isElective` BOOLEAN NOT NULL DEFAULT FALSE,
  FOREIGN KEY (majorID) REFERENCES major_general(majorID),
  FOREIGN KEY (courseID) REFERENCES course_general(courseID)
) ENGINE=InnoDB DEFAULT charSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `professor_general`
--

CREATE TABLE `professor_general` (
  `userID` VARCHAR(256) NOT NULL,
  `profFocusArea` VARCHAR(128) DEFAULT NULL,
  `profStartYear` year(4) NOT NULL DEFAULT current_timestamp(6), 
  `profEndYear` year(4) DEFAULT NULL,
  FOREIGN KEY (userID) REFERENCES user_general(userID)
) ENGINE=InnoDB DEFAULT charSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student_general`
--

CREATE TABLE `student_general` (
  `userID` VARCHAR(256) NOT NULL,
  `studentMatrNo` int(16) UNIQUE NOT NULL DEFAULT NULL AUTO_INCREMENT,
  `studentYearStart` year(4) DEFAULT NULL, 
  `studentYearEnd` year(4) DEFAULT NULL,
  `studentMajorOne` VARCHAR(256) DEFAULT NULL,
  `studentMajorTwo` VARCHAR(256) DEFAULT NULL,
  `studentEmailPersonal` VARCHAR(128) DEFAULT NULL, 
   FOREIGN KEY (userID) REFERENCES user_general(userID),
   FOREIGN KEY (studentMajorOne) REFERENCES major_general(majorID),
   FOREIGN KEY (studentMajorTwo) REFERENCES major_general(majorID)
) ENGINE=InnoDB DEFAULT charSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student_details_faculty`
--

CREATE TABLE `student_details_faculty` ( 
  `userID` VARCHAR(256) NOT NULL,
  `isTA` BOOLEAN NOT NULL DEFAULT FALSE,
  `inClub` BOOLEAN NOT NULL DEFAULT FALSE,
  `inCO` BOOLEAN NOT NULL DEFAULT FALSE,
  `livesCampus` BOOLEAN NOT NULL DEFAULT TRUE,
  `isUndergrad` BOOLEAN NOT NULL DEFAULT TRUE,
  `isMasters` BOOLEAN NOT NULL DEFAULT FALSE,
  `isPhD` BOOLEAN NOT NULL DEFAULT FALSE,
  `thesis_status` int(32) NOT NULL DEFAULT 0,
  FOREIGN KEY (userID) REFERENCES user_general(userID)
) ENGINE=InnoDB DEFAULT charSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student_details_financial`
--

CREATE TABLE `student_details_financial` (
  `userID` VARCHAR(256) NOT NULL,
  `studentRemainingAcc` float NOT NULL DEFAULT 0.0,
  `studentStudyAtEase` BOOLEAN NOT NULL DEFAULT FALSE, 
  `studentHousingPaid` BOOLEAN NOT NULL DEFAULT FALSE,
  `studentTuitionPaid` BOOLEAN NOT NULL DEFAULT FALSE,
  `studentFeesPaid` BOOLEAN NOT NULL DEFAULT FALSE,
  `studentHousingAmmount` float DEFAULT NULL, 
  `studentTuitionAmmount` float DEFAULT NULL, 
  `studentFeesAmmount` float DEFAULT NULL, 
  `studentInvoice` longtext DEFAULT NULL, 
  FOREIGN KEY (userID) REFERENCES user_general(userID)
) ;

-- --------------------------------------------------------

--
-- Table structure for table `student_details_health`
--

CREATE TABLE `student_details_health` (
  `userID` VARCHAR(256) NOT NULL,
  `hasHealthInsurance` BOOLEAN NOT NULL DEFAULT FALSE,
  `healthInsuranceScan` longtext DEFAULT NULL,
  FOREIGN KEY (userID) REFERENCES user_general(userID)
) ;

-- --------------------------------------------------------

--
-- Table structure for table `student_details_housing`
--

CREATE TABLE `student_details_housing` (
  `userID` VARCHAR(256) NOT NULL,
  `studentCollege` VARCHAR(256) DEFAULT NULL,
  `studentRoom` VARCHAR(256) DEFAULT NULL,
  `isOnMealplan` BOOLEAN NOT NULL DEFAULT TRUE,
  `hasKitchenAccess` BOOLEAN NOT NULL DEFAULT FALSE,
  FOREIGN KEY (userID) REFERENCES user_general(userID)
) ENGINE=InnoDB DEFAULT charSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student_personal_details`
--

CREATE TABLE `student_details_personal` ( 
  `userID` VARCHAR(256) NOT NULL,
  `studentPreferredName` VARCHAR(256) DEFAULT NULL,
  `studentGender` VARCHAR(256) DEFAULT NULL,
  `studentReligion` VARCHAR(256) DEFAULT NULL,
  `studentNationality` VARCHAR(256) DEFAULT NULL,
  `studentLanguage` VARCHAR(256) DEFAULT NULL,
  `studentAge` int(32) DEFAULT NULL,
  `studentMentions` text DEFAULT NULL,
   FOREIGN KEY (userID) REFERENCES user_general(userID)  
) ENGINE=InnoDB DEFAULT charSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student_exam_results`
--

CREATE TABLE `student_exam_results` (
  `userID` VARCHAR(256) NOT NULL,
  `examID` VARCHAR(256) NOT NULL,
  `examGrade` float NOT NULL, 
  `examResult` BOOLEAN NOT NULL, 
   FOREIGN KEY (userID) REFERENCES user_general(userID),
   FOREIGN KEY (examID) REFERENCES exam_general(examID)
) ENGINE=InnoDB DEFAULT charSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tutorial_schedule`
--

CREATE TABLE `tutorial_schedule` (
  `tutorialID` VARCHAR(256) NOT NULL,
  `tutorialStart` date DEFAULT NULL,
  `tutorialEnd` date DEFAULT NULL,
  `tutorialDayOne` VARCHAR(256) DEFAULT NULL,
  `tutorialDayTwo` VARCHAR(256) DEFAULT NULL,
  `tutorialDayThree` VARCHAR(256) DEFAULT NULL,
  `tutorialSlotOne` time(6) DEFAULT NULL,
  `tutorialSlotTwo` time(6) DEFAULT NULL,
  `tutorialSlotThree` time(6) DEFAULT NULL,
  `tutorialDurationOne` time(6) DEFAULT NULL,
  `tutorialDurationTwo` time(6) DEFAULT NULL,
  `tutorialDurationThree` time(6) DEFAULT NULL,
  FOREIGN KEY (tutorialID) REFERENCES tutorial_general(tutorialID) 
) ENGINE=InnoDB DEFAULT charSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tutorial_users`
--

CREATE TABLE `tutorial_users` (
  `tutorialID` VARCHAR(256) NOT NULL,
  `userID` VARCHAR(256) NOT NULL,
  `isProfessor` BOOLEAN NOT NULL DEFAULT FALSE,
  `isTA` BOOLEAN NOT NULL DEFAULT FALSE,
  FOREIGN KEY (tutorialID) REFERENCES tutorial_general(tutorialID),
  FOREIGN KEY (userID) REFERENCES user_general(userID)  

) ENGINE=InnoDB DEFAULT charSET=utf8mb4;

-- --------------------------------------------------------
-- END OF CREATE TABLES
-- --------------------------------------------------------

-- --------------------------------------------------------
-- INITIAL INSERTS

INSERT INTO user_general VALUES ('635decce5a0b8', 'wblake', 'William Emerson Blake', '$2y$10$eEtat9psp3ILPv80wTVqyuan.Ev94QhqRpQOGqD.qgHl5joSjFd1G', 'wblake@jacobs-university.de', 'A', 1);
INSERT INTO admin_basic_general VALUES ('635decce5a0b8', 2020, NULL, 8383);

-- END OF INITIAL INSERTS
-- --------------------------------------------------------
