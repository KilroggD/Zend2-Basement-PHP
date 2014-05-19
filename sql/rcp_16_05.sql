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
-- Name: acl_permissions; Type: TABLE; Schema: public; Owner: rcp; Tablespace: 
--

CREATE TABLE acl_permissions (
    id integer NOT NULL,
    controller character varying(255) NOT NULL,
    action character varying(255),
    description character varying(255),
    system smallint DEFAULT 0,
    exclude smallint DEFAULT 0,
    grp character varying(140)
);


ALTER TABLE public.acl_permissions OWNER TO rcp;

--
-- Name: acl_permissions_id_seq; Type: SEQUENCE; Schema: public; Owner: rcp
--

CREATE SEQUENCE acl_permissions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.acl_permissions_id_seq OWNER TO rcp;

--
-- Name: acl_permissions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rcp
--

ALTER SEQUENCE acl_permissions_id_seq OWNED BY acl_permissions.id;


--
-- Name: acl_roles; Type: TABLE; Schema: public; Owner: rcp; Tablespace: 
--

CREATE TABLE acl_roles (
    id integer NOT NULL,
    name character varying(140) NOT NULL,
    built_in smallint DEFAULT 0
);


ALTER TABLE public.acl_roles OWNER TO rcp;

--
-- Name: TABLE acl_roles; Type: COMMENT; Schema: public; Owner: rcp
--

COMMENT ON TABLE acl_roles IS 'роли пользователей';


--
-- Name: COLUMN acl_roles.built_in; Type: COMMENT; Schema: public; Owner: rcp
--

COMMENT ON COLUMN acl_roles.built_in IS 'встроенная роль или нет';


--
-- Name: acl_roles_id_seq; Type: SEQUENCE; Schema: public; Owner: rcp
--

CREATE SEQUENCE acl_roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.acl_roles_id_seq OWNER TO rcp;

--
-- Name: acl_roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rcp
--

ALTER SEQUENCE acl_roles_id_seq OWNED BY acl_roles.id;


--
-- Name: acl_roles_to_permissions; Type: TABLE; Schema: public; Owner: rcp; Tablespace: 
--

CREATE TABLE acl_roles_to_permissions (
    roles integer NOT NULL,
    permissions integer DEFAULT nextval('acl_permissions_id_seq'::regclass) NOT NULL
);


ALTER TABLE public.acl_roles_to_permissions OWNER TO rcp;

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
    last_login timestamp without time zone,
    grp integer,
    built_in smallint DEFAULT 0
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
-- Name: COLUMN users.built_in; Type: COMMENT; Schema: public; Owner: rcp
--

COMMENT ON COLUMN users.built_in IS 'встроенный юзер или нет';


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
-- Name: acl_users_to_roles; Type: TABLE; Schema: public; Owner: rcp; Tablespace: 
--

CREATE TABLE acl_users_to_roles (
    users integer DEFAULT nextval('user_id_seq'::regclass) NOT NULL,
    roles integer NOT NULL
);


ALTER TABLE public.acl_users_to_roles OWNER TO rcp;

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
-- Name: migrations; Type: TABLE; Schema: public; Owner: rcp; Tablespace: 
--

CREATE TABLE migrations (
    version character varying(255) NOT NULL
);


ALTER TABLE public.migrations OWNER TO rcp;

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

ALTER TABLE ONLY acl_permissions ALTER COLUMN id SET DEFAULT nextval('acl_permissions_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: rcp
--

ALTER TABLE ONLY acl_roles ALTER COLUMN id SET DEFAULT nextval('acl_roles_id_seq'::regclass);


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
-- Data for Name: acl_permissions; Type: TABLE DATA; Schema: public; Owner: rcp
--

COPY acl_permissions (id, controller, action, description, system, exclude, grp) FROM stdin;
1	Application\\Controller\\Index	index	Доступ к главной странице приложения	0	1	homepage
2	User\\Controller\\Login	login	Вход на страницу логина	0	0	user
3	User\\Controller\\Login	authenticate	Авторизация пользователя	0	0	user
4	User\\Controller\\Login	logout	Выход из учетной записи	0	0	user
5	User\\Controller\\Password	sendpass	Доступ к форме "Забыл пароль"	0	0	user
6	User\\Controller\\Password	new	Восстановление пароля по ссылке	0	0	user
7	User\\Controller\\Profile	index	Просмотр своего профайла	0	0	user
8	User\\Controller\\Profile	edit	Редактирование своего профайла	0	0	user
9	Acl\\Controller\\Acl	index	Доступ к странице управления разрешениями	0	0	admin
10	Acl\\Controller\\Acl	update	Обновление разрешений в БД	0	0	admin
11	Acl\\Controller\\Acl	edit	Редактирование свойств разрешения	0	0	admin
13	Acl\\Controller\\Permissions	index	Доступ к странице изменений прав ролей	0	0	admin
14	Acl\\Controller\\Acl	delete	Удаление разрешения из БД	0	0	admin
\.


--
-- Name: acl_permissions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rcp
--

SELECT pg_catalog.setval('acl_permissions_id_seq', 14, true);


--
-- Data for Name: acl_roles; Type: TABLE DATA; Schema: public; Owner: rcp
--

COPY acl_roles (id, name, built_in) FROM stdin;
1	Администратор	1
2	Пользователь	1
3	Гость	1
5	Заказчик	0
4	Тестировщик1	0
\.


--
-- Name: acl_roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rcp
--

SELECT pg_catalog.setval('acl_roles_id_seq', 5, true);


--
-- Data for Name: acl_roles_to_permissions; Type: TABLE DATA; Schema: public; Owner: rcp
--

COPY acl_roles_to_permissions (roles, permissions) FROM stdin;
5	11
5	10
4	10
\.


--
-- Data for Name: acl_users_to_roles; Type: TABLE DATA; Schema: public; Owner: rcp
--

COPY acl_users_to_roles (users, roles) FROM stdin;
2	5
3	5
3	4
4	5
5	5
2	4
1	1
\.


--
-- Data for Name: email_templates; Type: TABLE DATA; Schema: public; Owner: rcp
--

COPY email_templates (id, key, template, subject) FROM stdin;
1	passwordChange	Здравствуйте, {{LOGIN}}! Ваш адрес электронной почты: {{TO}} был указан для изменения пароля на сайте. Перейдите по <a href='{{LINK}}'>ссылке</a> для одноразового входа на сайт. В случае, если смена пароля была инициирована не вами, проигнорируйте данное письмо C уважением, Администрация сайта.	Изменение пароля на сайте
3	emailChangeTo	Здравствуйте, {{LOGIN}}! Для Вашей учетной записи был изменен адрес электронной почты с адреса {{OLDEMAIL}} на этот. Если это действие было совершено не Вами, срочно свяжитесь с Администрацией сайта. C уважением, Администрация сайта.	Изменение email адреса учетной записи
2	emailChangeFrom	Здравствуйте, {{LOGIN}}! Для Вашей учетной записи был изменен адрес электронной почты на {{EMAIL}}. Если это действие было совершено не Вами, срочно свяжитесь с Администрацией сайта. C уважением, Администрация сайта.	Изменение email адреса учетной записи
\.


--
-- Name: email_templates_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rcp
--

SELECT pg_catalog.setval('email_templates_id_seq', 3, true);


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: rcp
--

COPY migrations (version) FROM stdin;
\.


--
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rcp
--

SELECT pg_catalog.setval('user_id_seq', 6, true);


--
-- Data for Name: user_password_change; Type: TABLE DATA; Schema: public; Owner: rcp
--

COPY user_password_change (id, token, created, user_id) FROM stdin;
\.


--
-- Name: user_password_change_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rcp
--

SELECT pg_catalog.setval('user_password_change_id_seq', 6, true);


--
-- Data for Name: user_profile; Type: TABLE DATA; Schema: public; Owner: rcp
--

COPY user_profile (id, first_name, last_name, middle_name, user_id, occupation, phone) FROM stdin;
3	Владимир	Копычев	Александрович	1	Веб-разработчик	9957501
4	Иван	sfdrgsgsrg	Иваныч111212	2	Слесарь	777-00-710
13	dgfdgdg	fdhdfghgd		3		
14	tfyhtfd	fthutfdh	tfhjudtrh	4		
\.


--
-- Name: user_profile_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rcp
--

SELECT pg_catalog.setval('user_profile_id_seq', 15, true);


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: rcp
--

COPY users (id, login, password, email, status, created, last_login, grp, built_in) FROM stdin;
1	admin	609dd60febf9b92772caf9e97c2d9523	kopych888@gmail.com	1	2014-04-24 16:00:47	2014-05-05 10:28:05	\N	1
3	user2	b59c67bf196a4758191e42f76670ceba	user2@imc.spb.ru	1	\N	\N	\N	0
4	user3	b59c67bf196a4758191e42f76670ceba	user3@imc.spb.ru	3	\N	\N	\N	0
5	user4	b59c67bf196a4758191e42f76670ceba	user4@imc.spb.ru	3	\N	\N	\N	0
2	user1	3d186804534370c3c817db0563f0e461	v.kopychev@alekongroup.ru	0	\N	2014-04-29 17:28:41	\N	0
\.


--
-- Name: PK_acl_role; Type: CONSTRAINT; Schema: public; Owner: rcp; Tablespace: 
--

ALTER TABLE ONLY acl_roles
    ADD CONSTRAINT "PK_acl_role" PRIMARY KEY (id);


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
-- Name: acl_permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: rcp; Tablespace: 
--

ALTER TABLE ONLY acl_permissions
    ADD CONSTRAINT acl_permissions_pkey PRIMARY KEY (id);


--
-- Name: acl_roles_to_permissions_pk; Type: CONSTRAINT; Schema: public; Owner: rcp; Tablespace: 
--

ALTER TABLE ONLY acl_roles_to_permissions
    ADD CONSTRAINT acl_roles_to_permissions_pk PRIMARY KEY (roles, permissions);


--
-- Name: acl_users_to_roles_pk; Type: CONSTRAINT; Schema: public; Owner: rcp; Tablespace: 
--

ALTER TABLE ONLY acl_users_to_roles
    ADD CONSTRAINT acl_users_to_roles_pk PRIMARY KEY (users, roles);


--
-- Name: migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: rcp; Tablespace: 
--

ALTER TABLE ONLY migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (version);


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
-- Name: acl_permissions_fk; Type: FK CONSTRAINT; Schema: public; Owner: rcp
--

ALTER TABLE ONLY acl_roles_to_permissions
    ADD CONSTRAINT acl_permissions_fk FOREIGN KEY (permissions) REFERENCES acl_permissions(id) MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: acl_roles_fk; Type: FK CONSTRAINT; Schema: public; Owner: rcp
--

ALTER TABLE ONLY acl_roles_to_permissions
    ADD CONSTRAINT acl_roles_fk FOREIGN KEY (roles) REFERENCES acl_roles(id) MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: acl_roles_fk; Type: FK CONSTRAINT; Schema: public; Owner: rcp
--

ALTER TABLE ONLY acl_users_to_roles
    ADD CONSTRAINT acl_roles_fk FOREIGN KEY (roles) REFERENCES acl_roles(id) MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: users_fk; Type: FK CONSTRAINT; Schema: public; Owner: rcp
--

ALTER TABLE ONLY acl_users_to_roles
    ADD CONSTRAINT users_fk FOREIGN KEY (users) REFERENCES users(id) MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;
GRANT ALL ON SCHEMA public TO rcp;


--
-- PostgreSQL database dump complete
--

