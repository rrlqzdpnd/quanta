/* *****

Entities:

	TABLE subjects
	TABLE sets 
		* answer string
		* subjectid
	TABLE questions
		* setid
	TABLE choices
		* questionid
	ALTER TABLE userhistory
		* answer string

***** */

--Sets

DROP TABLE sets CASCADE;

CREATE TABLE sets (
    setid INTEGER NOT NULL,
    setname CHARACTER VARYING NOT NULL,
	subjectid INTEGER NOT NULL, --"I'm Math-senpai's Set A!~"
	answerstring CHARACTER VARYING NOT NULL, --the answer key of the set, example: 10231 = B, A, C, D, B
    description TEXT
);

ALTER TABLE sets OWNER TO postgres;

CREATE SEQUENCE sets_setid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
	
ALTER TABLE public.sets_setid_seq OWNER TO postgres;
ALTER SEQUENCE sets_setid_seq OWNED BY sets.setid;
SELECT pg_catalog.setval('sets_setid_seq', 1, false);

--Subjects

DROP TABLE subjects;

CREATE TABLE subjects (
	subjectid INTEGER NOT NULL,
	subjectname CHARACTER VARYING NOT NULL,
	description TEXT
);

ALTER TABLE subjects OWNER TO postgres;

CREATE SEQUENCE subjects_subjectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER TABLE public.subjects_subjectid_seq OWNER TO postgres;
ALTER SEQUENCE subjects_subjectid_seq OWNED BY subjects.subjectid;
SELECT pg_catalog.setval('subjects_subjectid_seq', 1, false);

--Constraints: subjectid must be unique, sets.subjectid must reference subjects.subjectid

ALTER TABLE ONLY subjects
    ADD CONSTRAINT subjects_subjectid_key UNIQUE (subjectid);
ALTER TABLE ONLY sets
    ADD CONSTRAINT sets_subjectid_fkey FOREIGN KEY (subjectid) REFERENCES subjects(subjectid);

--Questions

DROP TABLE questions CASCADE;

CREATE TABLE questions (
    questionid INTEGER NOT NULL,
	setid INTEGER NOT NULL, --"I'm Set A-sama's question!~"
    question TEXT NOT NULL
);
ALTER TABLE public.questions OWNER TO postgres;

CREATE SEQUENCE questions_questionid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.questions_questionid_seq OWNER TO postgres;
ALTER SEQUENCE questions_questionid_seq OWNED BY questions.questionid;
SELECT pg_catalog.setval('questions_questionid_seq', 1, false);

--Choices

DROP TABLE choices CASCADE;
CREATE TABLE choices (
    choiceid INTEGER NOT NULL,
	questionid INTEGER NOT NULL, --"I'm question 102-sama's choice!~"
    choicetext TEXT NOT NULL
);
ALTER TABLE public.choices OWNER TO postgres;
CREATE SEQUENCE choices_choiceid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.choices_choiceid_seq OWNER TO postgres;
ALTER SEQUENCE choices_choiceid_seq OWNED BY choices.choiceid;
SELECT pg_catalog.setval('choices_choiceid_seq', 1, false);

--Constraints

ALTER TABLE ONLY sets
    ADD CONSTRAINT sets_setid_key UNIQUE (setid);
ALTER TABLE ONLY questions
    ADD CONSTRAINT questions_questionid_key UNIQUE (questionid);
ALTER TABLE ONLY choices
    ADD CONSTRAINT choices_choiceid_key UNIQUE (choiceid);
ALTER TABLE ONLY questions
    ADD CONSTRAINT questions_setid_fkey FOREIGN KEY (setid) REFERENCES sets(setid);
ALTER TABLE ONLY choices
    ADD CONSTRAINT choices_questionid_fkey FOREIGN KEY (questionid) REFERENCES questions(questionid);

DROP TABLE questionanswers;
DROP TABLE questionchoices;
DROP TABLE questionsets CASCADE;
DROP TABLE useranswers;

-- User histories

DROP TABLE userhistories;
CREATE TABLE userhistories (
    userhistoryid INTEGER NOT NULL,
    userid INTEGER NOT NULL,
	setid INTEGER NOT NULL,
	answerstring CHARACTER VARYING NOT NULL, --the answer key of the user, example: 10231 = B, A, C, D, B
    score INTEGER NOT NULL,
    timefinished timestamp without time zone NOT NULL,
    timestarted timestamp without time zone DEFAULT now()
);
ALTER TABLE public.userhistories OWNER TO postgres;
CREATE SEQUENCE userhistories_userhistoryid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER TABLE public.userhistories_userhistoryid_seq OWNER TO postgres;
ALTER SEQUENCE userhistories_userhistoryid_seq OWNED BY userhistories.userhistoryid;
SELECT pg_catalog.setval('userhistories_userhistoryid_seq', 1, false);

-- Constraints

ALTER TABLE ONLY userhistories
    ADD CONSTRAINT userhistories_userid_fkey FOREIGN KEY (userid) REFERENCES users(userid);
ALTER TABLE ONLY userhistories
    ADD CONSTRAINT userhistories_setid_fkey FOREIGN KEY (setid) REFERENCES sets(setid);

-- Primary Key Constraints

ALTER TABLE ONLY sets
    ADD CONSTRAINT sets_pkey PRIMARY KEY (setid);
ALTER TABLE ONLY subjects
    ADD CONSTRAINT subjects_pkey PRIMARY KEY (subjectid);
ALTER TABLE ONLY questions
    ADD CONSTRAINT questions_pkey PRIMARY KEY (questionid);
ALTER TABLE ONLY choices
    ADD CONSTRAINT choices_pkey PRIMARY KEY (choiceid);

ALTER TABLE ONLY sets ALTER COLUMN setid SET DEFAULT nextval('sets_setid_seq'::regclass);
ALTER TABLE ONLY subjects ALTER COLUMN subjectid SET DEFAULT nextval('subjects_subjectid_seq'::regclass);
ALTER TABLE ONLY questions ALTER COLUMN questionid SET DEFAULT nextval('questions_questionid_seq'::regclass);
ALTER TABLE ONLY choices ALTER COLUMN choiceid SET DEFAULT nextval('choices_choiceid_seq'::regclass);

ALTER TABLE ONLY userhistories
    ADD CONSTRAINT userhistories_pkey PRIMARY KEY (userhistoryid);
ALTER TABLE ONLY sets ALTER COLUMN setid SET DEFAULT nextval('userhistories_userhistoryid_seq'::regclass);
	
-- Filling it with information
DELETE FROM subjects;

INSERT INTO subjects (subjectname, description) VALUES
	('Math', 'High school mathematics.'),
	('Science', 'Basic Biology, Chemistry, and Physics.'),
	('English', 'Intermediate English.'),
	('History', 'Philippine History.'),
	('Geography', 'World Geography.');

INSERT INTO sets (setname, subjectid, answerstring, description) VALUES
	('Set A', 1, '002', 'Math, Set A. 3 questions.'),
	('Set B', 1, '20', 'Math, Set B. 2 questions.'),
	('Set C', 1, '000', 'Math, Set C. 3 questions.'),
	('Set D', 1, '3', 'Math, Set D. 1 question.'),
	
	('Set A', 2, '003', 'Science, Set A. 3 questions.'),
	('Set B', 2, '33', 'Science, Set B. 2 questions.'),
	('Set C', 2, '13', 'Science, Set C. 2 questions.'),
	
	('Set A', 3, '33', 'English, Set A. 2 questions.'),
	('Set B', 3, '113', 'English, Set B. 3 questions.'),
	
	('Set A', 4, '33', 'History, Set A. 2 questions.');

INSERT INTO questions (setid, question) VALUES	
	(1, '4 + 5 = '),
	(1, '2 * 4 = '),
	(1, '1 / 7 = '),
	
	(2, '1 - 0 = '),
	(2, '1.25 = '),
	
	(3, '1 / 0 = '),
	(3, '69 = '),
	(3, 'What comes after Friday?'),
	
	(4, '2^10 / 1000'),
	
	(5, 'Fire type Pokemon are weak against: '),
	(5, 'The Pokedex number of Dragonite is: '),
	(5, 'You cannot shove yourself and Ditto in the daycare:'),
	
	(6, 'Love is: '),
	(6, 'Biggest mistake of my life: '),
	
	(7, 'Once you pop: '),
	(7, 'Most electric fans: '),
	
	(8, 'English: '),
	(8, 'Do you speak jeje?'),
	
	(9, 'C++: '),
	(9, 'PHP: '),
	(9, 'Latin: '),
	
	(10, 'Imelda Marcos had how many pairs of shoes?'),
	(10, 'Kris Aquino for President!');

INSERT INTO choices (questionid, choicetext) VALUES
	(1, '9'),
	(1, '5'),
	(1, '4'),
	(1, 'x'),

	(2, '8'),
	(2, '3'),
	(2, '5'),
	(2, 'All of the above.'),
	
	(3, '0.14782575'),
	(3, '0.151845168'),
	(3, '0.1428571'),
	(3, 'None of the above.'),


	(4, 'Your face.'),
	(4, 'Your mom.'),
	(4, 'Your CS 191 grade.'),
	(4, 'Your GWA.'),

	(5, 'Magna.'),
	(5, 'Summa.'),
	(5, 'Cum.'),
	(5, 'GWA ko.'),


	(6, 'You divided by 0.'),
	(6, 'Why would you do such a thing.'),
	(6, 'OH SHI--'),
	(6, 'Infinity.'),

	(7, 'FUN.'),
	(7, 'A not-so-prime number.'),
	(7, 'How you were conceived.'),
	(7, 'Every Friday. Sa Lagoon.'),

	(8, 'Saturday.'),
	(8, 'and Sunday comes afterwa-a-ards.'),
	(8, 'FUN FUN FUN FUN.'),
	(8, 'Paycheck.'),

	(9, 'GWA ni Oble.'),
	(9, 'GWA ng nanay mo.'),
	(9, 'GWA ng aso ko.'),
	(9, 'GWA ng tambay sa kanto.'),

	(10, 'Water'),
	(10, 'Grass'),
	(10, 'Electric'),
	(10, 'Psychic'),

	(11, '149'),
	(11, '150'),
	(11, '148'),
	(11, 'All of the above.'),

	(12, 'True.'),
	(12, 'False.'),
	(12, 'Daycare?'),
	(12, 'Oh bby.'),

	(13, 'awesome'),
	(13, 'blind'),
	(13, 'meaningless'),
	(13, 'in my pants'),

	(14, 'Pinanganak ako.'),
	(14, 'Something I did when I was young.'),
	(14, 'This past 15 years.'),
	(14, 'I didnt notice that the CS180 exam had a second page.'),

	(15, 'you need to hop.'),
	(15, 'you cannot stop.'),
	(15, 'you will feel the pain.'),
	(15, 'you will mop.'),

	(16, 'Can spin as fast as a harddisk.'),
	(16, 'Can spin as fast as /my/ harddisk. ),D'),
	(16, 'Hang a stinky sock at the back of the fan and BAM! Instant utot sa kwarto.'),
	(16, 'Lakas ng tama mo.'),

	(17, 'my first language'),
	(17, 'second language'),
	(17, 'third'),
	(17, 'not Python'),

	(18, 'Yes.'),
	(18, 'Yehs.'),
	(18, 'Y3hzs.'),
	(18, 'M4LaAhmAhNgghu p0owHzZ!'),

	(19, 'Procedural'),
	(19, 'Object-oriented'),
	(19, 'Functional'),
	(19, 'None of the above.'),

	(20, 'Procedural'),
	(20, 'Object-oriented'),
	(20, 'Functional'),
	(20, 'None of the above.'),

	(21, 'Procedural'),
	(21, 'Object-oriented'),
	(21, 'Functional'),
	(21, 'Dead.'),

	(22, 'Over 9000'),
	(22, '20% more'),
	(22, 'The amount of stars in the universe.'),
	(22, 'All of the above.'),

	(23, 'TRUE'),
	(23, 'FALSE'),
	(23, 'YES'),
	(23, 'NO');
