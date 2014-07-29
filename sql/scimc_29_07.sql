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
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: -
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: acl_permissions; Type: TABLE; Schema: public; Owner: -; Tablespace: 
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


--
-- Name: acl_permissions_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE acl_permissions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: acl_permissions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE acl_permissions_id_seq OWNED BY acl_permissions.id;


--
-- Name: acl_roles; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE acl_roles (
    id integer NOT NULL,
    name character varying(140) NOT NULL,
    built_in smallint DEFAULT 0
);


--
-- Name: TABLE acl_roles; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE acl_roles IS 'роли пользователей';


--
-- Name: COLUMN acl_roles.built_in; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN acl_roles.built_in IS 'встроенная роль или нет';


--
-- Name: acl_roles_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE acl_roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: acl_roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE acl_roles_id_seq OWNED BY acl_roles.id;


--
-- Name: acl_roles_to_permissions; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE acl_roles_to_permissions (
    roles integer NOT NULL,
    permissions integer DEFAULT nextval('acl_permissions_id_seq'::regclass) NOT NULL
);


--
-- Name: users; Type: TABLE; Schema: public; Owner: -; Tablespace: 
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


--
-- Name: COLUMN users.status; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN users.status IS 'Статус 0 - неактивен 1 - активен 2 - блокирован 3 - смена пароля';


--
-- Name: COLUMN users.created; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN users.created IS 'дата-время создания юзера';


--
-- Name: COLUMN users.last_login; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN users.last_login IS 'дата последнего логина';


--
-- Name: COLUMN users.built_in; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN users.built_in IS 'встроенный юзер или нет';


--
-- Name: user_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE user_id_seq OWNED BY users.id;


--
-- Name: acl_users_to_roles; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE acl_users_to_roles (
    users integer DEFAULT nextval('user_id_seq'::regclass) NOT NULL,
    roles integer NOT NULL
);


--
-- Name: email_templates; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE email_templates (
    id integer NOT NULL,
    key character varying(32) NOT NULL,
    template text NOT NULL,
    subject character varying(256)
);


--
-- Name: TABLE email_templates; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE email_templates IS 'шаблоны писем для отправки юзерам';


--
-- Name: COLUMN email_templates.key; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN email_templates.key IS 'Ключ, по которому ищется шаблон (указывает на назначение - регистрация, смена пароля и т д)';


--
-- Name: COLUMN email_templates.template; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN email_templates.template IS 'Шаблон с шорт-кодами {{login}} - логин юзера {{first_name}} - имя и т д';


--
-- Name: COLUMN email_templates.subject; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN email_templates.subject IS 'Тема письма';


--
-- Name: email_templates_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE email_templates_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: email_templates_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE email_templates_id_seq OWNED BY email_templates.id;


--
-- Name: log; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE log (
    id integer NOT NULL,
    category character varying(140),
    importance character varying(140),
    text text,
    url character varying(140),
    "timestamp" timestamp without time zone
);


--
-- Name: TABLE log; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE log IS 'Логи событий';


--
-- Name: log_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE log_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: log_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE log_id_seq OWNED BY log.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE migrations (
    version character varying(255) NOT NULL
);


--
-- Name: user_activation; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE user_activation (
    user_id integer NOT NULL,
    token character varying(140),
    id integer NOT NULL
);


--
-- Name: TABLE user_activation; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE user_activation IS 'активация юзеров';


--
-- Name: COLUMN user_activation.token; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN user_activation.token IS 'активационный токен';


--
-- Name: user_activation_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE user_activation_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: user_activation_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE user_activation_id_seq OWNED BY user_activation.id;


--
-- Name: user_password_change; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE user_password_change (
    id integer NOT NULL,
    token character varying(256) NOT NULL,
    created timestamp without time zone NOT NULL,
    user_id integer NOT NULL
);


--
-- Name: TABLE user_password_change; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE user_password_change IS 'Запросы на изменение пароля юзера';


--
-- Name: COLUMN user_password_change.created; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN user_password_change.created IS 'дата создания запроса';


--
-- Name: user_password_change_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE user_password_change_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: user_password_change_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE user_password_change_id_seq OWNED BY user_password_change.id;


--
-- Name: user_profile; Type: TABLE; Schema: public; Owner: -; Tablespace: 
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


--
-- Name: TABLE user_profile; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE user_profile IS 'Добавочная информация о юзере';


--
-- Name: COLUMN user_profile.first_name; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN user_profile.first_name IS 'Имя';


--
-- Name: COLUMN user_profile.last_name; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN user_profile.last_name IS 'Фамилия';


--
-- Name: COLUMN user_profile.middle_name; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN user_profile.middle_name IS 'Отчество';


--
-- Name: COLUMN user_profile.occupation; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN user_profile.occupation IS 'должность пользователя';


--
-- Name: COLUMN user_profile.phone; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN user_profile.phone IS 'телефон пользователя';


--
-- Name: user_profile_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE user_profile_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: user_profile_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE user_profile_id_seq OWNED BY user_profile.id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY acl_permissions ALTER COLUMN id SET DEFAULT nextval('acl_permissions_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY acl_roles ALTER COLUMN id SET DEFAULT nextval('acl_roles_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY email_templates ALTER COLUMN id SET DEFAULT nextval('email_templates_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY log ALTER COLUMN id SET DEFAULT nextval('log_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY user_activation ALTER COLUMN id SET DEFAULT nextval('user_activation_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY user_password_change ALTER COLUMN id SET DEFAULT nextval('user_password_change_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY user_profile ALTER COLUMN id SET DEFAULT nextval('user_profile_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY users ALTER COLUMN id SET DEFAULT nextval('user_id_seq'::regclass);


--
-- Data for Name: acl_permissions; Type: TABLE DATA; Schema: public; Owner: -
--

COPY acl_permissions (id, controller, action, description, system, exclude, grp) FROM stdin;
1	Application\\Controller\\Index	index	Доступ к главной странице приложения	0	1	homepage
5	User\\Controller\\Password	sendpass	Доступ к форме "Забыл пароль"	0	0	user
6	User\\Controller\\Password	new	Восстановление пароля по ссылке	0	0	user
7	User\\Controller\\Profile	index	Просмотр своего профайла	0	0	user
8	User\\Controller\\Profile	edit	Редактирование своего профайла	0	0	user
9	Acl\\Controller\\Acl	index	Доступ к странице управления разрешениями	0	0	admin
10	Acl\\Controller\\Acl	update	Обновление разрешений в БД	0	0	admin
11	Acl\\Controller\\Acl	edit	Редактирование свойств разрешения	0	0	admin
13	Acl\\Controller\\Permissions	index	Доступ к странице изменений прав ролей	0	0	admin
14	Acl\\Controller\\Acl	delete	Удаление разрешения из БД	0	0	admin
2	User\\Controller\\Login	login	Вход на страницу логина	0	1	user
3	User\\Controller\\Login	authenticate	Авторизация пользователя	0	1	user
4	User\\Controller\\Login	logout	Выход из учетной записи	0	1	user
15	User\\Controller\\Admin	index	Доступ к разделу "управление пользователями"	0	0	admin
16	User\\Controller\\Admin	edit	Редактирование профиля любого пользователя	0	0	admin
17	User\\Controller\\Admin	toadmin	Предоставление пользователю прав системного администратора	0	0	admin
18	User\\Controller\\Admin	delete	Удаление любого пользователя	0	0	admin
19	User\\Controller\\Admin	group	Групповые операции с пользователями	0	0	admin
20	Acl\\Controller\\Permissions	save	Изменение разрешений ролей	0	0	admin
21	Acl\\Controller\\Role	index	Доступ к странице управления ролями	0	0	admin
22	Acl\\Controller\\Role	add	Создание ролей	0	0	admin
23	Acl\\Controller\\Role	edit	Редактирование ролей	0	0	admin
24	Acl\\Controller\\Role	delete	Удаление ролей	0	0	admin
25	Admin\\Controller\\Index	index	Доступ к панели администратора	0	0	
26	User\\Controller\\Admin	add	Добавить пользователя	0	0	admin
32	Log\\Controller\\Log	index	Тест логов	0	1	homepage
33	Log\\Controller\\Log	add	Добавить лог	0	1	admin
34	User\\Controller\\Register	register	Регистрация	0	0	user
36	User\\Controller\\Register	activate	Активация учетной записи	0	0	user
\.


--
-- Name: acl_permissions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('acl_permissions_id_seq', 36, true);


--
-- Data for Name: acl_roles; Type: TABLE DATA; Schema: public; Owner: -
--

COPY acl_roles (id, name, built_in) FROM stdin;
1	Администратор	1
2	Пользователь	1
3	Гость	1
5	Заказчик	0
6	111	0
\.


--
-- Name: acl_roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('acl_roles_id_seq', 6, true);


--
-- Data for Name: acl_roles_to_permissions; Type: TABLE DATA; Schema: public; Owner: -
--

COPY acl_roles_to_permissions (roles, permissions) FROM stdin;
2	8
2	7
3	5
3	6
3	34
3	36
5	25
5	15
\.


--
-- Data for Name: acl_users_to_roles; Type: TABLE DATA; Schema: public; Owner: -
--

COPY acl_users_to_roles (users, roles) FROM stdin;
2	5
3	5
4	5
5	5
1	1
12	5
\.


--
-- Data for Name: email_templates; Type: TABLE DATA; Schema: public; Owner: -
--

COPY email_templates (id, key, template, subject) FROM stdin;
1	passwordChange	Здравствуйте, {{LOGIN}}! Ваш адрес электронной почты: {{TO}} был указан для изменения пароля на сайте. Перейдите по <a href='{{LINK}}'>ссылке</a> для одноразового входа на сайт. В случае, если смена пароля была инициирована не вами, проигнорируйте данное письмо C уважением, Администрация сайта.	Изменение пароля на сайте
3	emailChangeTo	Здравствуйте, {{LOGIN}}! Для Вашей учетной записи был изменен адрес электронной почты с адреса {{OLDEMAIL}} на этот. Если это действие было совершено не Вами, срочно свяжитесь с Администрацией сайта. C уважением, Администрация сайта.	Изменение email адреса учетной записи
2	emailChangeFrom	Здравствуйте, {{LOGIN}}! Для Вашей учетной записи был изменен адрес электронной почты на {{EMAIL}}. Если это действие было совершено не Вами, срочно свяжитесь с Администрацией сайта. C уважением, Администрация сайта.	Изменение email адреса учетной записи
4	activationLink	Здравствуйте, {{LOGIN}}! На Ваш электронный адрес была зарегистрирована учетная запись. Для успешной активации, пройдите <a href="{{LINK}}" target="_blank">по ссылке</a>. Ссылка действительна в течение 7 дней. C уважением, Администрация сайта.	Активация учетной записи
\.


--
-- Name: email_templates_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('email_templates_id_seq', 4, true);


--
-- Data for Name: log; Type: TABLE DATA; Schema: public; Owner: -
--

COPY log (id, category, importance, text, url, "timestamp") FROM stdin;
2	admin	notififcation	Разблокированы пользователи: 2, 3, 4	http://scimc/admin/users/group	2014-07-24 17:23:47
3	admin	notififcation	Разблокированы пользователи: 2, 3, 4	http://scimc/admin/users/group	2014-07-24 17:43:02
\.


--
-- Name: log_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('log_id_seq', 3, true);


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: -
--

COPY migrations (version) FROM stdin;
\.


--
-- Data for Name: user_activation; Type: TABLE DATA; Schema: public; Owner: -
--

COPY user_activation (user_id, token, id) FROM stdin;
18	b270e0e71a43afcc622ca31f1878a3282beef062	2
19	8835f592edba95dfd076a5582d365188f45b9966	3
20	97175e430e8f713709fbf5d39598e3261457a03f	4
\.


--
-- Name: user_activation_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('user_activation_id_seq', 5, true);


--
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('user_id_seq', 21, true);


--
-- Data for Name: user_password_change; Type: TABLE DATA; Schema: public; Owner: -
--

COPY user_password_change (id, token, created, user_id) FROM stdin;
\.


--
-- Name: user_password_change_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('user_password_change_id_seq', 6, true);


--
-- Data for Name: user_profile; Type: TABLE DATA; Schema: public; Owner: -
--

COPY user_profile (id, first_name, last_name, middle_name, user_id, occupation, phone) FROM stdin;
3	Владимир	Копычев	Александрович	1	Веб-разработчик	9957501
4	Иван1	sfdrgsgsrg	Иваныч111212	2	Слесарь	777-00-710
13	asdfasd121210	fdhdfghgd		3		
14	tfyhtfd12	fthutfdh	tfhjudtrh	4		
21	test	ewfwef		12		
24				15		
27				18		
28				19		
29				20		
30				21		
\.


--
-- Name: user_profile_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('user_profile_id_seq', 30, true);


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: -
--

COPY users (id, login, password, email, status, created, last_login, grp, built_in) FROM stdin;
2	user1		v.kopychev@alekongroup.ru	1	\N	2014-04-29 17:28:41	\N	0
3	user2	098f6bcd4621d373cade4e832627b4f6	user2@imc.spb.ru	1	\N	\N	\N	0
4	user3	b51e8dbebd4ba8a8f342190a4b9f08d7	user33@imc.spb.ru	1	\N	\N	\N	0
12	test	e10adc3949ba59abbe56e057f20f883e	test@test.ru	1	2014-05-20 15:34:09	2014-07-28 15:10:22	\N	0
5	user4	b59c67bf196a4758191e42f76670ceba	user4@imc.spb.ru	3	\N	\N	\N	0
15	testtest	e10adc3949ba59abbe56e057f20f883e	sfhbetjhretj@mail.ru	0	2014-07-28 16:12:11	\N	\N	0
18	qwert	a384b6463fc216a5f8ecb6670f86456a	etgrwygter@yandex.ru	0	2014-07-28 17:46:28	\N	\N	0
19	qwert	a384b6463fc216a5f8ecb6670f86456a	etgrwygter@yandex.ru	0	2014-07-28 17:46:40	\N	\N	0
20	qwert	a384b6463fc216a5f8ecb6670f86456a	etgrwygter@yandex.ru	0	2014-07-28 17:46:53	\N	\N	0
1	admin	609dd60febf9b92772caf9e97c2d9523	kopych888@gmail.com	1	2014-04-24 16:00:47	2014-07-29 13:28:38	\N	1
21	active	4297f44b13955235245b2497399d7a93	saefefewafewagbre@gmail.com	1	2014-07-29 13:24:57	\N	\N	0
\.


--
-- Name: PK_acl_role; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY acl_roles
    ADD CONSTRAINT "PK_acl_role" PRIMARY KEY (id);


--
-- Name: PK_email_templates; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY email_templates
    ADD CONSTRAINT "PK_email_templates" PRIMARY KEY (id);


--
-- Name: PK_user_id; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT "PK_user_id" PRIMARY KEY (id);


--
-- Name: PK_user_password_change; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY user_password_change
    ADD CONSTRAINT "PK_user_password_change" PRIMARY KEY (id);


--
-- Name: PK_user_profile; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY user_profile
    ADD CONSTRAINT "PK_user_profile" PRIMARY KEY (id);


--
-- Name: acl_permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY acl_permissions
    ADD CONSTRAINT acl_permissions_pkey PRIMARY KEY (id);


--
-- Name: acl_roles_to_permissions_pk; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY acl_roles_to_permissions
    ADD CONSTRAINT acl_roles_to_permissions_pk PRIMARY KEY (roles, permissions);


--
-- Name: acl_users_to_roles_pk; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY acl_users_to_roles
    ADD CONSTRAINT acl_users_to_roles_pk PRIMARY KEY (users, roles);


--
-- Name: log_pk; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY log
    ADD CONSTRAINT log_pk PRIMARY KEY (id);


--
-- Name: migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (version);


--
-- Name: user_activation_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY user_activation
    ADD CONSTRAINT user_activation_pkey PRIMARY KEY (id);


--
-- Name: FK_user_password_change; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY user_password_change
    ADD CONSTRAINT "FK_user_password_change" FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: FK_user_profile; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY user_profile
    ADD CONSTRAINT "FK_user_profile" FOREIGN KEY (user_id) REFERENCES users(id) MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: acl_permissions_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY acl_roles_to_permissions
    ADD CONSTRAINT acl_permissions_fk FOREIGN KEY (permissions) REFERENCES acl_permissions(id) MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: acl_roles_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY acl_roles_to_permissions
    ADD CONSTRAINT acl_roles_fk FOREIGN KEY (roles) REFERENCES acl_roles(id) MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: acl_roles_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY acl_users_to_roles
    ADD CONSTRAINT acl_roles_fk FOREIGN KEY (roles) REFERENCES acl_roles(id) MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: user_activation_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY user_activation
    ADD CONSTRAINT user_activation_user_id_fkey FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: users_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY acl_users_to_roles
    ADD CONSTRAINT users_fk FOREIGN KEY (users) REFERENCES users(id) MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

