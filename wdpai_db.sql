--
-- PostgreSQL database dump
--

-- Dumped from database version 17.2 (Debian 17.2-1.pgdg120+1)
-- Dumped by pg_dump version 17.2 (Debian 17.2-1.pgdg120+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: before_insert_workout(); Type: FUNCTION; Schema: public; Owner: root
--

CREATE FUNCTION public.before_insert_workout() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    -- Sprawdzenie, jaka jest obecna wartość ID w tabeli
    PERFORM setval('workouts_id_seq', COALESCE(MAX(id), 0)) FROM public.workouts;
    RETURN NEW;  -- Jeśli wszystko w porządku, pozwól na wstawienie nowego rekordu
END;
$$;


ALTER FUNCTION public.before_insert_workout() OWNER TO root;

--
-- Name: delete_related_workout_exercises(); Type: FUNCTION; Schema: public; Owner: root
--

CREATE FUNCTION public.delete_related_workout_exercises() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    DELETE FROM workout_exercises WHERE workout_id = OLD.id;
    RETURN OLD;
END;
$$;


ALTER FUNCTION public.delete_related_workout_exercises() OWNER TO root;

--
-- Name: reset_workout_sequence(); Type: FUNCTION; Schema: public; Owner: root
--

CREATE FUNCTION public.reset_workout_sequence() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    PERFORM setval('workouts_id_seq', COALESCE(MAX(id), 0)) FROM public.workouts;
    RETURN NULL;
END;
$$;


ALTER FUNCTION public.reset_workout_sequence() OWNER TO root;

--
-- Name: set_default_user_role(); Type: FUNCTION; Schema: public; Owner: root
--

CREATE FUNCTION public.set_default_user_role() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF NEW.user_role IS NULL THEN
        NEW.user_role := 'user';
    END IF;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.set_default_user_role() OWNER TO root;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: exercises; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.exercises (
    id integer NOT NULL,
    name character varying(50) NOT NULL,
    photo_path text,
    description text,
    category_id integer,
    difficulty character varying(50)
);


ALTER TABLE public.exercises OWNER TO root;

--
-- Name: workout_exercises; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.workout_exercises (
    id integer NOT NULL,
    workout_id integer,
    exercise_id integer,
    sets integer NOT NULL,
    reps integer[] NOT NULL,
    weight numeric(10,2),
    notes text
);


ALTER TABLE public.workout_exercises OWNER TO root;

--
-- Name: workouts; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.workouts (
    id integer NOT NULL,
    user_id integer,
    name character varying(100) NOT NULL,
    date date NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.workouts OWNER TO root;

--
-- Name: all_workout_exercises; Type: VIEW; Schema: public; Owner: root
--

CREATE VIEW public.all_workout_exercises AS
 SELECT w.name AS workout_name,
    e.name AS exercise_name,
    we.sets,
    we.reps,
    we.weight,
    we.notes
   FROM ((public.workout_exercises we
     JOIN public.workouts w ON ((w.id = we.workout_id)))
     JOIN public.exercises e ON ((we.exercise_id = e.id)));


ALTER VIEW public.all_workout_exercises OWNER TO root;

--
-- Name: categories; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.categories (
    id integer NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE public.categories OWNER TO root;

--
-- Name: categories_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE public.categories_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.categories_id_seq OWNER TO root;

--
-- Name: categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: root
--

ALTER SEQUENCE public.categories_id_seq OWNED BY public.categories.id;


--
-- Name: exercises_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE public.exercises_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.exercises_id_seq OWNER TO root;

--
-- Name: exercises_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: root
--

ALTER SEQUENCE public.exercises_id_seq OWNED BY public.exercises.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.users (
    id integer NOT NULL,
    name character varying(100) NOT NULL,
    surname character varying(100) NOT NULL,
    email character varying(100) NOT NULL,
    password character varying(100) NOT NULL,
    user_role text
);


ALTER TABLE public.users OWNER TO root;

--
-- Name: total_workouts; Type: VIEW; Schema: public; Owner: root
--

CREATE VIEW public.total_workouts AS
 SELECT u.name,
    u.surname,
    count(w.name) AS total_workouts
   FROM (public.workouts w
     JOIN public.users u ON ((w.user_id = u.id)))
  GROUP BY w.user_id, u.name, u.surname;


ALTER VIEW public.total_workouts OWNER TO root;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO root;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: root
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: workout_exercises_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE public.workout_exercises_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.workout_exercises_id_seq OWNER TO root;

--
-- Name: workout_exercises_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: root
--

ALTER SEQUENCE public.workout_exercises_id_seq OWNED BY public.workout_exercises.id;


--
-- Name: workouts_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE public.workouts_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.workouts_id_seq OWNER TO root;

--
-- Name: workouts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: root
--

ALTER SEQUENCE public.workouts_id_seq OWNED BY public.workouts.id;


--
-- Name: categories id; Type: DEFAULT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.categories ALTER COLUMN id SET DEFAULT nextval('public.categories_id_seq'::regclass);


--
-- Name: exercises id; Type: DEFAULT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.exercises ALTER COLUMN id SET DEFAULT nextval('public.exercises_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Name: workout_exercises id; Type: DEFAULT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.workout_exercises ALTER COLUMN id SET DEFAULT nextval('public.workout_exercises_id_seq'::regclass);


--
-- Name: workouts id; Type: DEFAULT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.workouts ALTER COLUMN id SET DEFAULT nextval('public.workouts_id_seq'::regclass);


--
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.categories (id, name) FROM stdin;
1	Chest
2	Quads
3	Hamstrings
4	Calves
5	Glutes
6	Core
7	Back
8	Shoulders
9	Biceps
10	Triceps
\.


--
-- Data for Name: exercises; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.exercises (id, name, photo_path, description, category_id, difficulty) FROM stdin;
9	Bicep Curl	/images/bicep-curl.jpg	An isolated exercise for strengthening the biceps.	9	Beginner
8	Shoulder Press	/images/shoulder-press.jpg	An exercise for building shoulder strength using weights.	8	Intermediate
5	Pull-Up	/images/pull-up.jpg	An upper-body exercise focusing on the lats and biceps.	7	Intermediate
2	Squat	/images/squat.jpg	A fundamental lower-body exercise targeting quads, glutes, and hamstrings.	2	Beginner
1	Push-Up	/images/push-up.jpg	A basic bodyweight exercise that works the chest, shoulders, and triceps.	1	Beginner
4	Deadlift	/images/deadlift.jpg	A compound exercise targeting the back, legs, and grip strength.	7	Advanced
10	Tricep Dip	/images/tricep-dip.jpg	A bodyweight exercise for strengthening the triceps.	10	Intermediate
3	Plank	/images/plank.jpg	An isometric core exercise that strengthens the abs and lower back.	6	Intermediate
6	Bench Press	/images/bench-press.jpg	A strength-training staple that targets the chest, shoulders, and triceps.	1	Advanced
7	Lunges	/images/lunges.jpg	A single-leg bodyweight exercise focusing on quads, glutes, and balance.	2	Beginner
29	Barbell row	/images/barbell-row.jpg	Perhaps, the most famous and effective back exercises.	7	medium
30	Incline Dumbbell Press	/images/incline-dumbbell-press.jpg	Incline pressing with dumbbell in each hand on bench	1	hard
28	Lat-pulldown	/images/lat-pulldown.jpg	Self explanatory, quintessential exercise for thick and dense back.	7	easy
31	Chest Fly	/images/chest-fly.jpg	A great isolation exercise for chest development	1	easy
32	Leg Press	/images/leg-press.jpg	A machine-based exercise targeting the quads.	2	easy
37	Leg Curl	/images/leg-curl.jpeg	A machine exercise focusing on the hamstrings	3	easy
42	Romanian Deadlift	/images/romanian-deadlift.jpg	A hamstring-focused deadlift variation.	3	hard
41	Front Squat	/images/front-squat.jpg	A quad-focused variation of the traditional squat.	2	hard
38	Standing Calf Raise	/images/standing-calf-raise.jpg	A staple for strengthening and defining the calves.	4	easy
43	Lateral Raise	/images/lateral-raise.jpg	A classic isolation exercise for shoulder width.	8	medium
40	Overhead Tricep Extension	/images/overhead-tricep-extension.jpg	A tricep isolation exercise performed with a dumbbell.	10	medium
39	Hip Thrust	/images/hip-thrust.jpg	An effective glute-focused movement for power and strength.	1	medium
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.users (id, name, surname, email, password, user_role) FROM stdin;
1	Patrick	Bateman	patrickb@gmail.com	$2a$12$ABEThmtNKa.aHwDjjlKfBuz4W/rh1FjJmZLd2G.bNF957DjBw4YSK	admin
2	Nikola	Kovac	niko@gmail.com	$2y$10$SVQjKMglvEZF1xE5VplAd.ambgFmoOsgXbnGpxqTQkwiL3y5auiZW	user
\.


--
-- Data for Name: workout_exercises; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.workout_exercises (id, workout_id, exercise_id, sets, reps, weight, notes) FROM stdin;
27	13	6	3	{5,5,5}	100.00	cos
28	13	9	5	{10}	30.00	cos
36	2	4	3	{3}	100.00	cos
11	5	1	3	{8,8,8}	0.00	bw
5	2	5	5	{10,10,10,9,8}	90.00	bw
4	2	6	5	{5,5,5,5,5}	105.00	Duzy progres!
172	5	10	4	{10}	0.00	bw
173	5	3	3	{60}	0.00	bw
29	13	8	2	{10,10}	40.00	test
181	19	2	5	{5,5,5,5,5}	100.00	-
182	19	37	3	{8,8,8}	20.00	-
214	27	6	3	{12}	105.00	-
215	27	41	4	{6,6,6,6}	95.00	weak
216	27	29	4	{10,8,8,7}	105.00	-
\.


--
-- Data for Name: workouts; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.workouts (id, user_id, name, date, created_at) FROM stdin;
13	2	Góra	2025-01-20	2025-01-20 19:00:12
2	2	Klatka-plecy	2025-01-02	2025-01-05 14:02:25.116466
5	1	home-bodyweight-workout	2025-01-19	2025-01-19 00:04:59
19	2	Legs	2025-01-24	2025-01-23 23:36:59
27	1	full-body-workout	2025-01-30	2025-01-31 12:40:01
\.


--
-- Name: categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.categories_id_seq', 10, true);


--
-- Name: exercises_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.exercises_id_seq', 43, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.users_id_seq', 1, false);


--
-- Name: workout_exercises_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.workout_exercises_id_seq', 216, true);


--
-- Name: workouts_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.workouts_id_seq', 27, true);


--
-- Name: categories categories_name_key; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_name_key UNIQUE (name);


--
-- Name: categories categories_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (id);


--
-- Name: exercises exercises_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.exercises
    ADD CONSTRAINT exercises_pkey PRIMARY KEY (id);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: workout_exercises workout_exercises_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.workout_exercises
    ADD CONSTRAINT workout_exercises_pkey PRIMARY KEY (id);


--
-- Name: workouts workouts_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.workouts
    ADD CONSTRAINT workouts_pkey PRIMARY KEY (id);


--
-- Name: workouts cascade_delete_workout_exercises; Type: TRIGGER; Schema: public; Owner: root
--

CREATE TRIGGER cascade_delete_workout_exercises AFTER DELETE ON public.workouts FOR EACH ROW EXECUTE FUNCTION public.delete_related_workout_exercises();


--
-- Name: users default_user_role_assignment; Type: TRIGGER; Schema: public; Owner: root
--

CREATE TRIGGER default_user_role_assignment BEFORE INSERT ON public.users FOR EACH ROW EXECUTE FUNCTION public.set_default_user_role();


--
-- Name: exercises exercises_category_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.exercises
    ADD CONSTRAINT exercises_category_id_fkey FOREIGN KEY (category_id) REFERENCES public.categories(id) ON DELETE SET NULL;


--
-- Name: workout_exercises workout_exercises_exercise_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.workout_exercises
    ADD CONSTRAINT workout_exercises_exercise_id_fkey FOREIGN KEY (exercise_id) REFERENCES public.exercises(id) ON DELETE CASCADE;


--
-- Name: workout_exercises workout_exercises_workout_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.workout_exercises
    ADD CONSTRAINT workout_exercises_workout_id_fkey FOREIGN KEY (workout_id) REFERENCES public.workouts(id) ON DELETE CASCADE;


--
-- Name: workouts workouts_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.workouts
    ADD CONSTRAINT workouts_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

