--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: email_templates; Type: TABLE; Schema: public; Owner: rcp; Tablespace: 
--

CREATE TABLE email_templates (
    id integer NOT NULL,
    key character varying(32) NOT NULL,
    template text NOT NULL,
    subject character varying(256)
);


ALTER TABLE public.email_templates OWNER TO rcp;

--
-- Name: TABLE email_templates; Type: COMMENT; Schema: public; Owner: rcp
--

COMMENT ON TABLE email_templates IS 'шаблоны писем для отправки юзерам';


--
-- Name: COLUMN email_templates.key; Type: COMMENT; Schema: public; Owner: rcp
--

COMMENT ON COLUMN email_templates.key IS 'Ключ, по которому ищется шаблон (указывает на назначение - регистрация, смена пароля и т д)';


--
-- Name: COLUMN email_templates.template; Type: COMMENT; Schema: public; Owner: rcp
--

COMMENT ON COLUMN email_templates.template IS 'Шаблон с шорт-кодами {{login}} - логин юзера {{first_name}} - имя и т д';


--
-- Name: COLUMN email_templates.subject; Type: COMMENT; Schema: public; Owner: rcp
--

COMMENT ON COLUMN email_templates.subject IS 'Тема письма';


--
-- Name: email_templates_id_seq; Type: SEQUENCE; Schema: public; Owner: rcp
--

CREATE SEQUENCE email_templates_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.email_templates_id_seq OWNER TO rcp;

--
-- Name: email_templates_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rcp
--

ALTER SEQUENCE email_templates_id_seq OWNED BY email_templates.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: rcp; Tablespace: 
--

CREATE TABLE users (
    id integer NOT NULL,
    login character varying(64) NOT NULL,
    password character varying(256) NOT NULL,
    email character varying(64) NOT NULL,
    status smallint DEFAULT 0 NOT NULL,
    created timestamp without time zone,
    last_login timestamp without time zone
);


ALTER TABLE public.users OWNER TO rcp;

--
-- Name: COLUMN users.status; Type: COMMENT; Schema: public; Owner: rcp
--

COMMENT ON COLUMN users.status IS 'Статус 0 - неактивен 1 - активен 2 - блокирован 3 - смена пароля';


--
-- Name: COLUMN users.created; Type: COMMENT; Schema: public; Owner: rcp
--

COMMENT ON COLUMN users.created IS 'дата-время создания юзера';


--
-- Name: COLUMN users.last_login; Type: COMMENT; Schema: public; Owner: rcp
--

COMMENT ON COLUMN users.last_login IS 'дата последнего логина';


--
-- Name: user_id_seq; Type: SEQUENCE; Schema: public; Owner: rcp
--

CREATE SEQUENCE user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_id_seq OWNER TO rcp;

--
-- Name: user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rcp
--

ALTER SEQUENCE user_id_seq OWNED BY users.id;


--
-- Name: user_password_change; Type: TABLE; Schema: public; Owner: rcp; Tablespace: 
--

CREATE TABLE user_password_change (
    id integer NOT NULL,
    token character varying(256) NOT NULL,
    created timestamp without time zone NOT NULL,
    user_id integer NOT NULL
);


ALTER TABLE public.user_password_change OWNER TO rcp;

--
-- Name: TABLE user_password_change; Type: COMMENT; Schema: public; Owner: rcp
--

COMMENT ON TABLE user_password_change IS 'Запросы на изменение пароля юзера';


--
-- Name: COLUMN user_password_change.created; Type: COMMENT; Schema: public; Owner: rcp
--

COMMENT ON COLUMN user_password_change.created IS 'дата создания запроса';


--
-- Name: user_password_change_id_seq; Type: SEQUENCE; Schema: public; Owner: rcp
--

CREATE SEQUENCE user_password_change_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_password_change_id_seq OWNER TO rcp;

--
-- Name: user_password_change_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rcp
--

ALTER SEQUENCE user_password_change_id_seq OWNED BY user_password_change.id;


--
-- Name: user_profile; Type: TABLE; Schema: public; Owner: rcp; Tablespace: 
--

CREATE TABLE user_profile (
    id integer NOT NULL,
    first_name character varying(64),
    last_name character varying(64),
    middle_name character varying(64),
    user_id integer NOT NULL,
    occupation character varying(64),
    phone character varying(32)
);


ALTER TABLE public.user_profile OWNER TO rcp;

--
-- Name: TABLE user_profile; Type: COMMENT; Schema: public; Owner: rcp
--

COMMENT ON TABLE user_profile IS 'Добавочная информация о юзере';


--
-- Name: COLUMN user_profile.first_name; Type: COMMENT; Schema: public; Owner: rcp
--

COMMENT ON COLUMN user_profile.first_name IS 'Имя';


--
-- Name: COLUMN user_profile.last_name; Type: COMMENT; Schema: public; Owner: rcp
--

COMMENT ON COLUMN user_profile.last_name IS 'Фамилия';


--
-- Name: COLUMN user_profile.middle_name; Type: COMMENT; Schema: public; Owner: rcp
--

COMMENT ON COLUMN user_profile.middle_name IS 'Отчество';


--
-- Name: COLUMN user_profile.occupation; Type: COMMENT; Schema: public; Owner: rcp
--

COMMENT ON COLUMN user_profile.occupation IS 'должность пользователя';


--
-- Name: COLUMN user_profile.phone; Type: COMMENT; Schema: public; Owner: rcp
--

COMMENT ON COLUMN user_profile.phone IS 'телефон пользователя';


--
-- Name: user_profile_id_seq; Type: SEQUENCE; Schema: public; Owner: rcp
--

CREATE SEQUENCE user_profile_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_profile_id_seq OWNER TO rcp;

--
-- Name: user_profile_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rcp
--

ALTER SEQUENCE user_profile_id_seq OWNED BY user_profile.id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: rcp
--

ALTER TABLE ONLY email_templates ALTER COLUMN id SET DEFAULT nextval('email_templates_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: rcp
--

ALTER TABLE ONLY user_password_change ALTER COLUMN id SET DEFAULT nextval('user_password_change_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: rcp
--

ALTER TABLE ONLY user_profile ALTER COLUMN id SET DEFAULT nextval('user_profile_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: rcp
--

ALTER TABLE ONLY users ALTER COLUMN id SET DEFAULT nextval('user_id_seq'::regclass);


--
-- Data for Name: email_templates; Type: TABLE DATA; Schema: public; Owner: rcp
--

COPY email_templates (id, key, template, subject) FROM stdin;
1	passwordChange	Здравствуйте, {{LOGIN}}! Ваш адрес электронной почты: {{TO}} был указан для изменения пароля на сайте. Перейдите по <a href='{{LINK}}'>ссылке</a> для одноразового входа на сайт. В случае, если смена пароля была инициирована не вами, проигнорируйте данное письмо C уважением, Администрация сайта.	Изменение пароля на сайте
\.


--
-- Name: email_templates_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rcp
--

SELECT pg_catalog.setval('email_templates_id_seq', 1, true);


--
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rcp
--

SELECT pg_catalog.setval('user_id_seq', 2, true);


--
-- Data for Name: user_password_change; Type: TABLE DATA; Schema: public; Owner: rcp
--

COPY user_password_change (id, token, created, user_id) FROM stdin;
\.


--
-- Name: user_password_change_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rcp
--

SELECT pg_catalog.setval('user_password_change_id_seq', 5, true);


--
-- Data for Name: user_profile; Type: TABLE DATA; Schema: public; Owner: rcp
--

COPY user_profile (id, first_name, last_name, middle_name, user_id, occupation, phone) FROM stdin;
\.


--
-- Name: user_profile_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rcp
--

SELECT pg_catalog.setval('user_profile_id_seq', 1, false);


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: rcp
--

COPY users (id, login, password, email, status, created, last_login) FROM stdin;
1	admin	9563d542654b05fc1295a9ddb553ca97	kopych888@gmail.com	1	2014-04-24 16:00:47	2014-04-25 10:24:22
2	user	e3ceb5881a0a1fdaad01296d7554868d	kopych888@mail.ru	1	\N	2014-04-25 14:44:06
\.


--
-- Name: PK_email_templates; Type: CONSTRAINT; Schema: public; Owner: rcp; Tablespace: 
--

ALTER TABLE ONLY email_templates
    ADD CONSTRAINT "PK_email_templates" PRIMARY KEY (id);


--
-- Name: PK_user_id; Type: CONSTRAINT; Schema: public; Owner: rcp; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT "PK_user_id" PRIMARY KEY (id);


--
-- Name: PK_user_password_change; Type: CONSTRAINT; Schema: public; Owner: rcp; Tablespace: 
--

ALTER TABLE ONLY user_password_change
    ADD CONSTRAINT "PK_user_password_change" PRIMARY KEY (id);


--
-- Name: PK_user_profile; Type: CONSTRAINT; Schema: public; Owner: rcp; Tablespace: 
--

ALTER TABLE ONLY user_profile
    ADD CONSTRAINT "PK_user_profile" PRIMARY KEY (id);


--
-- Name: FK_user_password_change; Type: FK CONSTRAINT; Schema: public; Owner: rcp
--

ALTER TABLE ONLY user_password_change
    ADD CONSTRAINT "FK_user_password_change" FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: FK_user_profile; Type: FK CONSTRAINT; Schema: public; Owner: rcp
--

ALTER TABLE ONLY user_profile
    ADD CONSTRAINT "FK_user_profile" FOREIGN KEY (user_id) REFERENCES users(id) MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


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

