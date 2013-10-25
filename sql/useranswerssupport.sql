--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- Name: plpgsql; Type: PROCEDURAL LANGUAGE; Schema: -; Owner: postgres
--

CREATE OR REPLACE PROCEDURAL LANGUAGE plpgsql;


ALTER PROCEDURAL LANGUAGE plpgsql OWNER TO postgres;

SET search_path = public, pg_catalog;

--
-- Name: generate_salt(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION generate_salt(p_length integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$
        DECLARE
            characters text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
            result text := '';
            i integer := 0;
        BEGIN
            IF $1 < 0 THEN
                RAISE EXCEPTION 'Given length cannot be less than 0';
            END IF;

            FOR i IN 1..$1 LOOP
                result := result || characters[1+random()*(array_length(characters, 1)-1)];
            END LOOP;
            return result;
        END;
    $_$;


ALTER FUNCTION public.generate_salt(p_length integer) OWNER TO postgres;

--
-- Name: getlast_questionset(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getlast_questionset(p_categoryid integer) RETURNS integer
    LANGUAGE sql
    AS $_$
        SELECT setno
            FROM questionsets
            WHERE questionsets.categoryid = $1
            ORDER BY setno DESC
            LIMIT 1
        ;
    $_$;


ALTER FUNCTION public.getlast_questionset(p_categoryid integer) OWNER TO postgres;

--
-- Name: trg_setsalt(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION trg_setsalt() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
        BEGIN
            new.salt = generate_salt(32);
            new.password = md5(new.password||new.salt);

            RETURN new;
        END;
    $$;


ALTER FUNCTION public.trg_setsalt() OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: announcements; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE announcements (
    announcementid integer NOT NULL,
    title character varying(32) NOT NULL,
    body text,
    isactive boolean DEFAULT true,
    insertedon timestamp without time zone DEFAULT now() NOT NULL,
    insertedby integer NOT NULL
);


ALTER TABLE public.announcements OWNER TO postgres;

--
-- Name: announcements_announcementid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE announcements_announcementid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.announcements_announcementid_seq OWNER TO postgres;

--
-- Name: announcements_announcementid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE announcements_announcementid_seq OWNED BY announcements.announcementid;


--
-- Name: announcements_announcementid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('announcements_announcementid_seq', 1, true);


--
-- Name: categories; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE categories (
    categoryid integer NOT NULL,
    category character(1) NOT NULL,
    description text NOT NULL
);


ALTER TABLE public.categories OWNER TO postgres;

--
-- Name: categories_categoryid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE categories_categoryid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.categories_categoryid_seq OWNER TO postgres;

--
-- Name: categories_categoryid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE categories_categoryid_seq OWNED BY categories.categoryid;


--
-- Name: categories_categoryid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('categories_categoryid_seq', 1, false);


--
-- Name: choices; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE choices (
    choiceid integer NOT NULL,
    choicetext text NOT NULL
);


ALTER TABLE public.choices OWNER TO postgres;

--
-- Name: choices_choiceid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE choices_choiceid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.choices_choiceid_seq OWNER TO postgres;

--
-- Name: choices_choiceid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE choices_choiceid_seq OWNED BY choices.choiceid;


--
-- Name: choices_choiceid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('choices_choiceid_seq', 1, false);


--
-- Name: persons; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE persons (
    personid integer NOT NULL,
    lastname character varying(64) NOT NULL,
    firstname character varying(64) NOT NULL,
    middlename character varying(64),
    school text,
    insertedon timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.persons OWNER TO postgres;

--
-- Name: persons_personid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE persons_personid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.persons_personid_seq OWNER TO postgres;

--
-- Name: persons_personid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE persons_personid_seq OWNED BY persons.personid;


--
-- Name: persons_personid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('persons_personid_seq', 25, true);


--
-- Name: questionanswers; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE questionanswers (
    questionanswerid integer NOT NULL,
    questionid integer NOT NULL,
    choiceid integer NOT NULL
);


ALTER TABLE public.questionanswers OWNER TO postgres;

--
-- Name: questionanswers_questionanswerid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE questionanswers_questionanswerid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.questionanswers_questionanswerid_seq OWNER TO postgres;

--
-- Name: questionanswers_questionanswerid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE questionanswers_questionanswerid_seq OWNED BY questionanswers.questionanswerid;


--
-- Name: questionanswers_questionanswerid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('questionanswers_questionanswerid_seq', 1, false);


--
-- Name: questionchoices; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE questionchoices (
    questionchoiceid integer NOT NULL,
    questionid integer NOT NULL,
    choiceid integer NOT NULL,
    seqno integer NOT NULL
);


ALTER TABLE public.questionchoices OWNER TO postgres;

--
-- Name: questionchoices_questionchoiceid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE questionchoices_questionchoiceid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.questionchoices_questionchoiceid_seq OWNER TO postgres;

--
-- Name: questionchoices_questionchoiceid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE questionchoices_questionchoiceid_seq OWNED BY questionchoices.questionchoiceid;


--
-- Name: questionchoices_questionchoiceid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('questionchoices_questionchoiceid_seq', 1, false);


--
-- Name: questions; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE questions (
    questionid integer NOT NULL,
    question text NOT NULL
);


ALTER TABLE public.questions OWNER TO postgres;

--
-- Name: questions_questionid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE questions_questionid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.questions_questionid_seq OWNER TO postgres;

--
-- Name: questions_questionid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE questions_questionid_seq OWNED BY questions.questionid;


--
-- Name: questions_questionid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('questions_questionid_seq', 1, false);


--
-- Name: questionsets; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE questionsets (
    questionsetid integer NOT NULL,
    categoryid integer NOT NULL,
    questionid integer NOT NULL,
    setno integer NOT NULL,
    seqno integer NOT NULL
);


ALTER TABLE public.questionsets OWNER TO postgres;

--
-- Name: questionsets_questionsetid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE questionsets_questionsetid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.questionsets_questionsetid_seq OWNER TO postgres;

--
-- Name: questionsets_questionsetid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE questionsets_questionsetid_seq OWNED BY questionsets.questionsetid;


--
-- Name: questionsets_questionsetid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('questionsets_questionsetid_seq', 1, false);


--
-- Name: useranswers; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE useranswers (
    useranswerid integer NOT NULL,
    userhistoryid integer NOT NULL,
    questionsetid integer NOT NULL,
    answers character varying NOT NULL
);


ALTER TABLE public.useranswers OWNER TO postgres;

--
-- Name: useranswers_useranswerid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE useranswers_useranswerid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.useranswers_useranswerid_seq OWNER TO postgres;

--
-- Name: useranswers_useranswerid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE useranswers_useranswerid_seq OWNED BY useranswers.useranswerid;


--
-- Name: useranswers_useranswerid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('useranswers_useranswerid_seq', 1, false);


--
-- Name: userhistories; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE userhistories (
    userhistoryid integer NOT NULL,
    userid integer NOT NULL,
    score integer NOT NULL,
    timefinished timestamp without time zone NOT NULL,
    timestarted timestamp without time zone DEFAULT now()
);


ALTER TABLE public.userhistories OWNER TO postgres;

--
-- Name: userhistories_userhistoryid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE userhistories_userhistoryid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.userhistories_userhistoryid_seq OWNER TO postgres;

--
-- Name: userhistories_userhistoryid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE userhistories_userhistoryid_seq OWNED BY userhistories.userhistoryid;


--
-- Name: userhistories_userhistoryid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('userhistories_userhistoryid_seq', 1, false);


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE users (
    userid integer NOT NULL,
    login character varying(32) NOT NULL,
    password character varying(32) NOT NULL,
    personid integer NOT NULL,
    usertype character(1) NOT NULL,
    insertedon timestamp without time zone DEFAULT now(),
    salt character varying(32),
    emailaddress character varying(64) NOT NULL
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_userid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE users_userid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_userid_seq OWNER TO postgres;

--
-- Name: users_userid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE users_userid_seq OWNED BY users.userid;


--
-- Name: users_userid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('users_userid_seq', 11, true);


--
-- Name: usertypes; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE usertypes (
    usertype character(1) NOT NULL,
    description character varying(64) NOT NULL
);


ALTER TABLE public.usertypes OWNER TO postgres;

--
-- Name: announcementid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY announcements ALTER COLUMN announcementid SET DEFAULT nextval('announcements_announcementid_seq'::regclass);


--
-- Name: categoryid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY categories ALTER COLUMN categoryid SET DEFAULT nextval('categories_categoryid_seq'::regclass);


--
-- Name: choiceid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY choices ALTER COLUMN choiceid SET DEFAULT nextval('choices_choiceid_seq'::regclass);


--
-- Name: personid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY persons ALTER COLUMN personid SET DEFAULT nextval('persons_personid_seq'::regclass);


--
-- Name: questionanswerid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY questionanswers ALTER COLUMN questionanswerid SET DEFAULT nextval('questionanswers_questionanswerid_seq'::regclass);


--
-- Name: questionchoiceid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY questionchoices ALTER COLUMN questionchoiceid SET DEFAULT nextval('questionchoices_questionchoiceid_seq'::regclass);


--
-- Name: questionid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY questions ALTER COLUMN questionid SET DEFAULT nextval('questions_questionid_seq'::regclass);


--
-- Name: questionsetid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY questionsets ALTER COLUMN questionsetid SET DEFAULT nextval('questionsets_questionsetid_seq'::regclass);


--
-- Name: useranswerid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY useranswers ALTER COLUMN useranswerid SET DEFAULT nextval('useranswers_useranswerid_seq'::regclass);


--
-- Name: userhistoryid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY userhistories ALTER COLUMN userhistoryid SET DEFAULT nextval('userhistories_userhistoryid_seq'::regclass);


--
-- Name: userid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY users ALTER COLUMN userid SET DEFAULT nextval('users_userid_seq'::regclass);


--
-- Data for Name: announcements; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY announcements (announcementid, title, body, isactive, insertedon, insertedby) FROM stdin;
\.


--
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY categories (categoryid, category, description) FROM stdin;
\.


--
-- Data for Name: choices; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY choices (choiceid, choicetext) FROM stdin;
\.


--
-- Data for Name: persons; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY persons (personid, lastname, firstname, middlename, school, insertedon) FROM stdin;
22	Pineda	Errol	Quezada	University of the Philippines Diliman	2013-08-09 15:12:47.160535
23	Buergo	Chiara Gabrielle	Magpantay	University of the Philippines Diliman	2013-08-09 15:53:46.399667
24	Pineda	Errol	Quezada	University of the Philippines Diliman	2013-08-17 12:48:10.91694
25	Pineda	Errol	Quezada	University of the Philippines - Diliman	2013-09-16 15:05:11.203811
\.


--
-- Data for Name: questionanswers; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY questionanswers (questionanswerid, questionid, choiceid) FROM stdin;
\.


--
-- Data for Name: questionchoices; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY questionchoices (questionchoiceid, questionid, choiceid, seqno) FROM stdin;
\.


--
-- Data for Name: questions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY questions (questionid, question) FROM stdin;
\.


--
-- Data for Name: questionsets; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY questionsets (questionsetid, categoryid, questionid, setno, seqno) FROM stdin;
\.


--
-- Data for Name: useranswers; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY useranswers (useranswerid, userhistoryid, questionsetid, answers) FROM stdin;
\.


--
-- Data for Name: userhistories; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY userhistories (userhistoryid, userid, score, timefinished, timestarted) FROM stdin;
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY users (userid, login, password, personid, usertype, insertedon, salt, emailaddress) FROM stdin;
11	eqpineda	17efa9b8987a5f5bce1374e12f04cb9d	25	N	2013-09-16 15:05:11.203811	U02cfiU7Wo7RqDBTV1VAOAt1N6johpfD	errolpineda@yahoo.com
\.


--
-- Data for Name: usertypes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY usertypes (usertype, description) FROM stdin;
A	Administrator
N	Normal User
\.


--
-- Name: announcements_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY announcements
    ADD CONSTRAINT announcements_pkey PRIMARY KEY (announcementid);


--
-- Name: categories_category_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY categories
    ADD CONSTRAINT categories_category_key UNIQUE (category);


--
-- Name: categories_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (categoryid);


--
-- Name: choices_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY choices
    ADD CONSTRAINT choices_pkey PRIMARY KEY (choiceid);


--
-- Name: persons_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY persons
    ADD CONSTRAINT persons_pkey PRIMARY KEY (personid);


--
-- Name: questionanswers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY questionanswers
    ADD CONSTRAINT questionanswers_pkey PRIMARY KEY (questionanswerid);


--
-- Name: questionanswers_questionid_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY questionanswers
    ADD CONSTRAINT questionanswers_questionid_key UNIQUE (questionid);


--
-- Name: questionchoices_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY questionchoices
    ADD CONSTRAINT questionchoices_pkey PRIMARY KEY (questionchoiceid);


--
-- Name: questions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY questions
    ADD CONSTRAINT questions_pkey PRIMARY KEY (questionid);


--
-- Name: questionsets_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY questionsets
    ADD CONSTRAINT questionsets_pkey PRIMARY KEY (questionsetid);


--
-- Name: questionsets_setno_categoryid_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY questionsets
    ADD CONSTRAINT questionsets_setno_categoryid_key UNIQUE (setno, categoryid);


--
-- Name: useranswers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY useranswers
    ADD CONSTRAINT useranswers_pkey PRIMARY KEY (useranswerid);


--
-- Name: userhistories_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY userhistories
    ADD CONSTRAINT userhistories_pkey PRIMARY KEY (userhistoryid);


--
-- Name: users_emailaddress_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_emailaddress_key UNIQUE (emailaddress);


--
-- Name: users_login_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_login_key UNIQUE (login);


--
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (userid);


--
-- Name: usertypes_usertype_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY usertypes
    ADD CONSTRAINT usertypes_usertype_key UNIQUE (usertype);


--
-- Name: trg_generatesalt; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER trg_generatesalt BEFORE INSERT ON users FOR EACH ROW EXECUTE PROCEDURE trg_setsalt();


--
-- Name: announcements_insertedby_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY announcements
    ADD CONSTRAINT announcements_insertedby_fkey FOREIGN KEY (insertedby) REFERENCES users(userid);


--
-- Name: questionanswers_choiceid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY questionanswers
    ADD CONSTRAINT questionanswers_choiceid_fkey FOREIGN KEY (choiceid) REFERENCES choices(choiceid);


--
-- Name: questionanswers_questionid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY questionanswers
    ADD CONSTRAINT questionanswers_questionid_fkey FOREIGN KEY (questionid) REFERENCES questions(questionid);


--
-- Name: questionchoices_choiceid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY questionchoices
    ADD CONSTRAINT questionchoices_choiceid_fkey FOREIGN KEY (choiceid) REFERENCES choices(choiceid);


--
-- Name: questionchoices_questionid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY questionchoices
    ADD CONSTRAINT questionchoices_questionid_fkey FOREIGN KEY (questionid) REFERENCES questions(questionid);


--
-- Name: questionsets_categoryid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY questionsets
    ADD CONSTRAINT questionsets_categoryid_fkey FOREIGN KEY (categoryid) REFERENCES categories(categoryid);


--
-- Name: questionsets_questionid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY questionsets
    ADD CONSTRAINT questionsets_questionid_fkey FOREIGN KEY (questionid) REFERENCES questions(questionid);


--
-- Name: useranswers_questionsetid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY useranswers
    ADD CONSTRAINT useranswers_questionsetid_fkey FOREIGN KEY (questionsetid) REFERENCES questionsets(questionsetid);


--
-- Name: useranswers_userhistoryid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY useranswers
    ADD CONSTRAINT useranswers_userhistoryid_fkey FOREIGN KEY (userhistoryid) REFERENCES userhistories(userhistoryid);


--
-- Name: userhistories_userid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY userhistories
    ADD CONSTRAINT userhistories_userid_fkey FOREIGN KEY (userid) REFERENCES users(userid);


--
-- Name: users_personid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_personid_fkey FOREIGN KEY (personid) REFERENCES persons(personid);


--
-- Name: users_usertype_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_usertype_fkey FOREIGN KEY (usertype) REFERENCES usertypes(usertype);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

